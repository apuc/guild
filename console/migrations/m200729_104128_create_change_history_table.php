<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%change_history}}`.
 */
class m200729_104128_create_change_history_table extends Migration
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

        $this->createTable('{{%change_history}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(255),
            'type_id' => $this->integer(),
            'field_name' => $this->string(255),
            'label' => $this->string(255),
            'old_value' => $this->string(255),
            'new_value' => $this->string(255),
            'created_at' => $this->dateTime(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%change_history}}');
    }
}
