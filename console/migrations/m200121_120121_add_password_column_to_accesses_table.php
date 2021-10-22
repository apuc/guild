<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%accesses}}`.
 */
class m200121_120121_add_password_column_to_accesses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%accesses}}', 'password', $this->string());
        $this->addColumn('{{%accesses}}', 'link', $this->string());
        $this->addColumn('{{%accesses}}', 'project', $this->string());
        $this->addColumn('{{%accesses}}', 'info', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%accesses}}', 'password');
        $this->dropColumn('{{%accesses}}', 'link');
        $this->dropColumn('{{%accesses}}', 'project');
        $this->dropColumn('{{%accesses}}', 'info');
    }
}
