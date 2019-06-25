<?php

use yii\db\Migration;

/**
 * Class m181011_142555_add_column_to_user_card
 */
class m181011_142555_add_column_to_user_card extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_card', 'salary', $this->string(100));
        $this->addColumn('project', 'budget', $this->string(100));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user_card', 'salary');
        $this->dropColumn('project', 'budget');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181011_142555_add_column_to_user_card cannot be reverted.\n";

        return false;
    }
    */
}
