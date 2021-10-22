<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_response}}`.
 */
class m211020_133240_create_user_response_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_response}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'question_id' => $this->integer(),
            'response_body' => $this->string(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'answer_flag' => $this->double(),
            'user_questionnaire_id' => $this->integer(),
        ]);

        $this->addForeignKey('user_response', 'user_response', 'user_id', 'user', 'id');
        $this->addForeignKey('question_response', 'user_response', 'question_id', 'question', 'id');
        $this->addForeignKey(
            'questionnaire_response',
            'user_response',
            'user_questionnaire_id',
            'user_questionnaire',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('user_response', 'user_response');
        $this->dropForeignKey('question_response', 'user_response');
        $this->dropForeignKey('questionnaire_response', 'user_response');

        $this->dropTable('{{%user_response}}');
    }
}
