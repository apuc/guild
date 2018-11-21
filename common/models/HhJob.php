<?php

namespace common\models;

use common\hhapi\core\service\HHService;
use Yii;

/**
 * This is the model class for table "hh_job".
 *
 * @property int $id
 * @property int $employer_id
 * @property int $hh_id
 * @property string $title
 * @property string $url
 * @property int $salary_from
 * @property int $salary_to
 * @property string $salary_currency
 * @property string $address
 * @property string $schedule
 * @property int $dt_add
 */
class HhJob extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hh_job';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employer_id', 'hh_id', 'salary_from', 'salary_to', 'dt_add'], 'integer'],
            [['title', 'url', 'address'], 'string', 'max' => 255],
            [['salary_currency', 'schedule'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employer_id' => 'Работодатель',
            'hh_id' => 'Hh ID',
            'title' => 'Заголовок',
            'url' => 'Url',
            'salary_from' => 'З.П. от',
            'salary_to' => 'З.П. до',
            'salary_currency' => 'З.П. валюта',
            'address' => 'Адрес',
            'dt_add' => 'Дата',
            'schedule' => 'График',
        ];
    }

    public function gethhcompany()
    {
        return $this->hasOne(Hh::class, ['hh_id' => 'employer_id']);
    }

    public static function createFromHH($data)
    {
        if (!self::find()->where(['hh_id' => $data->item->id])->exists()) {
            $j = new self();
            $j->dt_add = time();
            $j->title = $data->item->name;
            $j->hh_id = $data->item->id;
            $j->url = $data->item->alternate_url;
            $j->employer_id = $data->item->employer->id;
            if (!empty($data->item->address)) {
                $j->address = $data->item->address->city . ', ' . $data->item->address->street . ', ' . $data->item->address->building;
            }
            if (!empty($data->item->salary)) {
                $j->salary_from = $data->item->salary->from;
                $j->salary_to = $data->item->salary->to;
                $j->salary_currency = $data->item->salary->currency;
            }
            if (!empty($data->item->schedule)) {
                $j->schedule = $data->item->schedule->id;
            }
            return $j->save();
        }
        return false;
    }

    public static function createFromHHRemote($data)
    {
        $v = HHService::run()->vacancy($data->item->id)->get();
        if($v->schedule->id === 'remote'){
            $data->item->schedule = $v->schedule;
            return self::createFromHH($data);
        }
        return false;
    }
}
