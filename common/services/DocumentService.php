<?php

namespace common\services;

use common\models\Document;
use common\models\DocumentTemplate;
use DateTime;
use kartik\mpdf\Pdf;

class DocumentService
{
    public static function getDocumentList($document_type): array
    {
        if (!empty($document_type)) {
            return Document::find()->joinWith('template')
                ->where(['document_type' => $document_type])->asArray()->all();
        }
        else {
            return Document::find()->asArray()->all();
        }
    }

    public static function getDocument($document_id)
    {
        return Document::find()
            ->joinWith(['documentFieldValues.field'])
            ->where(['document.id' => $document_id])
            ->asArray()->all();

    }

    public static function getDocumentNumber(): string
    {
        $documents = Document::find()->where(['DATE(`created_at`)'  => date('Y-m-d')])->orderBy('id DESC')->all();
        $date = new DateTime();

        foreach ($documents as $document) {
            preg_match_all('/\b\d{2}\.\d{2}\.\d{4}\/\d{3}\b/', $document->body,$out);

            if (!empty($out[0])) {
                $num = substr($out[0][0], -3);
                $num++;
                $num = str_pad($num,  3, "0", STR_PAD_LEFT);

                return $date->format('d.m.Y') . '/' . $num;
            }
        }
        return $date->format('d.m.Y') . '/001';
    }

    public static function downloadPdf($id)
    {
        $model = Document::findOne($id);

        $pdf = new Pdf(); // or new Pdf();
        $mpdf = $pdf->api; // fetches mpdf api
        $mpdf->WriteHtml($model->body); // call mpdf write html
        echo $mpdf->Output("{$model->title}", 'D'); // call the mpdf api output as needed
    }

    public static function downloadDocx($id)
    {
        $model = Document::findOne($id);

        $pw = new \PhpOffice\PhpWord\PhpWord();

        // (B) ADD HTML CONTENT
        $section = $pw->addSection();

        $html = str_replace(array('<br/>', '<br>', '</br>'), ' ', $model->body);
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);

        $section->setStyle();

        // (D) OR FORCE DOWNLOAD
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment;filename=\"$model->title.docx\"");
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($pw, "Word2007");
        $objWriter->save("php://output");
        exit();
    }

    public static function generateDocumentBody(Document $model)
    {
        $templateModel = DocumentTemplate::findOne($model->template_id);
        preg_match_all('/(\${\w+})/', $templateModel->template_body,$out);

        $document = $templateModel->template_body;;
        foreach ($out[0] as $field) {
            if (str_contains($document, $field)) {
                switch ($field)
                {
                    case '${contract_number}':
                        $fieldValue = DocumentService::getDocumentNumber();
                        break;
                    case '${title}':
                        $fieldValue = $model->title;
                        break;
                    case '${company}':
                        $fieldValue = $model->company->name;
                        break;
                    case '${manager}':
                        $fieldValue = $model->manager->userCard->fio;
                        break;
                    case '${contractor_company}':
                        $fieldValue = $model->contractorCompany->name;
                        break;
                    case '${contractor_manager}':
                        $fieldValue = $model->contractorManager->userCard->fio;
                        break;
                    default:
                        $fieldValue = $field;
                        break;
                }
                $document = str_replace($field, $fieldValue, $document);
            }
        }
        $model->body = $document;
    }
}