<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 */
class m211123_083938_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer(11)->notNull(),
            'title' => $this->string(),
            'status' => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'project_user_id' => $this->integer(),
            'user_id' => $this->integer(),
            'description' => $this->string(500),
        ]);
        $this->addForeignKey('task_project', 'task',
            'project_id', 'project', 'id');
        $this->addForeignKey('task_project_user', 'task',
            'project_user_id', 'project_user', 'id');
        $this->addForeignKey('task_user', 'task', 'user_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('task_project', 'task');
        $this->dropForeignKey('task_project_user', 'task');
        $this->dropForeignKey('task_user', 'task');
        $this->dropTable('{{%task}}');
    }
}
