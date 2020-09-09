<?php

use yii\db\Migration;

/**
 * Class m200803_135837_add_table_options_to_company_table
 */
class m200803_135837_add_table_options_to_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->driverName === 'mysql') {
            $this->execute('ALTER TABLE company DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if ($this->db->driverName === 'mysql') {
            $this->execute('ALTER TABLE company DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ENGINE=InnoDB');
        }
    }
}

