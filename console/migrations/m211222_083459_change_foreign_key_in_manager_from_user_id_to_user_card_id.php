<?php

use yii\db\Migration;

/**
 * Class m211222_083459_change_foreign_key_in_manager_from_user_id_to_user_card_id
 */
class m211222_083459_change_foreign_key_in_manager_from_user_id_to_user_card_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('manager_user', 'manager');
        $this->dropColumn('manager', 'user_id');

        $this->addColumn('manager', 'user_card_id', $this->integer(11));
        $this->addForeignKey('manager_user_card', 'manager', 'user_card_id',
            'user_card', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('manager_user_card', 'manager');
        $this->dropColumn('manager', 'user_card_id');

        $this->addColumn('manager', 'user_id', $this->integer(11));
        $this->addForeignKey('manager_user', 'manager', 'user_id', 'user', 'id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211222_083459_change_foreign_key_in_manager_from_user_id_to_user_card_id cannot be reverted.\n";

        return false;
    }
    */
}
