<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%reports_task}}`.
 */
class m211122_144548_add_column_to_reports_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('reports_task', 'minutes_spent', $this->integer()->defaultValue(0)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('reports_task', 'minutes_spent' );
    }
}
