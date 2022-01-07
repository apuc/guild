<?php

use yii\db\Migration;

/**
 * Class m220106_092252_add_column_field_template_document_field_table
 */
class m220106_092252_add_column_field_template_document_field_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('document_field', 'field_template', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('document_field', 'field_template');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220106_092252_add_column_field_template_document_field_table cannot be reverted.\n";

        return false;
    }
    */
}
