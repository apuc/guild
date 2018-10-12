<?php

use yii\db\Migration;

/**
 * Handles the creation of table `skill`.
 */
class m181012_102422_create_skill_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('skill', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
        ], $tableOptions);

        $this->createTable('card_skill', [
            'id' => $this->primaryKey(),
            'card_id' => $this->integer(11)->notNull(),
            'skill_id' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'card_skill_ibfk_user_card',
            'card_skill',
            'card_id',
            'user_card',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey(
            'card_skill_ibfk_skill',
            'card_skill',
            'skill_id',
            'skill',
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

        $this->dropTable('card_skill');
        $this->dropTable('skill');
    }
}
