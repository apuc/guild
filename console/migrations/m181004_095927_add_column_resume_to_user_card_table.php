<?php

use yii\db\Migration;

/**
 * Class m181004_095927_add_column_resume_to_user_card_table
 */
class m181004_095927_add_column_resume_to_user_card_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_card', 'resume', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user_card', 'resume');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181004_095927_add_column_resume_to_user_card_table cannot be reverted.\n";

        return false;
    }
    */
}
