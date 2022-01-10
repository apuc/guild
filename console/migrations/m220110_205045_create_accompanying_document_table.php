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
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%accompanying_document}}');
    }
}
