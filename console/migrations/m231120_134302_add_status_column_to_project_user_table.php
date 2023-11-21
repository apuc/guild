<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%project_user}}`.
 */
class m231120_134302_add_status_column_to_project_user_table extends Migration
{
    private const TABLE_NAME = 'project_user';
    private const TABLE_COLUMN = 'status';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE_NAME, self::TABLE_COLUMN, $this->integer()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE_NAME, self::TABLE_COLUMN);
    }
}
