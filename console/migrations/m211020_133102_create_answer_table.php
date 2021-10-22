<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%answer}}`.
 */
class m211020_133102_create_answer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%answer}}', [
            'id' => $this->primaryKey(),
            'question_id' => $this->integer(),
            'answer_body' => $this->string(255)->notNull(),
            'answer_flag' => $this->integer(1),
            'status' => $this->integer(1),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->addForeignKey('answer_question', 'answer', 'question_id', 'question', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('answer_question', 'answer');
        $this->dropTable('{{%answer}}');
    }
}
