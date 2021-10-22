<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%question}}`.
 */
class m211020_132952_create_question_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%question}}', [
            'id' => $this->primaryKey(),
            'question_type_id' => $this->integer(),
            'questionnaire_id' => $this->integer(),
            'question_body' => $this->string(255),
            'question_priority' => $this->integer(),
            'next_question' => $this->integer(),
            'status' => $this->integer(1),
            'score' => $this->integer(),
            'time_limit' => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->addForeignKey('question_type', 'question', 'question_type_id', 'question_type', 'id');
        $this->addForeignKey('questionnaire', 'question', 'questionnaire_id', 'questionnaire', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('question_type', 'question');
        $this->dropForeignKey('questionnaire', 'question');

        $this->dropTable('{{%question}}');
    }
}
