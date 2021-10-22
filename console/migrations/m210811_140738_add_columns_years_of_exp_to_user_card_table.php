<?php

use yii\db\Migration;

/**
 * Class m210811_140738_add_columns_years_of_exp_to_user_card_table
 */
class m210811_140738_add_columns_years_of_exp_to_user_card_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_card', 'years_of_exp', $this->integer(2));
        $this->addColumn('user_card', 'specification', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user_card', 'years_of_exp');
        $this->dropColumn('user_card', 'specification');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210811_140738_add_columns_years_of_exp_to_user_card_table cannot be reverted.\n";

        return false;
    }
    */
}
