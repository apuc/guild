<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task_user}}`.
 */
class m211123_085751_create_task_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task_user}}', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer(),
            'project_user_id' => $this->integer(),
        ]);
        $this->addForeignKey('task_task_user', 'task_user',
            'task_id', 'task', 'id');
        $this->addForeignKey('project_user_task_user', 'task_user',
            'project_user_id', 'project_user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('task_task_user', 'task_user');
        $this->dropForeignKey('project_user_task_user', 'task_user');
        $this->dropTable('{{%task_user}}');
    }
}
