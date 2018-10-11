<?php

use yii\db\Migration;

/**
 * Class m181004_102703_add_column_order_to_fields_value_table
 */
class m181004_102703_add_column_order_to_fields_value_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('fields_value', 'order', $this->integer(11));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('fields_value', 'order');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181004_102703_add_column_order_to_fields_value_table cannot be reverted.\n";

        return false;
    }
    */
}
