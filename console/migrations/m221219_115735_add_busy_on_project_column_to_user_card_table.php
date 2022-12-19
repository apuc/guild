<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user_card}}`.
 */
class m221219_115735_add_busy_on_project_column_to_user_card_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_card', 'at_project', $this->integer(2)->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user_card', 'at_project');
    }
}
