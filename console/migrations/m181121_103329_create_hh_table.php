<?php

use yii\db\Migration;

/**
 * Handles the creation of table `hh`.
 */
class m181121_103329_create_hh_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('hh', [
            'id' => $this->primaryKey(),
            'hh_id' => $this->integer(11),
            'url' => $this->string(255)->notNull(),
            'title' => $this->string(255),
            'dt_add' => $this->integer(11),
            'photo' => $this->string(255)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('hh');
    }
}
