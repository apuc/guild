<?php

use yii\db\Migration;

/**
 * Class m211203_123444_changing_foreign_key_in_task_from_project_user_id_to_user_id
 */
class m211203_123444_changing_foreign_key_in_task_from_project_user_id_to_user_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('task_project_user', 'task');
        $this->dropColumn('task', 'project_user_id');
        $this->addColumn('task', 'user_id_creator', $this->integer());
        $this->addForeignKey('creator_task', 'task', 'user_id_creator', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('creator_task', 'task');
        $this->dropColumn('task', 'user_id_creator');
        $this->addColumn('task', 'project_user_id', $this->integer());
        $this->addForeignKey('task_project_user', 'task',
            'project_user_id', 'project_user', 'id');
    }
}
