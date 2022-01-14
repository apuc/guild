<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\db\StaleObjectException;

/**
 * This is the model class for table "document".
 *
 * @property int $id
 * @property string $title
 * @property string $created_at
 * @property string $updated_at
 * @property int $template_id
 * @property int $manager_id
 *
 * @property Manager $manager
 * @property Template $template
 * @property DocumentFieldValue[] $documentFieldValues
 */
class Document extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'document';
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
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function beforeDelete()
    {
        foreach ($this->documentFieldValues as $documentFieldValue){
            $documentFieldValue->delete();
        }
        return parent::beforeDelete();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['template_id', 'manager_id'], 'required'],
            [['template_id', 'manager_id'], 'integer'],
            ['title', 'unique', 'targetAttribute' => ['title', 'template_id'], 'message'=>'Документ уже создан'],
            [['title'], 'string', 'max' => 255],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => Manager::className(), 'targetAttribute' => ['manager_id' => 'id']],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => Template::className(), 'targetAttribute' => ['template_id' => 'id']],
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
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'template_id' => 'Шаблон',
            'manager_id' => 'Менеджер',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(Manager::className(), ['id' => 'manager_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::className(), ['id' => 'template_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getDocumentFieldValues(): ActiveQuery
    {
        return $this->hasMany(DocumentFieldValue::className(), ['document_id' => 'id']);
    }

    public static function getDocument($document_id)
    {
        return self::find()
            ->joinWith(['documentFieldValues.field'])
            ->where(['document.id' => $document_id])
            ->asArray()
            ->all();
    }
}
