<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%field}}`.
 */
class m211223_092038_create_document_field_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%document_field}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%document_field}}');
    }
}
