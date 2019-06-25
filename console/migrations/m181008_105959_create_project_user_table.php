<?php

use yii\db\Migration;

/**
 * Handles the creation of table `project_user`.
 */
class m181008_105959_create_project_user_table extends Migration
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

        $this->createTable('project_user', [
            'id' => $this->primaryKey(),
            'card_id' => $this->integer(11)->notNull(),
            'project_id' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'project_user_ibfk_project',
            'project_user',
            'project_id',
            'project',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey(
            'project_user_ibfk_user_card',
            'project_user',
            'card_id',
            'user_card',
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
        $this->dropForeignKey('project_user_ibfk_project', 'project_user');
        $this->dropForeignKey('project_user_ibfk_user_card', 'project_user');

        $this->dropTable('project_user');
    }
}
