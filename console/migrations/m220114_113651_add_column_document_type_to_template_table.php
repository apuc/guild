<?php

use yii\db\Migration;

/**
 * Class m220114_113651_add_column_document_type_to_template_table
 */
class m220114_113651_add_column_document_type_to_template_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('template', 'document_type', $this->integer()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('template', 'document_type');
    }
}
