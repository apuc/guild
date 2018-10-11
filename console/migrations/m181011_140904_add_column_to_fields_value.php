<?php

use yii\db\Migration;

/**
 * Class m181011_140904_add_column_to_fields_value
 */
class m181011_140904_add_column_to_fields_value extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('fields_value', 'company_id', $this->integer(11));

        $this->addForeignKey(
            'fields_value_ibfk_company',
            'fields_value',
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
        $this->dropForeignKey('fields_value_ibfk_company', 'fields_value');

        $this->dropColumn('fields_value', 'project_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181011_140904_add_column_to_fields_value cannot be reverted.\n";

        return false;
    }
    */
}
