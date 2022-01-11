<?php

use yii\db\Migration;

/**
 * Class m220111_082339_add_default_templates
 */
class m220111_082339_add_default_templates extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $time = new \yii\db\Expression('NOW()');
        Yii::$app->db->createCommand()->batchInsert('template', [ 'title', 'created_at' ],
        [
            ['Акт', $time],
            ['Акт сверки', $time],
            ['Детализация', $time],
            ['Доверенность', $time],
            ['Договор', $time],
            ['Доп соглашение к договору', $time],
            ['Транспортная накладная', $time],
            ['Ценовой лист', $time],
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Yii::$app->db->createCommand()->delete('template',
            [
                'in', 'title', [
                'Акт',
                'Акт сверки',
                'Детализация',
                'Доверенность',
                'Договор',
                'Доп соглашение к договору',
                'Транспортная накладная',
                'Ценовой лист',
            ]
            ])->execute();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220111_082339_add_default_templates cannot be reverted.\n";

        return false;
    }
    */
}
