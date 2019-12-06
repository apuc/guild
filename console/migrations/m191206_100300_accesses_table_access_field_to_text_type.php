<?php

use yii\db\Migration;

/**
 * Class m191206_100300_accesses_table_access_field_to_text_type
 */
class m191206_100300_accesses_table_access_field_to_text_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('accesses', 'access', 'text');
    }
}
