<?php

use yii\db\Migration;

/**
 * Class m221128_114458_make_nullable_company_id_contractor_company_id_manager_id_columns_in_document_table
 */
class m221128_114458_make_nullable_company_id_contractor_company_id_manager_id_columns_in_document_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('document', 'company_id',  $this->integer(11)->null());
        $this->alterColumn('document', 'contractor_company_id',  $this->integer(11)->null());
        $this->alterColumn('document', 'manager_id',  $this->integer(11)->null());
        $this->alterColumn('document', 'contractor_manager_id',  $this->integer(11)->null());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('document', 'company_id',  $this->integer(11)->notNull());
        $this->alterColumn('document', 'contractor_company_id',  $this->integer(11)->notNull());
        $this->alterColumn('document', 'manager_id',  $this->integer(11)->notNull());
        $this->alterColumn('document', 'contractor_manager_id',  $this->integer(11)->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221128_114458_make_nullable_company_id_contractor_company_id_manager_id_columns_in_document_table cannot be reverted.\n";

        return false;
    }
    */
}
