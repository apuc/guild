<?php

use yii\db\Migration;

/**
 * Class m221108_125006_drop_unnecessary_tables_for_document
 */
class m221108_125006_drop_unnecessary_tables_for_document extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('accompanying_document');
        $this->dropTable('document_field_value');
        $this->dropTable('template_document_field');
        $this->dropTable('document_field');
        $this->dropTable('document');
        $this->dropTable('template');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('{{%template}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'template_file_name' => $this->string(255),
            'document_type' => $this->integer()->defaultValue(null)

        ]);


        $this->createTable('{{%document}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'template_id' => $this->integer(11)->notNull(),
            'manager_id' => $this->integer(11)->notNull(),
        ]);
        $this->addForeignKey('document_template', 'document', 'template_id', 'template', 'id');
        $this->addForeignKey('document_manager', 'document', 'manager_id', 'manager', 'id');


        $this->createTable('{{%document_field}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'field_template' => $this->string(),
        ]);


        $this->createTable('{{%template_document_field}}', [
            'id' => $this->primaryKey(),
            'template_id' => $this->integer(11)->notNull(),
            'field_id' => $this->integer(11)->notNull()
        ]);
        $this->addForeignKey('template_template_document_field', 'template_document_field', 'template_id', 'template', 'id');
        $this->addForeignKey('document_field_template_document_field', 'template_document_field', 'field_id', 'document_field', 'id');


        $this->createTable('{{%document_field_value}}', [
            'id' => $this->primaryKey(),
            'field_id' => $this->integer(11)->notNull(),
            'document_id' => $this->integer(11)->notNull(),
            'value' => $this->string()
        ]);
        $this->addForeignKey('document_field_document_field_value', 'document_field_value', 'field_id', 'document_field', 'id');
        $this->addForeignKey('document_document_field_value', 'document_field_value', 'document_id', 'document', 'id');


        $this->createTable('{{%accompanying_document}}', [
            'id' => $this->primaryKey(),
            'document_id' => $this->integer(11),
            'title' => $this->string()->notNull(),
        ]);
        $this->addForeignKey('document_accompanying_document', 'accompanying_document', 'document_id', 'document', 'id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221108_125006_drop_unnecessary_tables_for_document cannot be reverted.\n";

        return false;
    }
    */
}
