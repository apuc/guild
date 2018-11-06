<?php

use yii\db\Migration;

/**
 * Handles adding deleted_at to table `user_card`.
 */
class m181106_082016_add_deleted_at_column_to_user_card_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_card', 'deleted_at', $this->datetime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user_card', 'deleted_at');
    }
}
