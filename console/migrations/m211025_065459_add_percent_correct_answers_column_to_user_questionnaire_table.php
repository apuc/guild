<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user_questionnaire}}`.
 */
class m211025_065459_add_percent_correct_answers_column_to_user_questionnaire_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_questionnaire', 'percent_correct_answers', $this->double());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user_questionnaire', 'percent_correct_answers');
    }
}
