<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%mark_entity}}`.
 */
class m231004_212828_create_mark_entity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mark_entity}}', [
            'id' => $this->primaryKey(),
            'mark_id' => $this->integer(11)->notNull(),
            'entity_type' => $this->integer(1)->notNull(),
            'entity_id' => $this->integer(11)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mark_entity}}');
    }
}
