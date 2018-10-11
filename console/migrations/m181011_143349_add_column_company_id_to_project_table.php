<?php

use yii\db\Migration;

/**
 * Class m181011_143349_add_column_company_id_to_project_table
 */
class m181011_143349_add_column_company_id_to_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('project', 'company_id', $this->integer(11));
        $this->addForeignKey(
            'project_ibfk_company',
            'project',
            'company_id',
            'company',
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('project_ibfk_company', 'project');

        $this->dropColumn('project', 'company_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181011_143349_add_column_company_id_to_project_table cannot be reverted.\n";

        return false;
    }
    */
}
