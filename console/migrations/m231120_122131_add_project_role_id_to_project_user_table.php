<?php

use yii\db\Migration;

/**
 * Class m231120_122131_add_project_role_id_to_project_user_table
 */
class m231120_122131_add_project_role_id_to_project_user_table extends Migration
{
    private const TABLE_NAME = 'project_user';
    private const TABLE_COLUMN = 'project_role_id';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE_NAME, self::TABLE_COLUMN, $this->integer()->defaultValue(null));

        $this->addForeignKey(
            'project_role_project_user',
            self::TABLE_NAME,
            self::TABLE_COLUMN,
            'project_role',
            'id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('project_role_project_user', self::TABLE_NAME);
        $this->dropColumn(self::TABLE_NAME, self::TABLE_COLUMN );
    }
}
