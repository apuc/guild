<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity_type}}`.
 */
class m230926_121504_create_entity_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%entity_type}}', [
            'id' => $this->primaryKey(),
            'type' => $this->tinyInteger(),
            'name' => $this->string(),
            'slug' => $this->string(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%entity_type}}');
    }
}
