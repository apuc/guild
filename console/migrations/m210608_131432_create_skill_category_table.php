<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%skill_category}}`.
 */
class m210608_131432_create_skill_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%skill_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
        ]);

        $this->addColumn('skill', 'category_id', $this->integer(11));

        $this->createIndex(
            'idx-skill-category_id',
            'skill',
            'category_id'
        );

        $this->addForeignKey(
            'fk-skill-category_id',
            'skill',
            'category_id',
            'skill_category',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-skill-category_id',
            'skill'
        );

        $this->dropIndex(
            'idx-skill-category_id',
            'skill'
        );

        $this->dropColumn('skill', 'category_id');

        $this->dropTable('{{%skill_category}}');
    }
}
