<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_tg_bot_dialog}}`.
 */
class m231024_132757_create_user_tg_bot_dialog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_tg_bot_dialog}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'dialog_id' => $this->integer()->notNull()->unique(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
        $this->addForeignKey('user_user_tg_bot_dialog', 'user_tg_bot_dialog', 'user_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_tg_bot_dialog}}');
    }
}
