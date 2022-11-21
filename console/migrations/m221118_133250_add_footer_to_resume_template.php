<?php

use yii\db\Migration;

/**
 * Class m221118_133250_add_footer_to_resume_template
 */
class m221118_133250_add_footer_to_resume_template extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('resume_template', 'footer_text', $this->string());
        $this->addColumn('resume_template', 'footer_image', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('resume_template', 'footer_text');
        $this->dropColumn('resume_template', 'footer_image');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221118_133250_add_footer_to_resume_template cannot be reverted.\n";

        return false;
    }
    */
}
