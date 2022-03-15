<?php

use yii\db\Migration;

/**
 * Class m220214_143240_add_column_testing_date_to_user_questionnaire_table
 */
class m220214_143240_add_column_testing_date_to_user_questionnaire_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_questionnaire', 'testing_date', $this->dateTime()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user_questionnaire', 'testing_date');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220214_143240_add_column_testing_date_to_user_questionnaire_table cannot be reverted.\n";

        return false;
    }
    */
}
