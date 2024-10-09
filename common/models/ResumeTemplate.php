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
 * @property int $show_header
 * @property int $show_footer
 * @property string $template_body
 * @property string $header_text
 * @property string $header_image
 * @property string $footer_text
 * @property string $footer_image
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
        'Ставка для резюме' => '${resume_tariff}',
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
        '${resume_tariff}' => 'resume_tariff',
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
            [['status', 'show_header', 'show_footer'], 'integer'],
            [['template_body'], 'string'],
            [['title', 'header_text', 'header_image', 'footer_text', 'footer_image'], 'string', 'max' => 255],
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
            'template_body' => 'Тело шаблона',
            'header_text' => 'Текст в верхнем контикуле',
            'header_image' => 'Картинка в верхнем контикуле',
            'footer_text' => 'Текст в нижнем контикуле',
            'footer_image' => 'Картинка в нижнем контикуле',
            'show_header' => 'Показать верхний контикул',
            'show_footer' => 'Показать нижний контикул',
        ];
    }
}
