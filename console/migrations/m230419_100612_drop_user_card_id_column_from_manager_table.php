<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%manager}}`.
 */
class m230419_100612_drop_user_card_id_column_from_manager_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('manager_user_card', 'manager');;
        $this->dropColumn('manager', 'user_card_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('manager', 'user_card_id', $this->integer(11));
        $this->addForeignKey('manager_user_card', 'manager', 'user_card_id',
            'user_card', 'id');
    }
}
