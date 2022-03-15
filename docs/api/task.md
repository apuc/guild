# Задачи

## Методы
<table>
    <tr>
        <th>
            Метод
        </th>
        <th>
            Описание
        </th>
    </tr>
    <tr>
        <td>
            get-task-list
        </td>
        <td>
            Возвращает список задач 
        </td>
    </tr>
    <tr>
        <td>
            get-task
        </td>
        <td>
            Возвращает задачу
        </td>
    </tr>
    <tr>
        <td>
            create-task
        </td>
        <td>
            Создаёт задачу 
        </td>
    </tr>
    <tr>
        <td>
            update
        </td>
        <td>
            Обновить задачу 
        </td>
    </tr>
</table>

## Список задач

`https://guild.craft-group.xyz/api/task/get-task-list?project_id=1`
<p>
    Параметры:
</p>
<table>
    <tr>
        <th>
            Параметры
        </th>
        <th>
            Значение
        </th>
    </tr>
    <tr>
        <td>
            project_id
        </td>
        <td>
            Id проекта
        </td>
    </tr>
</table>
<p>
    Без передачи параметра возвращает массив объектов <b>Задача</b> . С параметром <b>project_id</b>, 
метод возвращает объекты <b>Задача</b> определённого проекта.
</p>

<p>
    Возвращает <b>массив</b> объектов <b>Задача</b>. <br>
    Каждый объект <b>Задача</b> имеет такой вид:
</p>

```json5
[
  {
    "id": "6",
    "project_id": "74",
    "title": "Название задачи",
    "status": "1",
    "created_at": "2021-12-20 16:29:39",
    "updated_at": "2021-12-20 17:35:04",
    "description": "Описание задачи",
    "card_id_creator": "1",
    "card_id": "3"
  },
 '...'
]
```

## Получить документ

`https://guild.craft-group.xyz/api/task/get-task?task_id=15`
<p>
    Параметры:
</p>
<table>
    <tr>
        <th>
            Параметры
        </th>
        <th>
            Значение
        </th>
    </tr>
    <tr>
        <td>
            task_id
        </td>
        <td>
            Id задачи
        </td>
    </tr>
</table>

<p>
    Возвращает объект <b>Задача</b>. <br>
    Каждый объект <b>Задача</b> имеет такой вид:
</p>

```json5
{
  "id": 15,
  "project_id": 74,
  "title": "4324238888",
  "status": 1,
  "created_at": "2022-01-05 17:37:37",
  "updated_at": "2022-01-05 17:46:10",
  "description": "888",
  "card_id_creator": 1,
  "card_id": null
}
```
<p>
    Пример ошибки:
</p>

```json5
{
  "name": "Not Found",
  "message": "The task does not exist",
  "code": 0,
  "status": 404,
  "type": "yii\\web\\NotFoundHttpException"
}
```

## Создать документ

`https://guild.craft-group.xyz/api/document/create-document`
<p>
    Параметры:
</p>
<table>
    <tr>
        <th>
            Параметры
        </th>
        <th>
            Значение
        </th>
    </tr>
    <tr>
        <td>
            title
        </td>
        <td>
            Название задачи
        </td>
    </tr>
    <tr>
        <td>
            project_id
        </td>
        <td>
            Id проекта
        </td>
    </tr>
    <tr>
        <td>
            status
        </td>
        <td>
            статус задачи
        </td>
    </tr>
    <tr>
        <td>
            card_id_creator
        </td>
        <td>
            Id профиля создателя
        </td>
    </tr>
    <tr>
        <td>
            card_id
        </td>
        <td>
            Id профиля наблюдателя(не обязательный параметр)
        </td>
    </tr>
    <tr>
        <td>
            description
        </td>
        <td>
            Описание
        </td>
    </tr>
</table>

<p>
    Создаёт <b>Задача</b>. Требует передачи <b>POST</b> запроса с соответствующими
параметрами
</p>

<p>
    В случае указания не верных параметров буде возвращена соответствующая ошибка. Пример ошибки:
</p>

```json5
{
  "name": "Internal Server Error",
  "message": "{\"project_id\":[\"\П\р\о\е\к\т is invalid.\"]}",
  "code": 0,
  "status": 500,
  "type": "yii\\web\\ServerErrorHttpException"
}
```

## Обновить документ

`https://guild.craft-group.xyz/api/task/update`
<p>
    Параметры:
</p>
<table>
    <tr>
        <th>
            Параметры
        </th>
        <th>
            Значение
        </th>
    </tr>
    <tr>
        <td>
            title
        </td>
        <td>
            Название задачи
        </td>
    </tr>
    <tr>
        <td>
            project_id
        </td>
        <td>
            Id проекта
        </td>
    </tr>
    <tr>
        <td>
            status
        </td>
        <td>
            статус задачи
        </td>
    </tr>
    <tr>
        <td>
            card_id_creator
        </td>
        <td>
            Id профиля создателя
        </td>
    </tr>
    <tr>
        <td>
            card_id
        </td>
        <td>
            Id профиля наблюдателя(не обязательный параметр)
        </td>
    </tr>
    <tr>
        <td>
            description
        </td>
        <td>
            Описание
        </td>
    </tr>
</table>

<p>
    Обновляет объект <b>Задача</b>. Требует передачи <b>POST</b> запроса с соответствующими
параметрами
</p>

<p>
    В случае указания не верных параметров буде возвращена соответствующая ошибка. Пример ошибки:
</p>

```json5
{
  "name": "Not Found",
  "message": "The task does not exist",
  "code": 0,
  "status": 404,
  "type": "yii\\web\\NotFoundHttpException"
}
```