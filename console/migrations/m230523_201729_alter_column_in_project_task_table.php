<?php

use yii\db\Migration;

/**
 * Class m230523_201729_alter_column_in_project_task_table
 */
class m230523_201729_alter_column_in_project_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('project_task', 'description', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('project_task', 'description', $this->string(500));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230523_201729_alter_column_in_project_task_table cannot be reverted.\n";

        return false;
    }
    */
}
