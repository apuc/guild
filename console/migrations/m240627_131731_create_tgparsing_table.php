<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tgparsing}}`.
 */
class m240627_131731_create_tgparsing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tgparsing}}', [
            'id' => $this->primaryKey(),
            'channel_id' => $this->bigInteger()->notNull(),
            'channel_link' => $this->string(255),
            'channel_title' => $this->string(255),
            'post_id' => $this->integer(11),
            'content' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'status' => $this->integer(1)->defaultValue(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tgparsing}}');
    }
}
