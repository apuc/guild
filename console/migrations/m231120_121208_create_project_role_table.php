<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project_role}}`.
 */
class m231120_121208_create_project_role_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%project_role}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%project_role}}');
    }
}
