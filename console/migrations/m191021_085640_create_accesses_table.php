<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%accesses}}`.
 */
class m191021_085640_create_accesses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%accesses}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'access' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%accesses}}');
    }
}
