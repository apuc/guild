<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_questionnaire}}`.
 */
class m211020_133147_create_user_questionnaire_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_questionnaire}}', [
            'id' => $this->primaryKey(),
            'questionnaire_id' => $this->integer(),
            'user_id' => $this->integer(),
            'uuid' => $this->string(36)->unique(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'score' => $this->integer(),
            'status' => $this->integer(),


        ]);

        $this->addForeignKey('questionnaire_user', 'user_questionnaire', 'questionnaire_id', 'questionnaire', 'id');
        $this->addForeignKey('user_questionnaire', 'user_questionnaire', 'user_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('questionnaire_user', 'user_questionnaire');
        $this->dropForeignKey('user_questionnaire', 'user_questionnaire');

        $this->dropTable('{{%user_questionnaire}}');
    }
}
