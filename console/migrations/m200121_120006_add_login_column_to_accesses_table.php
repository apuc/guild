<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%accesses}}`.
 */
class m200121_120006_add_login_column_to_accesses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%accesses}}', 'login', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%accesses}}', 'login');
    }
}
