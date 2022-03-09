<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user_card}}`.
 */
class m220307_081259_add_test_task_completion_date_column_to_user_card_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_card', 'test_task_getting_date', $this->date()->defaultValue(null));
        $this->addColumn('user_card', 'test_task_complete_date', $this->date()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user_card', 'test_task_getting_date');
        $this->dropColumn('user_card', 'test_task_complete_date');
    }
}
