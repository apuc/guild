<?php

namespace common\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * This is the model class for table "template".
 *
 * @property int $id
 * @property string $title
 * @property string $created_at
 * @property string $updated_at
 * @property string $template_file_name
 * @property int $document_type
 *
 * @property Document[] $documents
 * @property TemplateDocumentField[] $templateDocumentFields
 */
class Template extends \yii\db\ActiveRecord
{
    const SCENARIO_UPDATE_TITLE = 'update';
    const SCENARIO_UPDATE_FILE = 'update';

    public $template;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'template';
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
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'unique'],
            [['document_type'], 'integer'],
            [['template_file_name', 'title', 'document_type'], 'required'],
            [['template'], 'required', 'message'=>'Укажите путь к файлу'],
            [['template'], 'file', 'maxSize' => '100000'],
            [['template'], 'file', 'skipOnEmpty' => true, 'extensions' => 'docx'],
            [['title', 'template_file_name'], 'string', 'max' => 255],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[static::SCENARIO_UPDATE_TITLE] = ['created_at', 'updated_at', 'title', 'template_file_name'];
        $scenarios[static::SCENARIO_UPDATE_FILE] = ['template'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
            'template_file_name' => 'Файл шаблона',
            'document_type' => 'Тип документа',
        ];
    }

    public function beforeDelete()
    {
        foreach ($this->templateDocumentFields as $templateDocumentField){
            $templateDocumentField->delete();
        }

        if (!empty($this->template_file_name)) {
            $template_path = Yii::getAlias('@templates') . '/' . $this->template_file_name;

            if(file_exists($template_path)) {
                unlink($template_path);
            }
        }
        return parent::beforeDelete();
    }

    /**
     * @return ActiveQuery
     */
    public function getDocuments()
    {
        return $this->hasMany(Document::className(), ['template_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTemplateDocumentFields()
    {
        return $this->hasMany(TemplateDocumentField::className(), ['template_id' => 'id']);
    }

    public function getTitle()
    {
        return $this->title;
    }
}
