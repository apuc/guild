<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%manager}}`.
 */
class m211115_125911_create_manager_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%manager}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
        ]);
        $this->addForeignKey('manager_user', 'manager', 'user_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('manager_user', 'manager');
        $this->dropTable('{{%manager}}');
    }
}
