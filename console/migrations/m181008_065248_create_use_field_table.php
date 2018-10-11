<?php

use yii\db\Migration;

/**
 * Handles the creation of table `use_field`.
 */
class m181008_065248_create_use_field_table extends Migration
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
        $this->createTable('use_field', [
            'id' => $this->primaryKey(),
            'field_id' => $this->integer(11)->notNull(),
            'use' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'use_field_ibfk_additional_fields',
            'use_field',
            'field_id',
            'additional_fields',
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
        $this->dropForeignKey('use_field_ibfk_additional_fields', 'use_field');

        $this->dropTable('use_field');
    }
}
