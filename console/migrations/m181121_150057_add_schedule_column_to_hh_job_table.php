<?php

use yii\db\Migration;

/**
 * Handles adding schedule to table `hh_job`.
 */
class m181121_150057_add_schedule_column_to_hh_job_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('hh_job', 'schedule', $this->string(100));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('hh_job', 'schedule');
    }
}
