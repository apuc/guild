<?php

use yii\db\Migration;

/**
 * Class m230420_221309_change_column_project_user_id_to_user_id_at_project_task_user_table
 */
class m230420_221309_change_column_project_user_id_to_user_id_at_project_task_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('project_user_task_user', 'project_task_user');
        $this->dropColumn('project_task_user', 'project_user_id');

        $this->addColumn('project_task_user', 'user_id', $this->integer());
        $this->addForeignKey('fk_project_task_user_user', 'project_task_user', 'user_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_project_task_user_user', 'project_task_user');
        $this->dropColumn('project_task_user', 'user_id');

        $this->addColumn('project_task_user', 'project_user_id', $this->integer());
        $this->addForeignKey('project_user_task_user', 'project_task_user', 'project_user_id', 'project_user', 'id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230420_221309_change_column_project_user_id_to_user_id_at_project_task_user_table cannot be reverted.\n";

        return false;
    }
    */
}
