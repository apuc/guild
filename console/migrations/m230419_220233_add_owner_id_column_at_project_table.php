<?php

use yii\db\Migration;

/**
 * Class m230419_220233_add_owner_id_column_at_project_table
 */
class m230419_220233_add_owner_id_column_at_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('project', 'owner_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('project', 'owner_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230419_220233_add_owner_id_column_at_project_table cannot be reverted.\n";

        return false;
    }
    */
}
