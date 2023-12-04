<?php

use yii\db\Migration;

/**
 * Class m231026_071555_add_column_description_to_questionnaire_table
 */
class m231026_071555_add_column_description_to_questionnaire_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('questionnaire', 'description', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('questionnaire', 'description');
    }
}
