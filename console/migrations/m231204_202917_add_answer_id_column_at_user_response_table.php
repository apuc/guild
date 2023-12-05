<?php

use yii\db\Migration;

/**
 * Class m231204_202917_add_answer_id_column_at_user_response_table
 */
class m231204_202917_add_answer_id_column_at_user_response_table extends Migration
{
    private const TABLE_NAME = 'user_response';
    private const TABLE_COLUMN = 'answer_id';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE_NAME, self::TABLE_COLUMN, $this->integer()->defaultValue(null)->after('question_id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE_NAME, self::TABLE_COLUMN);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231204_202917_add_answer_id_column_at_user_response_table cannot be reverted.\n";

        return false;
    }
    */
}
