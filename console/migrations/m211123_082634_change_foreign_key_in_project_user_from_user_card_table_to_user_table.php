<?php

use yii\db\Migration;

/**
 * Class m211123_082634_change_foreign_key_in_project_user_from_user_card_table_to_user_table
 */
class m211123_082634_change_foreign_key_in_project_user_from_user_card_table_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('project_user_ibfk_user_card', 'project_user');
        $this->dropColumn('project_user', 'card_id');
        $this->addColumn('project_user', 'user_id', $this->integer(11)->notNull());
        $this->addForeignKey('user_project_user', 'project_user', 'user_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('user_project_user', 'project_user');
        $this->dropColumn('project_user', 'user_id');
        $this->addColumn('project_user', 'card_id', $this->integer(11)->notNull());
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

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211123_082634_change_foreign_key_in_project_user_from_user_card_table_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
