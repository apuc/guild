<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user_card}}`.
 */
class m221111_124753_add_resume_template_id_column_to_user_card_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_card','resume_template_id', $this->integer());
        $this->addForeignKey('resume_template_user_card', 'user_card', 'resume_template_id', 'resume_template', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('resume_template_user_card', 'user_card');
        $this->dropColumn('user_card', 'resume_template_id');
    }
}
