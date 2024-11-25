<?php

use yii\db\Migration;

/**
 * Class m241123_141806_add_username_column_at_user_tg_bot_dialig_table
 */
class m241123_141806_add_username_column_at_user_tg_bot_dialig_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("user_tg_bot_dialog", "username", $this->string("255")->null());
        $this->addColumn("user_tg_bot_dialog", "first_name", $this->string("255")->null());
        $this->addColumn("user_tg_bot_dialog", "last_name", $this->string("255")->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("user_tg_bot_dialog", "username");
        $this->dropColumn("user_tg_bot_dialog", "first_name");
        $this->dropColumn("user_tg_bot_dialog", "last_name");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241123_141806_add_username_column_at_user_tg_bot_dialig_table cannot be reverted.\n";

        return false;
    }
    */
}
