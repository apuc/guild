<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%document}}`.
 */
class m211223_091152_create_document_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
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
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('document_manager', 'document');
        $this->dropForeignKey('document_template', 'document');
        $this->dropTable('{{%document}}');
    }
}
