<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%knowledge_level}}`.
 */
class m230329_212545_create_knowledge_level_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%knowledge_level}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'status' => $this->integer(1)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%knowledge_level}}');
    }
}
