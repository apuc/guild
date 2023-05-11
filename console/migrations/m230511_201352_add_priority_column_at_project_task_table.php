<?php

use yii\db\Migration;

/**
 * Class m230511_201352_add_priority_column_at_project_task_table
 */
class m230511_201352_add_priority_column_at_project_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('project_task', 'priority', $this->integer(2)->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('project_task', 'priority');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230511_201352_add_priority_column_at_project_task_table cannot be reverted.\n";

        return false;
    }
    */
}
