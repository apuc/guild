<?php

use yii\db\Migration;

/**
 * Class m211102_130931_change_time_limit_type_in_question_table
 */
class m211102_130931_change_time_limit_type_in_question_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('question','time_limit', 'time' );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('question','time_limit', 'integer' );
    }
}
