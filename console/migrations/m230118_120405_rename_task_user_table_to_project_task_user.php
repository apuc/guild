<?php

use yii\db\Migration;

/**
 * Class m230118_120405_rename_task_user_table_to_project_task_user
 */
class m230118_120405_rename_task_user_table_to_project_task_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameTable('task_user', 'project_task_user');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameTable('project_task_user', 'task_user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230118_120405_rename_task_user_table_to_project_task_user cannot be reverted.\n";

        return false;
    }
    */
}
