<?php

use yii\db\Migration;

/**
 * Class m221117_091058_add_resume_tariff_column_at_user_card_table
 */
class m221117_091058_add_resume_tariff_column_at_user_card_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_card', 'resume_tariff', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user_card', 'resume_tariff');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221117_091058_add_resume_tariff_column_at_user_card_table cannot be reverted.\n";

        return false;
    }
    */
}
