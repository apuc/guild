<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%fk_reports_user_card_id_at_reports}}`.
 */
class m240131_132201_drop_fk_reports_user_card_id_at_reports_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey("fk-reports-user_card_id", "reports");
        $this->dropIndex("idx-reports-user_card_id", "reports");
        $this->alterColumn("reports", "user_card_id", $this->integer(11));
        $this->alterColumn("reports", "status", $this->integer(1)->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
