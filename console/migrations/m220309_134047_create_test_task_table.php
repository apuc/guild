<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%test_task}}`.
 */
class m220309_134047_create_test_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%test_task}}', [
            'id' => $this->primaryKey(),
            'description' => $this->string(500),
            'link' => $this->string(255),
            'level' => $this->integer(1)->defaultValue(1),
            'status' => $this->integer(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%test_task}}');
    }
}
