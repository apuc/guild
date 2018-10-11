<?php

use yii\db\Migration;

/**
 * Handles the creation of table `use_status`.
 */
class m181005_114117_create_use_status_table extends Migration
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

        $this->createTable('use_status', [
            'id' => $this->primaryKey(),
            'status_id' => $this->integer(11)->notNull(),
            'use' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'use_status_ibfk_status',
            'use_status',
            'status_id',
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
        $this->dropForeignKey('use_status_ibfk_status', 'use_status');

        $this->dropTable('use_status');
    }
}
