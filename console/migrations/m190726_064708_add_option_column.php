<?php

use yii\db\Migration;

/**
 * Class m190726_064708_add_option_column
 */
class m190726_064708_add_option_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('fields_value_new', 'type_file', $this->string(255)->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('fields_value_new', 'type_file');
    }
}
