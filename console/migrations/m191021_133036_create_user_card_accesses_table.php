<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_card_accesses}}`.
 */
class m191021_133036_create_user_card_accesses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_card_accesses}}', [
            'id' => $this->primaryKey(),
            'accesses_id' => $this->integer(),
            'user_card_id' => $this->integer(),
        ]);
        $this->addForeignKey('user_card_accesses_acc','user_card_accesses','accesses_id','accesses','id');
        $this->addForeignKey('user_card_accesses_uscr','user_card_accesses','user_card_id','user_card','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('user_card_accesses_acc','user_card_accesses');
        $this->dropForeignKey('user_card_accesses_uscr','user_card_accesses');
        $this->dropTable('{{%user_card_accesses}}');
    }
}
