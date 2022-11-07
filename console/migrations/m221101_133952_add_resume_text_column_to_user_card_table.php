<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user_card}}`.
 */
class m221101_133952_add_resume_text_column_to_user_card_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_card', 'resume_text', $this->text()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user_card', 'resume_text');
    }
}
