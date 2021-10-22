<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%interview_request}}`.
 */
class m210703_114553_create_interview_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%interview_request}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string(255)->notNull(),
            'phone' => $this->string(255),
            'profile_id' => $this->integer(11),
            'user_id' => $this->integer(11),
            'comment' => $this->text(),
            'created_at' => $this->integer(11),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%interview_request}}');
    }
}
