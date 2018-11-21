<?php

use yii\db\Migration;

/**
 * Handles the creation of table `hh_job`.
 */
class m181121_112940_create_hh_job_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('hh_job', [
            'id' => $this->primaryKey(),
            'employer_id' => $this->integer(11),
            'hh_id' => $this->integer(11),
            'title' => $this->string(255),
            'url' => $this->string(255),
            'salary_from' => $this->integer(11),
            'salary_to' => $this->integer(11),
            'salary_currency' => $this->string(100),
            'address' => $this->string(255),
            'dt_add' => $this->integer(11)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('hh_job');
    }
}
