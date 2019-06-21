<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_card`.
 */
class m181003_070636_create_user_card_table extends Migration
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

        $this->createTable('user_card', [
            'id' => $this->primaryKey(),
            'fio' => $this->string(255)->notNull(),
            'passport' => $this->string(255),
            'photo' => $this->string(255),
            'email' => $this->string(255),
            'gender' => $this->tinyInteger(1),
            'dob' => $this->date(),
            'status' => $this->integer(11)->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ], $tableOptions);

        $this->addForeignKey(
            'user_card_ibfk_status',
            'user_card',
            'status',
            'status',
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
        $this->dropForeignKey('user_card_ibfk_status', 'user_card');

        $this->dropTable('user_card');
    }
}
