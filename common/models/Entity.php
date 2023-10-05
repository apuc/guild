<?php

namespace common\models;

class Entity
{

    const ENTITY_TYPE_PROJECT = 1;
    const ENTITY_TYPE_TASK = 2;

    /**
     * @return string[]
     */
    public static function getEntityTypeList(): array
    {
        return [
            self::ENTITY_TYPE_PROJECT => "Проект",
            self::ENTITY_TYPE_TASK => "Задача",
        ];
    }

}