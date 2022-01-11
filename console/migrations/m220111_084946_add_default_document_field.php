<?php

use yii\db\Migration;

/**
 * Class m220111_084946_add_default_document_field
 */
class m220111_084946_add_default_document_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->db->createCommand()->batchInsert('document_field', [ 'title', 'field_template'],
            [
                ['№ документа', '№ dokumenta'],
                ['от', 'ot'],
                ['Сумма с НДС', 'Summa s NDS'],
                ['НДС', 'NDS'],
                ['Основание', 'Osnovaniye'],
                ['Цена', 'Tsena'],
                ['К договору', 'K dogovoru'],
                ['№', '№']
            ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Yii::$app->db->createCommand()->delete('document_field',
            [
                'in', 'title', [
                '№ документа',
                'от',
                'Сумма с НДС',
                'НДС',
                'Основание',
                'Цена',
                'К договору',
                '№',
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
        echo "m220111_084946_add_default_document_field cannot be reverted.\n";

        return false;
    }
    */
}
