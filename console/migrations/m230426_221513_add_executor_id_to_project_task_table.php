<?php

use yii\db\Migration;

/**
 * Class m230426_221513_add_executor_id_to_project_task_table
 */
class m230426_221513_add_executor_id_to_project_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('project_task', 'executor_id', $this->integer(11));
        $this->addForeignKey('fk_project_task_user_executor', 'project_task', 'executor_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_project_task_user_executor', 'project_task');
        $this->dropColumn('project_task', 'executor_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230426_221513_add_executor_id_to_project_task_table cannot be reverted.\n";

        return false;
    }
    */
}
