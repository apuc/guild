<?php

namespace backend\modules\document\controllers;

use common\models\DocumentField;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\ZipArchive;
use PhpOffice\PhpWord\TemplateProcessor;
use Yii;
use backend\modules\document\models\Document;
use backend\modules\document\models\DocumentSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\services\DocumentService;

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
        $model = $this->findModel($id);
        $documentFieldValuesDataProvider = new ActiveDataProvider([
            'query' => $model->getDocumentFieldValues(),//->with('questionType'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
            'documentFieldValuesDataProvider' => $documentFieldValuesDataProvider
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'document-field-value/create-multiple',
                'document_id' => $model->id,
                'template_id' => $model->template_id
            ]);
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


    public function actionCreateDocument($id)
    {
        $model = Document::findOne($id);

        $file_title = $model->title;
        $template_title = $model->template->template_file_name;



        $fieldaValueArr = $model->documentFieldValues;

        foreach ($fieldaValueArr as $tmp) {
            echo $tmp['value'];
        }

         die();


//        var_dump($file_title);
//        var_dump($template_title);
//        var_dump($fieldsArray);
//        die;
//        //, $template_name, [] $fields


        $documentService = new DocumentService($file_title, $template_title, $fieldsArray);
        $documentService->save();


//        $outputFile = 'review_full222.docx';
//
//
//        $PhpWord = new \PhpOffice\PhpWord\PhpWord();
//        $document = $PhpWord->loadTemplate('/var/www/guild.loc/backend/web/upload/templates/tets template.docx'); //шаблон
//        $document->setValue('FIO', '8888888888' );
//        $document->setValue('INN',  '999999999999999999');
//
//        $document->saveAs($outputFile);
//
//        // Имя скачиваемого файла
//        $downloadFile = $outputFile;
//
//          // Контент-тип означающий скачивание
//        header("Content-Type: application/octet-stream");
//
//        // Размер в байтах
//        header("Accept-Ranges: bytes");
//
//        // Размер файла
//        header("Content-Length: ".filesize($downloadFile));
//
//        // Расположение скачиваемого файла
//        header("Content-Disposition: attachment; filename=".$downloadFile);
//
//        // Прочитать файл
//        readfile($downloadFile);
//
//
//
//        unlink($outputFile);


    }

}
