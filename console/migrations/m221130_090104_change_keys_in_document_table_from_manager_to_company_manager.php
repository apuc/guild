<?php

use yii\db\Migration;

/**
 * Class m221130_090104_change_keys_in_document_table_from_manager_to_company_manager
 */
class m221130_090104_change_keys_in_document_table_from_manager_to_company_manager extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('manager_document', 'document');
        $this->dropForeignKey('contractor_manager_document', 'document');

        $this->addForeignKey('company_manager_document', 'document', 'manager_id', 'company_manager', 'id');
        $this->addForeignKey('contractor_company_manager_document', 'document', 'contractor_manager_id', 'company_manager', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('company_manager_document', 'document');
        $this->dropForeignKey('contractor_company_manager_document', 'document');

        $this->addForeignKey('manager_document', 'document', 'manager_id','manager', 'id');
        $this->addForeignKey('contractor_manager_document', 'document', 'contractor_manager_id','manager', 'id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221130_090104_change_keys_in_document_table_from_manager_to_company_manager cannot be reverted.\n";

        return false;
    }
    */
}
