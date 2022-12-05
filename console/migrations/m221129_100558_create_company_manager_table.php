<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%company_manager}}`.
 */
class m221129_100558_create_company_manager_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%company_manager}}', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer(),
            'user_card_id' => $this->integer(),
        ]);
        $this->addForeignKey('company_company_manager', 'company_manager', 'company_id', 'company', 'id');
        $this->addForeignKey('user_card_company_manager', 'company_manager', 'user_card_id', 'user_card', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('company_company_manager', 'company_manager');
        $this->dropForeignKey('user_card_company_manager', 'company_manager');
        $this->dropTable('{{%company_manager}}');
    }
}
