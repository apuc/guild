<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%options}}`.
 */
class m210609_102606_create_options_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%options}}', [
            'id' => $this->primaryKey(),
            'label' => $this->string(255),
            'key' => $this->string(255)->notNull(),
            'value' => $this->text(),
            'status' => $this->integer(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%options}}');
    }
}
