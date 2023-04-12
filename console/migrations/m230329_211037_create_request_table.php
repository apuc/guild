<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%request}}`.
 */
class m230329_211037_create_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'user_id' => $this->integer(11)->notNull(),
            'title' => $this->string(255)->notNull(),
            'position_id' => $this->integer(11),
            'skill_ids' => $this->string(255),
            'knowledge_level_id' => $this->integer(11),
            'descr' => $this->text(),
            'specialist_count' => $this->integer(2),
            'status' => $this->integer(1)->defaultValue(0)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%request}}');
    }
}
