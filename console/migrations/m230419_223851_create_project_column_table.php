<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project_column}}`.
 */
class m230419_223851_create_project_column_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%project_column}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'project_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'status' => $this->integer(1)->defaultValue(1)
        ]);

        $this->addForeignKey('fk_project_column_project', 'project_column', 'project_id', 'project', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_project_column_project', 'project_column');
        $this->dropTable('{{%project_column}}');
    }
}
