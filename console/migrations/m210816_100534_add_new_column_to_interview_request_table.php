<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%interview_request}}`.
 */
class m210816_100534_add_new_column_to_interview_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%interview_request}}', 'new', $this->integer(1)->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%interview_request}}', 'new');
    }
}
