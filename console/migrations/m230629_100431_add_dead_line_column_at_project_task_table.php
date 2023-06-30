<?php

use yii\db\Migration;

/**
 * Class m230629_100431_add_dead_line_column_at_project_task_table
 */
class m230629_100431_add_dead_line_column_at_project_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('project_task', 'dead_line', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('project_task', 'dead_line');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230629_100431_add_dead_line_column_at_project_task_table cannot be reverted.\n";

        return false;
    }
    */
}
