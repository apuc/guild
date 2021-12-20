<?php

use yii\db\Migration;

/**
 * Class m211220_105942_change_foreign_keys_in_task_from_user_id_to_user_card_id
 */
class m211220_105942_change_foreign_keys_in_task_from_user_id_to_user_card_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('creator_task', 'task');
        $this->dropColumn('task', 'user_id_creator');

        $this->dropForeignKey('task_user', 'task');
        $this->dropColumn('task', 'user_id');

        $this->addColumn('task', 'card_id_creator', $this->integer(11)->defaultValue(null));
        $this->addForeignKey('task_user_card_creator', 'task', 'card_id_creator',
            'user_card', 'id');

        $this->addColumn('task', 'card_id', $this->integer(11)->defaultValue(null));
        $this->addForeignKey('task_user_card', 'task', 'card_id', 'user_card', 'id');


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('task_user_card', 'task');
        $this->dropColumn('task', 'card_id');

        $this->dropForeignKey('task_user_card_creator', 'task');
        $this->dropColumn('task', 'card_id_creator');



        $this->addColumn('task', 'user_id_creator', $this->integer());
        $this->addForeignKey('creator_task', 'task',
            'user_id_creator', 'user', 'id');

        $this->addColumn('task', 'user_id', $this->integer());
        $this->addForeignKey('task_user', 'task',
            'user_id', 'user', 'id');
    }
}
