<?php

namespace common\models;

use Exception;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "resume_template".
 *
 * @property int $id
 * @property string $title
 * @property string $created_at
 * @property string $updated_at
 * @property int $status
 * @property string $template_body
 */
class ResumeTemplate extends \yii\db\ActiveRecord
{
    public static $fieldNamesAndSignature = [
        'ФИО' => '${fio}',
        'Паспорт' => '${passport}',
        'Электронная почта' => '${email}',
        'Пол' => '${gender}',
        'Резюме' => '${resume}',
        'Зароботная плата' => '${salary}',
        'Позиция' => '${position_id}',
        'Город' => '${city}',
        'Ссылка ВК' => '${link_vk}',
        'Ссылка Телграм' => '${link_telegram}',
        'Резюме текст' => '${vc_text}',
        'Уровень' => '${level}',
        'Резюме короткий текст' => '${vc_text_short}',
        'Лет опыта' => '${years_of_exp}',
        'Спецификация' => '${specification}',
        'Навыки' => '${skills}'
    ];

    public static $fieldSignatureDbName = [
        '${fio}'=> 'fio',
        '${passport}'=> 'passport',
        '${email}' => 'email',
        '${gender}'=> 'gender',
        '${resume}'=> 'resume',
        '${salary}' => 'salary',
        '${position_id}'=> 'position_id',
        '${city}'=> 'city',
        '${link_vk}' => 'link_vk',
        '${link_telegram}' => 'link_telegram',
        '${vc_text}' => 'vc_text',
        '${level}'=> 'level',
        '${vc_text_short}' => 'vc_text_short',
        '${years_of_exp}' => 'years_of_exp',
        '${specification}'=> 'specification',
        '${skills}'=>'skills'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resume_template';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'status'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['status'], 'integer'],
            [['template_body'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Статус',
            'template_body' => 'Template Body'
        ];
    }
}
