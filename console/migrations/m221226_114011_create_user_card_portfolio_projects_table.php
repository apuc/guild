<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_card_portfolio_projects}}`.
 */
class m221226_114011_create_user_card_portfolio_projects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_card_portfolio_projects}}', [
            'id' => $this->primaryKey(),
            'card_id' => $this->integer(),
            'title' => $this->string(),
            'description' => $this->string(),
            'main_stack' => $this->integer(),
            'additional_stack' => $this->string(),
            'link' => $this->string(),
        ]);
        $this->addForeignKey('user_card_user_card_portfolio_projects', 'user_card_portfolio_projects', 'card_id', 'user_card', 'id');
        $this->addForeignKey('skill_user_card_portfolio_projects', 'user_card_portfolio_projects', 'main_stack', 'skill', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('user_card_user_card_portfolio_projects', 'user_card_portfolio_projects');
        $this->dropForeignKey('skill_user_card_portfolio_projects', 'user_card_portfolio_projects');
        $this->dropTable('{{%user_card_portfolio_projects}}');
    }
}
