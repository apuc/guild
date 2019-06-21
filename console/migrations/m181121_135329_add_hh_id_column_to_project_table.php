<?php

use yii\db\Migration;

/**
 * Handles adding hh_id to table `project`.
 */
class m181121_135329_add_hh_id_column_to_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('project', 'hh_id', $this->integer(11));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('project', 'hh_id');
    }
}
