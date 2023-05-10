<?php

use yii\db\Migration;

/**
 * Class m230510_164429_add_priority_column_at_project_column_table
 */
class m230510_164429_add_priority_column_at_project_column_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('project_column', 'priority', $this->integer(2)->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('project_column', 'priority');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230510_164429_add_priority_column_at_project_column_table cannot be reverted.\n";

        return false;
    }
    */
}
