<?php

use yii\db\Migration;

/**
 * Handles adding position_id to table `user_card`.
 */
class m181012_093626_add_position_id_column_to_user_card_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_card', 'position_id', $this->integer(11));
        $this->addForeignKey(
            'user_card_ibfk_position',
            'user_card',
            'position_id',
            'position',
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('user_card_ibfk_position', 'user_card');

        $this->dropColumn('project', 'company_id');
    }
}
