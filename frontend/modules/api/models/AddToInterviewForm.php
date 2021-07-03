<?php


namespace frontend\modules\api\models;


use yii\base\Model;

/**
 * Class AddToInterviewForm
 * @property string $email;
 * @property string $phone;
 * @property integer $profile_id;
 * @package frontend\modules\api\models
 */
class AddToInterviewForm extends Model
{
    public $email;
    public $phone;
    public $profile_id;

    public function rules()
    {
        return [
            [['email', 'phone'], 'string'],
            [['profile_id'], 'integer'],
            [['skills'], 'checkIsArray'],
        ];
    }

}