<?php

use yii\db\Migration;

/**
 * Class m241124_144216_add_status_column_at_user_tg_bot_dialog_table
 */
class m241124_144216_add_status_column_at_user_tg_bot_dialog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("user_tg_bot_dialog", "status", $this->integer(1)->defaultValue(1));
        $this->addColumn("user_tg_bot_dialog", "key_words", $this->string("255")->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("user_tg_bot_dialog", "status");
        $this->dropColumn("user_tg_bot_dialog", "key_words");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241124_144216_add_status_column_at_user_tg_bot_dialog_table cannot be reverted.\n";

        return false;
    }
    */
}
