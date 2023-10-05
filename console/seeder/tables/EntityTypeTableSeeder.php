<?php

namespace console\seeder\tables;

use diecoding\seeder\TableSeeder;
use common\models\EntityType;

/**
 * Handles the creation of seeder `EntityType::tableName()`.
 */
class EntityTypeTableSeeder extends TableSeeder
{
    // public $truncateTable = false;
    // public $locale = 'en_US';

    /**
     * {@inheritdoc}
     */
    public function run()
    {

        $this->insert(EntityType::tableName(), [
            'type' => 1,
            'name' => 'Задача',
            'slug' => 'task',
            'created_at' => $this->faker->dateTime()->format("Y-m-d H:i:s"),
            'updated_at' => $this->faker->dateTime()->format("Y-m-d H:i:s"),
        ]);

        $this->insert(EntityType::tableName(), [
            'type' => 2,
            'name' => 'Проект',
            'slug' => 'project',
            'created_at' => $this->faker->dateTime()->format("Y-m-d H:i:s"),
            'updated_at' => $this->faker->dateTime()->format("Y-m-d H:i:s"),
        ]);
    }
}
