<?php

namespace common\models;

class Entity
{

    const ENTITY_TYPE_PROJECT = 1;
    const ENTITY_TYPE_TASK = 2;

    const ENTITY_TYPE_REQUEST = 3;

    const ENTITY_TYPE_REPORT = 4;

    /**
     * @return string[]
     */
    public static function getEntityTypeList(): array
    {
        return [
            self::ENTITY_TYPE_PROJECT => "Проект",
            self::ENTITY_TYPE_TASK => "Задача",
            self::ENTITY_TYPE_REQUEST => "Запрос на создание проекта",
            self::ENTITY_TYPE_REPORT => "Отчет",
        ];
    }

}