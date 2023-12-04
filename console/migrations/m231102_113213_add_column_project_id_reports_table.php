<?php

use yii\db\Migration;

/**
 * Class m231102_113213_add_column_project_id_reports_table
 */
class m231102_113213_add_column_project_id_reports_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('reports', 'project_id', $this->integer()->defaultValue(null));

        $this->addForeignKey(
            'reports_project_id',
            'reports',
            'project_id',
            'project',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('reports_project_id', 'reports');
        $this->dropColumn('reports', 'project_id');
    }
}
