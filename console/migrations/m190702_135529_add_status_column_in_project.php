<?php

use yii\db\Migration;

/**
 * Class m190702_135529_add_status_column_in_project
 */
class m190702_135529_add_status_column_in_project extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('project', 'status', $this->integer(11)->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('project', 'status');
    }
}
