<?php

use yii\db\Migration;

/**
 * Class m231114_072752_add_column_start_testing_to_user_questionnaire
 */
class m231114_072752_add_column_start_testing_to_user_questionnaire extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_questionnaire', 'start_testing', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user_questionnaire', 'start_testing');
    }
}
