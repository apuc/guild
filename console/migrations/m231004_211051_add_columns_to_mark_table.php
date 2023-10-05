<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%mark}}`.
 */
class m231004_211051_add_columns_to_mark_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('mark', 'slug', $this->string(255));
        $this->addColumn('mark', 'color', $this->string(255));
        $this->addColumn('mark', 'status', $this->integer(1)->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('mark', 'slug');
        $this->dropColumn('mark', 'color');
        $this->dropColumn('mark', 'status');
    }
}
