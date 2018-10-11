<?php

use yii\db\Migration;

/**
 * Handles the creation of table `fields_value`.
 */
class m181003_092319_create_fields_value_table extends Migration
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

        $this->createTable('fields_value', [
            'id' => $this->primaryKey(),
            'card_id' => $this->integer(11)->notNull(),
            'field_id' => $this->integer(11)->notNull(),
            'value' => $this->string(255)->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'fields_value_ibfk_additional_fields',
            'fields_value',
            'field_id',
            'additional_fields',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey(
            'fields_value_ibfk_user_card',
            'fields_value',
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
        $this->dropForeignKey('fields_value_ibfk_additional_fields','fields_value');
        $this->dropForeignKey('fields_value_ibfk_user_card','fields_value');

        $this->dropTable('fields_value');
    }
}
