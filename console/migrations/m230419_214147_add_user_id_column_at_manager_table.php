<?php

use yii\db\Migration;

/**
 * Class m230419_214147_add_user_id_column_at_manager_table
 */
class m230419_214147_add_user_id_column_at_manager_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('manager', 'user_id', $this->integer(11));
        $this->addForeignKey('manager_user', 'manager', 'user_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('manager_user', 'manager');
        $this->dropColumn('manager', 'user_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230419_214147_add_user_id_column_at_manager_table cannot be reverted.\n";

        return false;
    }
    */
}
