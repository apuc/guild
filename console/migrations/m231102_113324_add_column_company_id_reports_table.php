<?php

use yii\db\Migration;

/**
 * Class m231102_113324_add_column_company_id_reports_table
 */
class m231102_113324_add_column_company_id_reports_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('reports', 'company_id', $this->integer()->defaultValue(null));

        $this->addForeignKey(
            'reports_company_id',
            'reports',
            'company_id',
            'project',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('reports_company_id', 'reports');
        $this->dropColumn('reports', 'company_id');
    }
}
