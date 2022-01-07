<?php

namespace backend\modules\document\controllers;

use Yii;
use backend\modules\document\models\TemplateDocumentField;
use backend\modules\document\models\TemplateDocumentFieldSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TemplateDocumentFieldController implements the CRUD actions for TemplateDocumentField model.
 */
class TemplateDocumentFieldController extends Controller
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
     * Lists all TemplateDocumentField models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TemplateDocumentFieldSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TemplateDocumentField model.
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
     * Creates a new TemplateDocumentField model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($template_id = null)
    {
        $post = \Yii::$app->request->post('TemplateDocumentField');

        if (!empty($post)) {
            $field_id_arr = ArrayHelper::getValue($post,'field_id');

            foreach ($field_id_arr as $field_id) {
                $emtModel = new TemplateDocumentField();
                $emtModel->template_id = $post['template_id'];
                $emtModel->field_id = $field_id;

                if (!$emtModel->save()) {
                    return $this->render('create', [
                        'model' => $emtModel,
                    ]);
                }
            }
            if ($template_id !== null)
            {
                return $this->redirect(['template/view', 'id' => $template_id]);
            }

            return $this->redirect(['index']);
        }

        $model = new TemplateDocumentField();
        $model->template_id = $template_id;
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TemplateDocumentField model.
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
     * Deletes an existing TemplateDocumentField model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete(int $id, $template_id = null)
    {
        $this->findModel($id)->delete();

        if ($template_id !== null)
        {
            return $this->redirect(['template/view', 'id' => $template_id]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the TemplateDocumentField model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TemplateDocumentField the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TemplateDocumentField::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
