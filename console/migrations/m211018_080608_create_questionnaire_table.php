<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%questionnaire}}`.
 */
class m211018_080608_create_questionnaire_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%questionnaire}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'title' => $this->string(255),
            'status' => $this->integer(1),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'time_limit' => $this->integer(),
        ]);

        $this->addForeignKey('category', 'questionnaire', 'category_id', 'questionnaire_category', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('category', 'questionnaire');
        $this->dropTable('{{%questionnaire}}');
    }
}
