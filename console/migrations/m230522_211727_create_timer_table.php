<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%timer}}`.
 */
class m230522_211727_create_timer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%timer}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->dateTime(),
            'stopped_at' => $this->dateTime(),
            'user_id' => $this->integer(11)->notNull(),
            'entity_type' => $this->integer(2)->notNull(),
            'entity_id' => $this->integer(11)->notNull(),
            'status' => $this->integer(1)->defaultValue(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%timer}}');
    }
}
