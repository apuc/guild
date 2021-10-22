<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%questionnaire_category}}`.
 */
class m211018_080043_create_questionnaire_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%questionnaire_category}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'status' => $this->integer(1),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%questionnaire_category}}');
    }
}
