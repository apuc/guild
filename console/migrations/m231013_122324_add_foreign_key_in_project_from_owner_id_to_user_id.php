<?php

use yii\db\Migration;

/**
 * Class m231013_122324_add_foreign_key_in_project_from_owner_id_to_user_id
 */
class m231013_122324_add_foreign_key_in_project_from_owner_id_to_user_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'project_user',
            'project',
            'owner_id',
            'user',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('project_user', 'project');
    }
}
