<?php

use yii\db\Migration;

/**
 * Class m231023_122338_create_user_tg_bot_token
 */
class m231023_122338_create_user_tg_bot_token extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_tg_bot_token}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'token' => $this->string()->notNull()->unique(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'expired_at' => $this->dateTime(),
        ]);
        $this->addForeignKey('user_user_tg_bot_token', 'user_tg_bot_token', 'user_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user_tg_bot_token');
    }
}
