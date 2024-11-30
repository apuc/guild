<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tg_bot_msg}}`.
 */
class m241130_111026_create_tg_bot_msg_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tg_bot_msg}}', [
            'id' => $this->primaryKey(),
            'dialog_id' => $this->integer()->notNull(),
            'ig_dialog_id' => $this->integer(),
            'text' => $this->text(),
            'status' => $this->integer()->defaultValue(1),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tg_bot_msg}}');
    }
}
