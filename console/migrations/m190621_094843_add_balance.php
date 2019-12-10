<?php

use yii\db\Migration;

/**
 * Class m190621_094843_add_balance
 */
class m190621_094843_add_balance extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('balance',[
            'id' => $this->primaryKey(),
            'type' => $this->integer(1),
            'summ' => $this->integer(4),
            'dt_add' => $this->integer(11),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('balance');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190621_094843_add_balance cannot be reverted.\n";

        return false;
    }
    */
}
