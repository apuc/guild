<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%document_template}}`.
 */
class m221108_135514_create_document_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%document_template}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'template_body' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%document_template}}');
    }
}
