<?php

namespace backend\modules\document\controllers;

use backend\modules\card\models\UserCard;
use backend\modules\document\models\DocumentTemplate;
use common\classes\Debug;
use kartik\mpdf\Pdf;
use Yii;
use backend\modules\document\models\Document;
use backend\modules\document\models\DocumentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DocumentController implements the CRUD actions for Document model.
 */
class DocumentController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Document models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocumentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Document model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Document model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Document();

        if ($model->load(Yii::$app->request->post()) &&  $model->validate()) { //  //$model->save(false)
            $this::generateDocumentBody($model);
            $model->save(false);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Document model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Document model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Document model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Document the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Document::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDownload($id): string
    {
        return $this->render('download', [
            'model' => Document::findOne($id)
        ]);
    }

    /**
     * @param integer $id
     * @throws NotFoundHttpException
     */
    public function actionUpdateDocumentBody($id)
    {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_UPDATE_DOCUMENT_BODY;

        if ($model->load(Yii::$app->request->post())  && $model->validate()) {
            $model->updated_at = date('Y-m-d h:i:s');
            $model->save();
        }

        return $this->render('download', [
            'model' => $model
        ]);
    }

    public function generateDocumentBody(Document $model)
    {
        $templateModel = DocumentTemplate::findOne($model->template_id);
        preg_match_all('/(\${\w+})/', $templateModel->template_body,$out);

        $document = $templateModel->template_body;;
        foreach ($out[0] as $field) {
            if (str_contains($document, $field)) {

                if($field == '${contract_number}') {
                    $fieldValue = 101;
                } elseif ($field == '${title}') {
                    $fieldValue = $model->title;
                } elseif ($field == '${company}') {
                    $fieldValue = $model->company->name;
                } elseif ($field == '${manager}') {
                    $fieldValue = $model->manager->userCard->fio;
                } elseif ($field == '${contractor_company}') {
                    $fieldValue = $model->company->name;
                } elseif ($field == '${contractor_manager}') {
                    $fieldValue = $model->manager->userCard->fio;
                }
            } else {
                $fieldValue = $field;
            }
            $document = str_replace($field, $fieldValue, $document);
        }
        $model->body = $document;
    }

    public function actionDownloadPdf($id)
    {
        $model = Document::findOne($id);

        $pdf = new Pdf(); // or new Pdf();
        $mpdf = $pdf->api; // fetches mpdf api
//        $mpdf->SetHeader('Resume ' . $model->ti . '||Generated by ITGuild.info At: ' . date("d/m/Y")); // call methods or set any properties
        $mpdf->SetFooter('{PAGENO}');
        $mpdf->WriteHtml($model->body); // call mpdf write html
        echo $mpdf->Output("{$model->title}", 'D'); // call the mpdf api output as needed
    }

    public function actionDownloadDocx($id)
    {
        $model = Document::findOne($id);

        $pw = new \PhpOffice\PhpWord\PhpWord();

        // (B) ADD HTML CONTENT
        $section = $pw->addSection();
        $resumeText = str_replace(array('<br/>', '<br>', '</br>'), ' ', $model->body);
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $resumeText, false, false);

        // (C) SAVE TO DOCX ON SERVER
        // $pw->save("convert.docx", "Word2007");

        // (D) OR FORCE DOWNLOAD
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment;filename=\"$model->title.docx\"");
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($pw, "Word2007");
        $objWriter->save("php://output");
        exit();
    }
}
