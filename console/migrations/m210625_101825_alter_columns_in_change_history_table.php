<?php

use yii\db\Migration;

/**
 * Class m210625_101825_alter_columns_in_change_history_table
 */
class m210625_101825_alter_columns_in_change_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('change_history', 'old_value', $this->text());
        $this->alterColumn('change_history', 'new_value', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('change_history', 'old_value', $this->string(255));
        $this->alterColumn('change_history', 'new_value', $this->string(255));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210625_101825_alter_columns_in_change_history_table cannot be reverted.\n";

        return false;
    }
    */
}
