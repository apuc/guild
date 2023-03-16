<?php

use yii\db\Migration;

/**
 * Class m230118_120338_rename_task_table_to_project_task
 */
class m230118_120338_rename_task_table_to_project_task extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameTable('task', 'project_task');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameTable('project_task', 'task');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230118_120338_rename_task_table_to_project_task cannot be reverted.\n";

        return false;
    }
    */
}
