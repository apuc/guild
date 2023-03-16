<?php

use yii\db\Migration;

/**
 * Class m230221_181446_add_partner_to_status_table
 */
class m230221_181446_add_partner_to_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('status',
            [
                'name' => 'Партнер',
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('status', ['name' => 'Партнер']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230221_181446_add_partner_to_status_table cannot be reverted.\n";

        return false;
    }
    */
}
