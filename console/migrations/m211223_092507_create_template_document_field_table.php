<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%template_field}}`.
 */
class m211223_092507_create_template_document_field_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%template_document_field}}', [
            'id' => $this->primaryKey(),
            'template_id' => $this->integer(11)->notNull(),
            'field_id' => $this->integer(11)->notNull()
        ]);

        $this->addForeignKey('template_template_document_field', 'template_document_field', 'template_id', 'template', 'id');
        $this->addForeignKey('document_field_template_document_field', 'template_document_field', 'field_id', 'document_field', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('template_template_document_field', 'template_document_field');
        $this->dropForeignKey('document_field_template_document_field', 'template_document_field');
        $this->dropTable('{{%template_document_field}}');
    }
}
