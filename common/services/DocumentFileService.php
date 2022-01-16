<?php

namespace common\services;


use common\models\Document;
use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpWord\TemplateProcessor;
use Yii;

class DocumentFileService
{
    private $model;
    private $document;
    private $file_title;
    private $documentFieldValuesArr;

    /**
     * @throws CopyFileException
     * @throws CreateTemporaryFileException
     */
    public function __construct($modelID)
    {
        $this->model = Document::findOne($modelID);

        $this->initDocument();
    }

    /**
     * @throws CopyFileException
     * @throws CreateTemporaryFileException
     */
    private function initDocument()
    {
        $this->file_title = $this->model->title . '.docx';

        $template_title = $this->model->template->template_file_name;
        $this->document = new TemplateProcessor(
            Yii::getAlias('@templates') . "/$template_title");

        $this->documentFieldValuesArr = $this->model->documentFieldValues;
    }

    public function setFields()
    {
        foreach ($this->documentFieldValuesArr as $docFieldValue) {
            $this->document->setValue(
                $docFieldValue->field->field_template,
                $docFieldValue->value
            );
        }
    }

    public function downloadDocument()
    {
        $this->document->saveAs($this->file_title);

        // Имя скачиваемого файла
        $downloadFile = $this->file_title;
        // Контент-тип означающий скачивание
        header("Content-Type: application/octet-stream");
        // Размер в байтах
        header("Accept-Ranges: bytes");
        // Размер файла
        header("Content-Length: ".filesize($downloadFile));
        // Расположение скачиваемого файла
        header("Content-Disposition: attachment; filename=".$downloadFile);

//         Прочитать файл
        readfile($downloadFile);
        unlink($this->file_title);
    }
}