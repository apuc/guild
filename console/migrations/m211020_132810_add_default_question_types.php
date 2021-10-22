<?php

use yii\db\Migration;

/**
 * Class m211020_132810_add_default_question_types
 */
class m211020_132810_add_default_question_types extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->db->createCommand()->batchInsert('question_type', ['question_type', 'slug'], [
            ['Открытый вопрос', 'otkrytyj-vopros'],
            ['Один правильный ответ', 'odin-pravilnyj-otvet'],
            ['Несколько вариантов ответа', 'neskolko-variantov-otveta'],
            ['Истина - ложь', 'istina-loz'],
            ['Парное соответствие', 'parnoe-sootvetstvie'],
            ['Заполнить пропуски', 'zapolnit-propuski'],
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Yii::$app->db->createCommand()->delete('question_type',
            [
                'in', 'question_type', [
                'Открытый вопрос',
                'Один правильный ответ',
                'Несколько вариантов ответа',
                'Истина - ложь',
                'Парное соответствие',
                'Заполнить пропуски'
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
        echo "m211020_132810_add_default_question_types cannot be reverted.\n";

        return false;
    }
    */
}
