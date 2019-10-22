<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project_accesses}}`.
 */
class m191021_131536_create_project_accesses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%project_accesses}}', [
            'id' => $this->primaryKey(),
            'accesses_id' => $this->integer(),
            'project_id' => $this->integer(),
        ]);
        $this->addForeignKey('project_accesses_acc','project_accesses','accesses_id','accesses','id');
        $this->addForeignKey('project_accesses_prj','project_accesses','project_id','project','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('project_accesses_acc','project_accesses');
        $this->dropForeignKey('project_accesses_prj','project_accesses');
        $this->dropTable('{{%project_accesses}}');
    }
}
