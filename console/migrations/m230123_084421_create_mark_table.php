<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%mark}}`.
 */
class m230123_084421_create_mark_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mark}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mark}}');
    }
}
