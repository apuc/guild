<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%field_value}}`.
 */
class m211223_095155_create_document_field_value_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%document_field_value}}', [
            'id' => $this->primaryKey(),
            'field_id' => $this->integer(11)->notNull(),
            'document_id' => $this->integer(11)->notNull(),
            'value' => $this->string()
        ]);

        $this->addForeignKey('document_field_document_field_value', 'document_field_value', 'field_id', 'document_field', 'id');
        $this->addForeignKey('document_document_field_value', 'document_field_value', 'document_id', 'document', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('document_field_document_field_value', 'document_field_value');
        $this->dropForeignKey('document_document_field_value', 'document_field_value');
        $this->dropTable('{{%document_field_value}}');
    }
}
