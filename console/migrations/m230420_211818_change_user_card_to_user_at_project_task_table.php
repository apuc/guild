<?php

use yii\db\Migration;

/**
 * Class m230420_211818_change_user_card_to_user_at_project_task_table
 */
class m230420_211818_change_user_card_to_user_at_project_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('task_user_card_creator', 'project_task');
        $this->dropForeignKey('task_user_card', 'project_task');
        $this->dropColumn('project_task', 'card_id_creator');
        $this->dropColumn('project_task', 'card_id');

        $this->addColumn('project_task', 'column_id', $this->integer());
        $this->addColumn('project_task', 'user_id', $this->integer());
        $this->addForeignKey('fk_project_task_column', 'project_task', 'column_id', 'project_column', 'id');
        $this->addForeignKey('fk_project_task_user', 'project_task', 'user_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_project_task_column', 'project_task');
        $this->dropForeignKey('fk_project_task_user', 'project_task');
        $this->dropColumn('project_task', 'column_id');
        $this->dropColumn('project_task', 'user_id');

        $this->addColumn('project_task', 'card_id_creator', $this->integer());
        $this->addColumn('project_task', 'card_id', $this->integer());
        $this->addForeignKey('task_user_card_creator', 'project_task', 'card_id_creator', 'user_card', 'id');
        $this->addForeignKey('task_user_card', 'project_task', 'card_id', 'user_card', 'id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230420_211818_change_user_card_to_user_at_project_task_table cannot be reverted.\n";

        return false;
    }
    */
}
