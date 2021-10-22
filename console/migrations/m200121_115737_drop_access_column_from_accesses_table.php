<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%accesses}}`.
 */
class m200121_115737_drop_access_column_from_accesses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%accesses}}', 'access');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%accesses}}', 'access', $this->string());
    }
}
