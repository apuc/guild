<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%project_task}}`.
 */
class m231013_144526_add_execution_priority_column_to_project_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('project_task', 'execution_priority', $this->integer(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('project_task', 'execution_priority');
    }
}
