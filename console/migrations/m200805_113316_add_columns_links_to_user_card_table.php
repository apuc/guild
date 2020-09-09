<?php

use yii\db\Migration;

/**
 * Class m200805_113316_add_columns_links_to_user_card_table
 */
class m200805_113316_add_columns_links_to_user_card_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_card', 'link_vk', $this->string(255));
        $this->addColumn('user_card', 'link_telegram', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user_card', 'link_vk');
        $this->dropColumn('user_card', 'link_telegram');
    }
}
