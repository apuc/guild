<?php

use yii\db\Migration;

/**
 * Class m190622_195218_fields_value_new
 */
class m190622_195218_fields_value_new extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('fields_value_new',[
            'id' => $this->primaryKey(),
            'field_id' => $this->integer(11)->notNull(),
            'item_id' => $this->integer(11)->notNull(),
            'item_type' => $this->integer(4)->notNull(),
            'order' => $this->integer(11),
            'value' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('fields_value_new');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190622_195218_fields_value_new cannot be reverted.\n";

        return false;
    }
    */
}
