<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user_card}}`.
 */
class m210625_094710_add_vc_text_column_to_user_card_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user_card}}', 'vc_text', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user_card}}', 'vc_text');
    }
}
