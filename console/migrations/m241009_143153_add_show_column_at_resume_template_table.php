<?php

use yii\db\Migration;

/**
 * Class m241009_143153_add_show_column_at_resume_template_table
 */
class m241009_143153_add_show_column_at_resume_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("resume_template", "show_header", $this->integer(1)->defaultValue(1));
        $this->addColumn("resume_template", "show_footer", $this->integer(1)->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("resume_template","show_header");
        $this->dropColumn("resume_template","show_footer");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241009_143153_add_show_column_at_resume_template_table cannot be reverted.\n";

        return false;
    }
    */
}
