<?php

namespace backend\modules\card\controllers;

use backend\modules\card\models\ResumeTemplate;
use backend\modules\card\models\UserCard;
use backend\modules\card\models\UserCardSearch;
use backend\modules\settings\models\Skill;
use common\models\AchievementUserCard;
use common\models\CardSkill;
use common\models\FieldsValueNew;
use common\models\User;
use common\models\UserCardPortfolioProjects;
use kartik\mpdf\Pdf;
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
            'as AccessBehavior' => [
                'class' => \developeruz\db_rbac\behaviors\AccessBehavior::className(),
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

        $portfolioProjects = new ActiveDataProvider([
            'query' => UserCardPortfolioProjects::find()->where(['card_id' => $id]),
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
            'portfolioProjects' => $portfolioProjects
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

    public function actionResume($id): string
    {
        return $this->render('resume', [
            'model' => UserCard::findOne($id)
        ]);
    }

    /**
     * @param integer $id
     * @throws NotFoundHttpException
     */
    public function actionResumeTextByTemplate(int $id): string
    {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_GENERATE_RESUME_TEXT;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->generateText($model);
            $model->save(false);
        }

        return $this->render('resume', [
            'model' => $model
        ]);
    }

    /**
     * @param integer $id
     * @throws NotFoundHttpException
     */
    public function actionUpdateResumeText($id)
    {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_UPDATE_RESUME_TEXT;

        if ($model->load(Yii::$app->request->post())  && $model->validate()) {
            $model->updated_at = date('Y-m-d h:i:s');
            $model->save();
        }

        return $this->render('resume', [
            'model' => $model
        ]);
    }

    private function generateText(UserCard $userCard) {
        $resumeTemplate = ResumeTemplate::findOne($userCard->resume_template_id);
        $resumeText = $resumeTemplate->template_body;

        foreach (ResumeTemplate::$fieldSignatureDbName as $fieldSignature => $fieldDbName ) {
            if (str_contains($resumeText, $fieldSignature)) {
                if($fieldDbName == 'position_id') {
                    $fieldValue = $userCard->position->name;
                } elseif ($fieldDbName == 'gender') {
                    $fieldValue = $userCard->getGendersText();
                } elseif ($fieldDbName == 'level') {
                    $fieldValue = UserCard::getLevelLabel($userCard->level);
                } elseif($fieldDbName == 'skills') {
                    $skills = Skill::find()->select('name')
                        ->joinWith('cardSkills')
                        ->where(['card_skill.card_id' => $userCard->id])
                        ->column();

                    $fieldValue = implode(', ', $skills);
                } elseif ($fieldDbName == 'vc_text') {
                    $fieldValue = $userCard[$fieldDbName];
                    $resumeText = str_replace('<p>' . $fieldSignature. '</p>', $fieldValue, $resumeText);
                    continue;
                } else {
                    $fieldValue = $userCard[$fieldDbName];
                }
                $resumeText = str_replace($fieldSignature, $fieldValue, $resumeText);
            }
        }
        $userCard->resume_text = $resumeText;
    }

    public function actionDownloadResume(int $id, string $type)
    {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_DOWNLOAD_RESUME;

        if ($model->validate()) {
            if ($type == 'pdf') {
                $this->downloadResumePdf($model);
            } elseif ($type == 'docx') {
                $this->downloadResumeDocx($model);
            }
        }

        return $this->render('resume', [
            'model' => $model
        ]);
    }

    private function downloadResumePdf(UserCard $userCard)
    {
        $resumeTemplate = ResumeTemplate::findOne($userCard->resume_template_id);


        $headerText = $resumeTemplate->header_text ? : 'Generated by ITGuild.info At: ' . date("d/m/Y");
        $headerImagePath = $resumeTemplate->header_image ? Yii::getAlias('@frontend') . '/web' . $resumeTemplate->header_image : null;

        $footerText = $resumeTemplate->footer_text ?? null;
        $footerImg = $resumeTemplate->footer_image ? Yii::getAlias('@frontend') . '/web' . $resumeTemplate->footer_image : null;

        $pdf = new Pdf();
        $mpdf = $pdf->api;

        $mpdf->setAutoTopMargin='stretch';
        $mpdf->SetHTMLHeader("
                <div><table style='width:100%; height:100%; border-bottom: 1px solid #999;  font-family: serif; font-size: 8pt; color:
                #000000; font-weight: bold; font-style: italic;'><tr>
                <td width='33%'><span style='font-weight: bold; font-style: italic;'><img src=$headerImagePath style='width: 100px; height: 40px; margin: 0; vertical-align: middle;'></span></td>
                <td width='33%' align='center' style='font-weight: bold; font-style: italic;'>$headerText</td>
                <td width='33%' style='text-align: right; '></td>
                </tr></table></div>
            ");
        $mpdf->SetHTMLFooter("
                <div><table width='100%' style='border-top: 1px solid #999; vertical-align: bottom; font-family: serif; font-size: 8pt; color:
                #000000; font-weight: bold; font-style: italic;'><tr>
                <td width='33%'><span style='font-weight: bold; font-style: italic;'><img src=$footerImg style='width: 100px; height: 40px; margin: 0; vertical-align: middle;'></span></td>
                <td width='33%' align='center' style='font-weight: bold; font-style: italic;'>$footerText</td>
                <td width='33%' style='text-align: right; '>{PAGENO}</td>
                </tr></table></div>
            ");
        $mpdf->WriteHTML("<div>$userCard->resume_text</div>");

        $filename = "Resume - " . $userCard->fio . ".pdf";//You might be not adding the extension,

        $mpdf->Output($filename, 'D'); // call the mpdf api output as needed
        exit();
    }

    private function downloadResumeDocx(UserCard $model)
    {
        $resumeTemplate = ResumeTemplate::findOne($model->resume_template_id);

        $headerText = $resumeTemplate->header_text ? : 'Generated by ITGuild.info At: ' . date("d/m/Y");
        $footerText = $resumeTemplate->footer_text ?? null;

        $pw = new \PhpOffice\PhpWord\PhpWord();

        // (B) ADD HTML CONTENT
        $section = $pw->addSection();
        $header = $section->addHeader();
        $footer = $section->addFooter();

        if (pathinfo($resumeTemplate->header_image, PATHINFO_EXTENSION)) {
            $header->addImage(Yii::getAlias('@frontend') . '/web' . $resumeTemplate->header_image, ['width'  => 70, 'height' => 30, 'align'  => 'left']);
        }
        $header->addText($headerText, array('bold' => false), array('space' => array('before' => 0, 'after' => 280)));
        if (pathinfo($resumeTemplate->footer_image, PATHINFO_EXTENSION)) {
            $footer->addImage(Yii::getAlias('@frontend') . '/web' . $resumeTemplate->footer_image, ['width'  => 70, 'height' => 30, 'align'  => 'left']);
        }
        $footer->addText($footerText, array('bold' => false), array('space' => array('before' => 0, 'after' => 280)));
        $footer->addPreserveText('{PAGE}', null, ['align' => 'right']);

        $resumeText = str_replace(array('<br/>', '<br>', '</br>'), ' ', $model->resume_text);
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $resumeText, false, false);

        // (C) SAVE TO DOCX ON SERVER
        // $pw->save("convert.docx", "Word2007");

        // (D) OR FORCE DOWNLOAD
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment;filename=\"Resume-$model->fio.docx\"");
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($pw, "Word2007");
        $objWriter->save("php://output");
        exit();
    }
}
