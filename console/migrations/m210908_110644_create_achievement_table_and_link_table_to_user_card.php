<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%achievement}}`.
 */
class m210908_110644_create_achievement_table_and_link_table_to_user_card extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%achievement}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255),
            'title' => $this->string(255),
            'img' => $this->text(),
            'description' => $this->text(),
            'status' => $this->integer()->defaultValue(1),
        ]);
        $this->addForeignKey(
            'fk-achievement-status',
            'achievement',
            'status',
            'status',
            'id',
            'CASCADE'
        );
        $this->createTable('{{%achievement_user_card}}', [
            'id' => $this->primaryKey(),
            'user_card_id' => $this->integer(),
            'achievement_id' => $this->integer()
        ]);
        $this->addForeignKey(
            'fk-achievement_user_card-user_id',
            'achievement_user_card',
            'user_card_id',
            'user_card',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-achievement_user_card-achievement_id',
            'achievement_user_card',
            'achievement_id',
            'achievement',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-achievement_user_card-user_id',
            'achievement_user_card'
        );

        $this->dropForeignKey(
            'fk-achievement_user_card-achievement_id',
            'achievement_user_card'
        );

        $this->dropTable('{{%achievement_user_card}}');

        $this->dropTable('{{%achievement}}');

    }
}
