<?php

use yii\db\Migration;

/**
 * Class m221110_133204_add_header__to_resume_template
 */
class m221110_133204_add_header_to_resume_template extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('resume_template', 'header_text', $this->string());
        $this->addColumn('resume_template', 'header_image', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('resume_template', 'header_text');
        $this->dropColumn('resume_template', 'header_image');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221110_133204_add_header__to_resume_template cannot be reverted.\n";

        return false;
    }
    */
}
