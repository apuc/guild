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