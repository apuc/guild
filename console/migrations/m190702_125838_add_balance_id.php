<?php

use yii\db\Migration;

/**
 * Class m190702_125838_add_balance_id
 */
class m190702_125838_add_balance_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('fields_value', 'balance_id', $this->integer(11)->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('fields_value', 'balance_id');
    }
}
