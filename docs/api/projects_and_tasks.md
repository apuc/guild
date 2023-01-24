## Проекты 

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
            project
        </td>
        <td>
             Получить проект
        </td>
    </tr>
    <tr>
        <td>
            project-list
        </td>
        <td>
            Получить список проектов 
        </td>
    </tr>
    <tr>
        <td>
            status-list
        </td>
        <td>
            Получить список статусов для проекта
        </td>
    </tr>
    <tr>
        <td>
            create
        </td>
        <td>
            Создать проект
        </td>
    </tr>
    <tr>
        <td>
            update
        </td>
        <td>
            Изменить проект
        </td>
    </tr>
</table>

### Получить проект
`https://guild.craft-group.xyz/api/project/get-project`
<p>
    Для получения проекта необходимо отправить <b>GET</b> запрос на URL https://guild.craft-group.xyz/api/project/get-project
</p>

<p>
    Требуемые параметры:
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
             ID проекта
        </td>
    </tr>
</table>

<p>
    Пример запроса:
</p>

`https://guild.craft-group.xyz/api/project/get-project?project_id=1`

<p>
    Возвращает объект проекта имеющий такой вид:
</p>

```json5
{
  "id": 1,
  "name": "проект название",
  "budget": "333",
  "status": 5,
  "hh_id": {
    "id": 1,
    "hh_id": null,
    "url": "knkjsefnejkdbvjfdbv",
    "title": null,
    "dt_add": null,
    "photo": null
  },
  "company": {
    "id": 1,
    "name": "Рога и копыта",
    "description": "Живодёрня"
  },
  "_links": {
    "self": {
      "href": "http://guild.loc/api/project/index?project_id=1"
    }
  }
}
```

### Получить список проектов
`https://guild.craft-group.xyz/api/project/project-list`
<p>
    Для получения списка проектов необходимо отправить <b>GET</b> запрос на URL https://guild.craft-group.xyz/api/project/project-list
</p>

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
            card_id
        </td>
        <td>
             ID профиля пользователя (При передаче этого параметра будет возвращён список проектов в которых задействован конкретный пользователь, без него будет возвращён список всех проектов)
        </td>
    </tr>
</table>

<p>
    Пример запроса:
</p>

`https://guild.craft-group.xyz/api/project/project-list?card_id=1`

<p>
    Возвращает массив объектов проект имеющий такой вид:
</p>

```json5
{
  "projects": [
    {
      "id": 1,
      "name": "проект название",
      "budget": "333",
      "status": 5,
      "hh_id": {
        "id": 1,
        "hh_id": null,
        "url": "knkjsefnejkdbvjfdbv",
        "title": null,
        "dt_add": null,
        "photo": null
      },
      "company": {
        "id": 1,
        "name": "Рога и копыта",
        "description": "Живодёрня"
      },
      "_links": {
        "self": {
          "href": "http://guild.loc/api/project/index?project_id=1"
        }
      }
    },
    {
      "id": 3,
      "name": "тестовый проект",
      "budget": "333",
      "status": 5,
      "hh_id": {
        "id": 1,
        "hh_id": null,
        "url": "knkjsefnejkdbvjfdbv",
        "title": null,
        "dt_add": null,
        "photo": null
      },
      "company": null,
      "_links": {
        "self": {
          "href": "http://guild.loc/api/project/index?project_id=3"
        }
      }
    }
  ],
  "_links": {
    "self": {
      "href": "http://guild.loc/api/project/project-list?card_id=1&page=1"
    },
    "first": {
      "href": "http://guild.loc/api/project/project-list?card_id=1&page=1"
    },
    "last": {
      "href": "http://guild.loc/api/project/project-list?card_id=1&page=1"
    }
  },
  "_meta": {
    "totalCount": 2,
    "pageCount": 1,
    "currentPage": 1,
    "perPage": 20
  }
}
```

### Получить список статусов для проекта
`https://guild.craft-group.xyz/api/project/status-list`
<p>
    Для получения списка статусов проекта необходимо отправить <b>GET</b> запрос на URL https://guild.craft-group.xyz/api/project/status-list
</p>

<p>
    Требуемые параметры: не требуются
</p>

<p>
    Пример запроса:
</p>

`https://guild.craft-group.xyz/api/project/status-list`

<p>
    Возвращает массив объектов статус имеющий такой вид:
</p>

```json5
[
  {
    "id": 5,
    "name": "проект"
  },
  {
    "id": 6,
    "name": "проект статус 2"
  }
]
```

### Создать проект

`https://guild.craft-group.xyz/api/project/create`

<p>
    Для создания нового проекта необходимо отправить <b>POST</b> запрос на URL https://guild.craft-group.xyz/api/project/create
</p>

<p>
    Параметры:
</p>
* - обязательные параметры
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
            * name
        </td>
        <td>
              название проекта
        </td>
    </tr>
    <tr>
        <td>
            * status
        </td>
        <td>
              статус проекта
        </td>
    </tr>
    <tr>
        <td>
            description
        </td>
        <td>
            описание проекта
        </td>
    </tr>
    <tr>
        <td>
            budget
        </td>
        <td>
            бюджет проекта
        </td>
    </tr>
    <tr>
        <td>
            company_id
        </td>
        <td>
            ID компании
        </td>
    </tr><tr>
        <td>
            $hh_id
        </td>
        <td>
            ID hh
        </td>
    </tr>
</table>

<p>
    Пример запроса:
</p>

`https://guild.craft-group.xyz/api/project/create`

<p>
    Возвращает массив объектов статус имеющий такой вид:
</p>

```json5
{
  "id": 10,
  "name": "test",
  "budget": "333",
  "status": "5",
  "hh_id": null,
  "company": null,
  "_links": {
    "self": {
      "href": "http://guild.loc/api/project/index?project_id=10"
    }
  }
}
```

### Обновить проект

`https://guild.craft-group.xyz/api/project/update`

<p>
    Для создания нового проекта необходимо отправить <b>POST</b> запрос на URL https://guild.craft-group.xyz/api/project/update
</p>

<p>
    Параметры:
</p>
* - обязательные параметры
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
            * project_id
        </td>
        <td>
              ID проекта
        </td>
    </tr>
    <tr>
        <td>
            status
        </td>
        <td>
              статус проекта
        </td>
    </tr>
    <tr>
        <td>
            name
        </td>
        <td>
            название
        </td>
    </tr>
    <tr>
        <td>
            description
        </td>
        <td>
            описание проекта
        </td>
    </tr>
    <tr>
        <td>
            budget
        </td>
        <td>
            бюджет проекта
        </td>
    </tr>
    <tr>
        <td>
            company_id
        </td>
        <td>
            ID компании
        </td>
    </tr>
    <tr>
        <td>
            hh_id
        </td>
        <td>
            ID hh
        </td>
    </tr>
</table>

<p>
    Пример запроса:
</p>

`https://guild.craft-group.xyz/api/project/update`

<p>
    Возвращает массив объектов статус имеющий такой вид:
</p>

```json5
{
  "id": 7,
  "name": "777nnknkfg666",
  "budget": "333",
  "status": "5",
  "hh_id": {
    "id": 1,
    "hh_id": null,
    "url": "knkjsefnejkdbvjfdbv",
    "title": null,
    "dt_add": null,
    "photo": null
  },
  "company": {
    "id": 1,
    "name": "Рога и копыта",
    "description": "Живодёрня"
  },
  "_links": {
    "self": {
      "href": "http://guild.loc/api/project/index?project_id=7"
    }
  }
}
```

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

## Обновить задачу

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

## Исполнители задачи
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
            get-task-users
        </td>
        <td>
            Список исплнителей задачи 
        </td>
    </tr>
    <tr>
        <td>
            set-task-users
        </td>
        <td>
            Назначить исполнителя на задачу
        </td>
    </tr>
</table>

### Список исполнителей задачи
`https://guild.craft-group.xyz/api/task-user/get-task-users`
<p>
    Для получения списка исполнителей необходимо отправить <b>GET</b> запрос на URL https://guild.craft-group.xyz/api/task-user/get-task-users
</p>

<p>
    Требуемые параметры:
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
             ID задачи
        </td>
    </tr>
</table>

<p>
    Пример запроса:
</p>

`https://guild.craft-group.xyz/api/task-user/get-task-users?task_id=10`

<p>
    Возвращает массив сотрудников проекта закреплённых за задачей. <br>
    Каждый ответ имеет такой вид:
</p>

```json5
[
  {
    "id": 5,
    "task_id": 10,
    "project_user_id": 1
  },
  {
    "id": 7,
    "task_id": 10,
    "project_user_id": 5
  }
]
```
<p>
    Параметры объекта <b>Исполнитель</b>:
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
            id
        </td>
        <td>
            ID исполнителя задачи(int)
        </td>
    </tr>
    <tr>
        <td>
            task_id
        </td>
        <td>
             ID задачи(int)
        </td>
    </tr>
    <tr>
        <td>
            project_user_id
        </td>
        <td>
            ID сотрудника на проекте(int)
        </td>
    </tr>
</table>
<p>
    Если задача не найдена будет отправлено следующее сообщение:
</p>

```json5
{
  "name": "Not Found",
  "message": "The task does not exist or there are no employees for it",
  "code": 0,
  "status": 404,
  "type": "yii\\web\\NotFoundHttpException"
}
```
### Назначить сотрудника на задачу
`https://guild.craft-group.xyz/api/task-user/set-task-users`
<p>
    Для назначения исполнителя необходимо отправить <b>POST</b> запрос на URL https://guild.craft-group.xyz/api/task-user/set-task-user
</p>

<p>
    Требуемые параметры:
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
             ID задачи
        </td>
    </tr>
    <tr>
        <td>
            project_user_id
        </td>
        <td>
             ID сотрудника на проекте
        </td>
    </tr>
</table>

<p>
    Пример запроса:
</p>

`https://guild.craft-group.xyz/api/task-user/set-task-user`

<p>
    Возвращает объект <b>Исполнителя задачи</b>.<br>
    Каждый ответ имеет такой вид:
</p>

```json5
{
  "task_id": "10",
  "project_user_id": "5",
  "id": 8
}
```

<p>
    Если задача не найдена будет отправлено следующее сообщение:
</p>

```json5
{
  "name": "Bad Request",
  "message": "{\"task_id\":[\"\З\а\д\а\ч\а is invalid.\"]}",
  "code": 0,
  "status": 400,
  "type": "yii\\web\\BadRequestHttpException"
}
```