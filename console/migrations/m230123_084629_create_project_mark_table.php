<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project_mark}}`.
 */
class m230123_084629_create_project_mark_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%project_mark}}', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer(),
            'mark_id' => $this->integer(),
        ]);
        $this->addForeignKey('project_mark_project', 'project_mark', 'project_id', 'project', 'id');
        $this->addForeignKey('project_mark_mark', 'project_mark', 'mark_id', 'mark', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('project_mark_project', 'project_mark');
        $this->dropForeignKey('project_mark_mark', 'project_mark');
        $this->dropTable('{{%project_mark}}');
    }
}
