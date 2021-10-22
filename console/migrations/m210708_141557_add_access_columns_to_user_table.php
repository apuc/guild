<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user}}`.
 */
class m210708_141557_add_access_columns_to_user_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user', 'access_token', $this->string());
        $this->addColumn('user', 'access_token_expired_at', $this->dateTime());
    }

    public function safeDown()
    {
        $this->dropColumn('user', 'access_token');
        $this->dropColumn('user', 'access_token_expired_at');
    }
}
