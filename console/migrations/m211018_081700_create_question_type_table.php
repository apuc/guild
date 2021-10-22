<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%question_type}}`.
 */
class m211018_081700_create_question_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%question_type}}', [
            'id' => $this->primaryKey(),
            'question_type' => $this->string(255),
            'slug' => $this->string(255),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%question_type}}');
    }
}
