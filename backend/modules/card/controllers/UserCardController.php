<?php

namespace backend\modules\card\controllers;

use backend\modules\card\models\UserCard;
use backend\modules\card\models\UserCardSearch;
use common\models\AchievementUserCard;
use common\models\CardSkill;
use common\models\FieldsValueNew;
use common\models\User;
use kartik\mpdf\Pdf;
use PhpOffice\PhpWord\PhpWord;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * UserCardController implements the CRUD actions for UserCard model.
 */
class UserCardController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin', 'profileEditor'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all UserCard models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserCardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPassword($id)
    {
        $user_card = UserCard::findOne($id);
        $model = User::findOne(['id' => $user_card->id_user]);

        return $this->render('password', [
            'model' => $model,
        ]);
    }

    public function actionAjax() {
        if(Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            $password = $_POST['password'];

            $user_card = UserCard::findOne($id);
            $user = User::findOne(['id' => $user_card->id_user]);
            $user->password = $password;
            $user->save();
        }
    }

    /**
     * Displays a single UserCard model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => FieldsValueNew::find()
                ->where(['item_id' => $id, 'item_type' => FieldsValueNew::TYPE_PROFILE])
                ->orderBy('order'),
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);

        $skills = CardSkill::find()->where(['card_id' => $id])->with('skill')->all();
        $achievements =
            AchievementUserCard::find()->where(['user_card_id' => $id])
                ->innerJoinWith(['achievement' => function($query) {
                    $query->andWhere(['status' => \common\models\Achievement::STATUS_ACTIVE]);
                }])
                ->all();

        $id_current_user = $this->findModel($id)->id_user;
        $changeDataProvider = new ActiveDataProvider([
            'query' => \common\models\ChangeHistory::find()->where(['type_id' => $this->findModel($id)->id]),
            'pagination' => [
                'pageSize' => 200,
            ]
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelFieldValue' => $dataProvider,
            'skills' => $skills,
            'achievements' => $achievements,
            'userData' => User::findOne($id_current_user),
            'changeDataProvider' => $changeDataProvider,
        ]);
    }

    /**
     * Creates a new UserCard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserCard();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            UserCard::generateUserForUserCard($model->id);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserCard model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->updated_at = date('Y-m-d h:i:s');
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserCard model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //CardSkill::deleteAll(['card_id' => $id]);
        //FieldsValue::deleteAll(['card_id' => $id]);
        $model = $this->findModel($id);
        $d = new \DateTime();
        $model->deleted_at = $d->format('Y-m-d H:i');
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserCard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserCard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserCard::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDownloadResume($id, $pdf = false)
    {
        $model = $this->findModel($id);

        if ($pdf) {
           self::getResumePdf($model);
        }
        self::getResumeDocx($model);
    }

    private function getResumePdf(UserCard $model)
    {
        $pdf = new Pdf(); // or new Pdf();
        $mpdf = $pdf->api; // fetches mpdf api
        $mpdf->SetHeader('Resume ' . $model->fio . '||Generated At: ' . date("d/m/Y")); // call methods or set any properties
        $mpdf->SetFooter('{PAGENO}');
        $mpdf->WriteHtml($model->vc_text); // call mpdf write html
        echo $mpdf->Output("Resume - {$model->fio}", 'D'); // call the mpdf api output as needed
    }

    private function getResumeDocx(UserCard $model)
    {
        $phpWord = new  PhpWord();

        $sectionStyle = array(
            'orientation' => 'portrait',
            'marginTop' => \PhpOffice\PhpWord\Shared\Converter::pixelToTwip(10),
            'marginLeft' => 600,
            'marginRight' => 600,
            'colsNum' => 1,
            'pageNumberingStart' => 1,
            'borderBottomSize'=>100,
            'borderBottomColor'=>'C0C0C0'
        );
        $section = $phpWord->addSection($sectionStyle);
        $text = $model->vc_text;
        $fontStyle = array('name'=>'Times New Roman', 'size'=>14, 'color'=>'000000', 'bold'=>FALSE, 'italic'=>FALSE);
        $parStyle = array('align'=>'both','spaceBefore'=>10);

        $section->addText(htmlspecialchars($text), $fontStyle,$parStyle);

        header("Content-Type: application/msword");
        header("Content-Transfer-Encoding: binary");
        header("Content-Disposition: attachment;filename=Resume - {$model->fio}.docx");
        header('Cache-Control: max-age=0');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        ob_clean();
        $objWriter->save("php://output");
        exit;
    }
}
