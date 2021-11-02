<?php

use yii\db\Migration;

/**
 * Class m211102_130441_change_time_limit_type_in_questionnaire_table
 */
class m211102_130441_change_time_limit_type_in_questionnaire_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('questionnaire','time_limit', 'time' );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('questionnaire','time_limit', 'integer' );
    }
}
