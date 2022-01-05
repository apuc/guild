<?php

use yii\db\Migration;

/**
 * Class m211228_123343_add_column_template_file_to_template_table
 */
class m211228_123343_add_column_template_file_to_template_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('template', 'template_file_name', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('template', 'template_file_name');
    }
}
