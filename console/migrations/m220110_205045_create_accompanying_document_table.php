<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%accompanying_document}}`.
 */
class m220110_205045_create_accompanying_document_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%accompanying_document}}', [
            'id' => $this->primaryKey(),
            'document_id' => $this->integer(11),
            'title' => $this->string()->notNull(),
        ]);
        $this->addForeignKey('document_accompanying_document', 'accompanying_document', 'document_id', 'document', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('document_accompanying_document', 'accompanying_document');
        $this->dropTable('{{%accompanying_document}}');
    }
}
