<?php

use yii\db\Migration;

/**
 * Class m240131_080048_add_user_id_column_at_reports_table
 */
class m240131_080048_add_user_id_column_at_reports_table extends Migration
{
    private const TABLE_NAME = "reports";

    private const COLUMN_NAME = "user_id";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE_NAME, self::COLUMN_NAME, $this->integer(11)->after("status"));
        $this->addForeignKey('fk_reports_user', self::TABLE_NAME, self::COLUMN_NAME, 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_reports_user', self::TABLE_NAME);
        $this->dropColumn(self::TABLE_NAME, self::COLUMN_NAME);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240131_080048_add_user_id_column_at_reports_table cannot be reverted.\n";

        return false;
    }
    */
}
