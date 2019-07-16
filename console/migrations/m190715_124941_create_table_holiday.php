<?php

use yii\db\Migration;

/**
 * Class m190715_124941_create_table_holiday
 */
class m190715_124941_create_table_holiday extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('holiday',[
            'id' => $this->primaryKey(),
            'card_id' => $this->integer(11)->notNull(),
            'dt_start' => $this->integer(15)->notNull(),
            'dt_end' => $this->integer(15)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('holiday');
    }
}
