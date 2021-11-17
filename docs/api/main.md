# Документация API

## Навыки
### Популярные навыки
`https://guild.craft-group.xyz/api/skills/skills-on-main-page`
<p>
    Чтобы получить популярные навыки нужно сделать <b>GET</b> запрос на URL https://guild.craft-group.xyz/api/skills/skills-on-main-page
</p>

## Профиль
### Список
`https://guild.craft-group.xyz/api/profile`
<p>
    Для получения списка профилей необходимо отправить <b>GET</b> запрос на URL https://guild.craft-group.xyz/api/profile
</p>
<p>
    Возможные параметры:
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
            limit
        </td>
        <td>
            Количество профилей, которое вернет сервер при запросе. 
        </td>
    </tr>
    <tr>
        <td>
            offset
        </td>
        <td>
            Количество записей на которое нужно отступить в списке профилей. 
        </td>
    </tr>
    <tr>
        <td>
            skills
        </td>
        <td>
            Идентификаторы навыков по которым нужно отфильтровать профили. 
        </td>
    </tr>
</table>
<p>
    Пример запроса:
</p>

`https://guild.craft-group.xyz/api/profile?limit=5&offset=5&skills=1,2`

<p>
    Возвращает <b>массив</b> объектов <b>Профилей</b>. <br>
    Каждый объект <b>Профиля</b> имеет такой вид:
</p>

```json5
{
  "id": "1",
  "fio": "f23f",
  "passport": "f23", 
  "photo": "''", 
  "email": "f", 
  "gender": "1", 
  "dob": "2021-09-17", 
  "status": "2",
  "created_at": "2021-09-08 16:30:34",
  "updated_at": "2021-09-09 08:41:02",
  "resume": "", 
  "salary": "", 
  "position_id": "1",
  "deleted_at": null, 
  "id_user": "1", 
  "city": "", 
  "link_vk": "",
  "link_telegram": "",
  "vc_text": "",
  "level": "2", //
  "vc_text_short": "",
  "years_of_exp": "0",
  "specification": "",
  "skillValues": [ //Массив навыков привязанных к этому профилю
    {
      "id": "1",
      "card_id": "1", //card_id из таблицы card_skill
      "skill_id": "1",//skill_id из таблицы card_skill
      "skill": {
        "id": "1", //id из таблицы skill
        "name": "SQL",
        "category_id": "1"
      }
    },
    //...
  ],
  "achievements": [ //Массив достижений привязанных к этому профилю
    {
      "id": "7",
      "user_card_id": "1",//user_card_id из таблицы achievement_user_card
      "achievement_id": "1",//achievement_id из таблицы achievement_user_card
      "achievement": {
        "id": "1", //id из таблицы achievement
        "slug": "newguy",
        "title": "Новичок",
        "img": "",
        "description": "Ты начал у нас работу",
        "status": "1" // 1 - Активно, 2 - Неактивно
      }
    },
    //...
  ]
}
```


### Одна запись
`https://guild.craft-group.xyz/api/profile/{id}`

<p>
    Для того, чтобы получить данные одной записи необходимо отправить <b>GET</b> запрос
    на URL https://guild.craft-group.xyz/api/profile/{id} , где <b>id</b> это идентификатор 
    профиля.
</p>
<p> 
    Пример запроса:
</p>

`https://guild.craft-group.xyz/api/profile/6`

<p>
    Возвращает объект <b>Профиля</b>. <br>
    Как выглядит можно посмотреть выше.
</p>


### Пригласить на собеседование
`https://guild.craft-group.xyz/api/profile/add-to-interview`

<p>
    Для того, отправить приглашение профилю на собеседование, необходимо сделать 
    <b>POST</b> запрос на URL https://guild.craft-group.xyz/api/profile/add-to-interview
</p>
<p>
    Возможные параметры:
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
            email*
        </td>
        <td>
            Почта пользователя, который хочет пригласить на собеседование. 
        </td>
    </tr>
    <tr>
        <td>
            profile_id*
        </td>
        <td>
            Идентификатор профиля. 
        </td>
    </tr>
    <tr>
        <td>
            phone
        </td>
        <td>
            Телефон.
        </td>
    </tr>
    <tr>
        <td>
            comment
        </td>
        <td>
            Дополнительные пожелания по собеседованию. 
        </td>
    </tr>
</table>

## Отчет
### Список
`https://guild.craft-group.xyz/api/reports`
<p>
    Для получения списка отчетов необходимо отправить <b>GET</b> запрос на URL https://guild.craft-group.xyz/api/reports
</p>

<p>
    Возможные параметры:
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
            fromDate*
        </td>
        <td>
            Дата (yyyy-mm-dd) начала поиска отчетов.
        </td>
    </tr>
    <tr>
        <td>
            toDate
        </td>
        <td>
            Дата (yyyy-mm-dd) окончания поиска отчетов.
        </td>
    </tr>
    <tr>
        <td>
            limit
        </td>
        <td>
            Количество отчетов, которое вернет сервер при запросе (по умолчанию 10). 
        </td>
    </tr>
    <tr>
        <td>
            offset
        </td>
        <td>
            Количество записей на которое нужно отступить в списке отчетов. 
        </td>
    </tr>
    <tr>
        <td>
            user_id
        </td>
        <td>
            Идентификатор карточки пользователя отчета. 
        </td>
    </tr>
</table>
<p>
    Пример запроса:
</p>

`https://guild.craft-group.xyz/api/reports/index?fromDate=2021-08-01&toDate=2021-08-31&user_id=2limit=3&offset=2`

### Создать отчет
`https://guild.craft-group.xyz/api/reports/create`

<p>
    Для того, отправить приглашение профилю на собеседование, необходимо сделать 
    <b>POST</b> запрос на URL https://guild.craft-group.xyz/api/reports/create
</p>
<p>
    Возможные параметры:
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
            created_at*
        </td>
        <td>
            Дата (yyyy-mm-dd) создания.
        </td>
    </tr>
    <tr>
        <td>
            user_card_id*
        </td>
        <td>
            Идентификатор карточки пользователя. 
        </td>
    </tr>
    <tr>
        <td>
            today
        </td>
        <td>
            Сделанное сегодня. 
        </td>
    </tr>
    <tr>
        <td>
            difficulties
        </td>
        <td>
            Сложности.
        </td>
    </tr>
 <tr>
        <td>
            tomorrow
        </td>
        <td>
            Планы на завтра.
        </td>
    </tr>
 <tr>
        <td>
            status
        </td>
        <td>
             Номер статуса.
        </td>
    </tr>
</table>

### Удалить отчет
`https://guild.craft-group.xyz/api/reports/delete`

<p>
    Для удаления отчета необходимо отправить <b>GET</b> запрос на URL https://guild.craft-group.xyz/api/reports/delete
</p>

<p>
    Возможные параметры:
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
            id*
        </td>
        <td>
            Идентификатор отчета.
        </td>
    </tr>
</table>
<p>
    Пример запроса:
</p>

`https://guild.craft-group.xyz/api/reports/delete?id=17`
### Обновить отчет

`https://guild.craft-group.xyz/api/reports/update`

<p>
    Для удаления отчета необходимо отправить <b>GET</b> запрос на URL https://guild.craft-group.xyz/api/reports/update
</p>

<p>
    Возможные параметры:
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
            id*
        </td>
        <td>
            Идентификатор отчета.
        </td>
    </tr>
    <tr>
        <td>
            created_at
        </td>
        <td>
            Дата (yyyy-mm-dd) создания.
        </td>
    </tr>
    <tr>
        <td>
            today
        </td>
        <td>
            Сделанное сегодня. 
        </td>
    </tr>
    <tr>
        <td>
            difficulties
        </td>
        <td>
            Сложности.
        </td>
    </tr>
 <tr>
        <td>
            tomorrow
        </td>
        <td>
            Планы на завтра.
        </td>
    </tr>
 <tr>
        <td>
            status
        </td>
        <td>
             Номер статуса.
        </td>
    </tr>
</table>
<p>
    Пример запроса:
</p>

`https://guild.craft-group.xyz/api/reports/update?id=18&created_at=2021-09-17&today=0&difficulties=diff&tomorrow=new task&status=1`

## Анкеты
###Список анкет
`https://guild.craft-group.xyz/api/user-questionnaire/questionnaires-list`
<p>
    Для получения списка анкет необходимо отправить <b>GET</b> запрос на URL https://guild.craft-group.xyz/api/user-questionnaire/questionnaires-list
</p>

<p>
    Требуемые параметры запроса:
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
            user_id
        </td>
        <td>
             ID пользователя(int)
        </td>
    </tr>
</table>
<p>
    Пример запроса:
</p>

`https://guild.craft-group.xyz/api/user-questionnaire/questionnaires-list?user_id=1`

<p>
    Возвращает <b>массив</b> объектов записи <b>Назначенная анкета</b>. <br>
    Каждый объектимеет такой вид:
</p>

```json5
{
  "user_id": 1,
  "uuid": "d222f858-60fd-47fb-8731-dc9d5fc384c5",
  "score": 20,
  "status": 1,
  "percent_correct_answers": 0.8
}
```

<p>
    Передаваемые параметры объекта вопроса:
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
            user_id
        </td>
        <td>
             ID пользователя(int)
        </td>
    </tr>
    <tr>
        <td>
            score
        </td>
        <td>
             Полученные балы(int)
        </td>
    </tr>
    <tr>
        <td>
            percent_correct_answers
        </td>
        <td>
             Процент правильных ответов(float)
        </td>
    </tr>
</table>
<p>
    Если пользователь не найден или у пользователя нет активных анкет будет отправлено следующее сообщение:
</p>

```json5
{
  "name": "Not Found",
  "message": "Active questionnaire not found",
  "code": 0,
  "status": 404,
  "type": "yii\\web\\NotFoundHttpException"
}
```
### Вопросы анкеты
`https://guild.craft-group.xyz/api/question/get-questions`
<p>
    Для получения вопросов анкеты необходимо отправить <b>GET</b> запрос на URL https://guild.craft-group.xyz/api/question/get-questions
</p>

<p>
    Требуемые параметры запроса:
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
            uuid
        </td>
        <td>
             UUID анкеты назначеной пользователю
        </td>
    </tr>
</table>
<p>
    Пример запроса:
</p>

`https://guild.craft-group.xyz/api/question/get-questions?uuid=d222f858-60fd-47fb-8731-dc9d5fc384c5`

<p>
    Возвращает <b>массив</b> объектов <b>Вопросов</b>. <br>
    Каждый объект <b>Вопрос</b> имеет такой вид:
</p>

```json5
{
  "id": "4",
  "question_type_id": "2",
  "question_body": "Один ответ1",
  "question_priority": null,
  "next_question": null,
  "time_limit": "00:22:00"
}
```
<p>
    Передаваемые параметры объекта вопроса:
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
             ID вопроса(int)
        </td>
    </tr>
    <tr>
        <td>
            question_type_id
        </td>
        <td>
             ID типа вопроса(int)
        </td>
    </tr>
    <tr>
        <td>
            question_body
        </td>
        <td>
             Вопрос(string)
        </td>
    </tr>
    <tr>
        <td>
            question_priority
        </td>
        <td>
             Приоритет вопроса(int)(не используется)
        </td>
    </tr>
    <tr>
        <td>
            next_question
        </td>
        <td>
             Следующий вопрос(int)(не используется)
        </td>
    </tr>
    <tr>
        <td>
            time_limit
        </td>
        <td>
             Ограничение времени на ответ(time)
        </td>
    </tr>    
</table>
<p>
    Если вопрос не найден или не предпологает передачу ответов будет отправлено следующее сообщение:
</p>

```json5
{
  "name": "Not Found",
  "message": "Questions not found",
  "code": 0,
  "status": 404,
  "type": "yii\\web\\NotFoundHttpException"
}
```
### Ответы на вопрос
`https://guild.craft-group.xyz/api/answer/get-answers`
<p>
     Для получения вариантов ответов на вопрос анкеты нужно сделать <b>GET</b> запрос на URL https://guild.craft-group.xyz/api/answer/get-answers
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
            question_id
        </td>
        <td>
             ID вопроса
        </td>
    </tr>

</table>
<p>
    Пример запроса:
</p>

`https://guild.craft-group.xyz/api/answer/get-answers?question_id=7`

<p>
    Возвращает <b>массив</b> объектов <b>Ответов</b>. <br>
    Каждый объект <b>Ответа</b> имеет такой вид:
</p>

```json5
[
  {
    "id": "12",
    "question_id": "7",
    "answer_body": "Неск вар1 отв1 истина"
  },
]

```
<p>
    Передаваемые параметры объекта вопроса:
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
             ID вопроса(int)
        </td>
    </tr>
    <tr>
        <td>
            question_id
        </td>
        <td>
             ID вопроса(int)
        </td>
    </tr>
    <tr>
        <td>
            answer_body
        </td>
        <td>
             Ответ(string)
        </td>
    </tr>
    
</table>
<p>
    Если ответы не найдены или вопрос не предпологает их наличие(открытый вопрос) будет отправлено следующее сообщение:
</p>

```json5
{
  "name": "Not Found",
  "message": "Answer not found or question inactive",
  "code": 0,
  "status": 404,
  "type": "yii\\web\\NotFoundHttpException"
}
```

### Один ответ пользователя
`https://guild.craft-group.xyz/api/user-response/set-response`
<p>
     Для добавления ответа на вопрос от пользователя необходимо сделать <b>POST</b> запрос на URL https://guild.craft-group.xyz/api/user-response/set-response
</p>

<p>
    Тело запроса содержит:
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
            question_id
        </td>
        <td>
             ID вопроса(int)
        </td>
    </tr>
    <tr>
        <td>
            response_body
        </td>
        <td>
             Ответ пользователя(string 255)
        </td>
    </tr>
    <tr>
        <td>
            uuid
        </td>
        <td>
             UUID анкеты назначенной пользователю(string 36)
        </td>
    </tr>
</table>
<p>
    Пример запроса:
</p>

`https://guild.craft-group.xyz/api/user-response/set-responses?user_id=1&user_questionnaire_id=1&question_id=7&response_body=user response string`

<p>
    Возвращает объект <b>Ответа</b>. <br>
    Объект <b>Ответа</b> имеет такой вид:
</p>

```json5
{
  "user_id": "1",
  "question_id": "7",
  "response_body": "user response string",
  "user_questionnaire_uuid": "d222f858-60fd-47fb-8731-dc9d5fc384c5",
  "created_at": {
    "expression": "NOW()",
    "params": []
  },
  "updated_at": {
    "expression": "NOW()",
    "params": []
  },
  "id": 90
}
```
<p>
    В случаии ошибки в запросе будет отправлено сообщение следующего вида:
</p>

```json5
{
  "name": "Bad Request",
  "message": "{\"question_id\":[\"\В\о\п\р\о\с is invalid.\"]}",
  "code": 0,
  "status": 400,
  "type": "yii\\web\\BadRequestHttpException"
}
```

### Массив ответов пользователя
`https://guild.craft-group.xyz/api/user-response/set-responses`
<p>
     Для добавления массива ответов на вопросы от пользователя необходимо сделать <b>POST</b> запрос на URL https://guild.craft-group.xyz/api/user-response/set-responses
</p>

<p>
    Тело запроса содержит JSON c массивом ответов со следующими параметрами:
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
            question_id
        </td>
        <td>
             ID вопроса(int)
        </td>
    </tr>
    <tr>
        <td>
            response_body
        </td>
        <td>
             Ответ пользователя(string 255)
        </td>
    </tr>
    <tr>
        <td>
            uuid
        </td>
        <td>
             UUID анкеты назначенной пользователю(string 36)
        </td>
    </tr>
</table>
<p>
    Пример тела запроса:
</p>

```json5
{
    "userResponses": [
        {
            "user_id": "1",
            "question_id": "7",
            "response_body": "oooooooooooo111111111",
            "user_questionnaire_uuid": "d222f858-60fd-47fb-8731-dc9d5fc384c5"
        },
        {
            "user_id": "1",
            "question_id": "4",
            "response_body": "oooooooooooo2222222",
            "user_questionnaire_uuid": "d222f858-60fd-47fb-8731-dc9d5fc384c5"
        }
    ]
}
```

<p>
    Возвращает массив объектов <b>ОтветПользователя</b>. <br>
    Пример:
</p>

```json5
[
  {
    "user_id": "1",
    "question_id": "7",
    "response_body": "oooooooooooo111111111",
    "user_questionnaire_uuid": "d222f858-60fd-47fb-8731-dc9d5fc384c5",
    "created_at": {
      "expression": "NOW()",
      "params": []
    },
    "updated_at": {
      "expression": "NOW()",
      "params": []
    },
    "id": 137
  },
  {
    "user_id": "1",
    "question_id": "4",
    "response_body": "oooooooooooo2222222",
    "user_questionnaire_uuid": "d222f858-60fd-47fb-8731-dc9d5fc384c5",
    "created_at": {
      "expression": "NOW()",
      "params": []
    },
    "updated_at": {
      "expression": "NOW()",
      "params": []
    },
    "id": 138
  }
]
```
<p>
    В случаии ошибки в запросе будет отправлено сообщение следующего вида:
</p>

```json5
{
  "name": "Bad Request",
  "message": "{\"question_id\":[\"\В\о\п\р\о\с is invalid.\"]}",
  "code": 0,
  "status": 400,
  "type": "yii\\web\\BadRequestHttpException"
}
```
## Менеджер
### Список менеджеров
`https://guild.craft-group.xyz/api/manager/get-manager-list`
<p>
    Для получения списка менеджеров необходимо отправить <b>GET</b> запрос на URL https://guild.craft-group.xyz/api/manager/get-manager-list
</p>

<p>
    Пример запроса:
</p>

`https://guild.craft-group.xyz/api/manager/get-manager?manager_id=1`

<p>
    Возвращает список объектов <b>Менеджера</b>. <br>
    Пример ответа:
</p>

```json5
[
  {
    "username": "testUser",
    "id": 1,
    "email": "admin@admin.com"
  },
  {
    "username": "workerTest22",
    "id": 2,
    "email": "awdsdse@njbhj.com"
  }
]
```
<p>
    Передаваемые параметры объекта <b>Менеджер</b>:
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
             ID менеджера(int)
        </td>
    </tr>
    <tr>
        <td>
            username
        </td>
        <td>
             Имя пользователя(логин)(varchar(255))
        </td>
    </tr>
    <tr>
        <td>
            email
        </td>
        <td>
             Почтовый адрес(string)
        </td>
    </tr>
</table>
<p>
    Если менеджеры не найдены будет отправлено следующее сообщение:
</p>

```json5
{
  "name": "Not Found",
  "message": "Managers are not assigned",
  "code": 0,
  "status": 404,
  "type": "yii\\web\\NotFoundHttpException"
}
```
### Список работников менеджера
`https://guild.craft-group.xyz/api/manager/get-employees-manager`
<p>
    Для получения списка сотрудников менеджера необходимо отправить <b>GET</b> запрос на URL https://guild.craft-group.xyz/api/manager/get-employees-manager
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
            manager_id
        </td>
        <td>
             ID менеджера
        </td>
    </tr>
</table>

<p>
    Пример запроса:
</p>

`https://guild.craft-group.xyz/api/manager/get-employees-manager?manager_id=3`

<p>
    Возвращает список объектов <b>Пользователь</b>. <br>
    Ответ имеет такой вид:
</p>

```json5
[
  {
    "id": 2,
    "username": "workerTest",
    "email": "testUseweewer@testUser.com",
  },
  {
    "id": 4,
    "username": "worker1",
    "email": "sdfsdvdworker2",
  },
]
```
<p>
    Передаваемые параметры объекта <b>Менеджер</b>:
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
             ID пользователя(работника)(int)
        </td>
    </tr>
    <tr>
        <td>
            username
        </td>
        <td>
             Логин(varchar(255))
        </td>
    </tr>
    <tr>
        <td>
            email
        </td>
        <td>
             Почтовый адрес(string)
        </td>
    </tr>
</table>
<p>
    Если менеджер не найден или у него нет сотрудников будет отправлено следующее сообщение:
</p>

```json5
{
  "name": "Not Found",
  "message": "Managers are not assigned or employees are not assigned to him",
  "code": 0,
  "status": 404,
  "type": "yii\\web\\NotFoundHttpException"
}
```
### Данные менеджера
`https://guild.craft-group.xyz/api/manager/get-manager`
<p>
    Для получения данных менеджера необходимо отправить <b>GET</b> запрос на URL https://guild.craft-group.xyz/api/manager/get-manager
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
            manager_id
        </td>
        <td>
             ID менеджера
        </td>
    </tr>
</table>

<p>
    Пример запроса:
</p>

`https://guild.craft-group.xyz/api/manager/get-manager?manager_id=1`

<p>
    Возвращает объект <b>Менеджера</b>. <br>
    Каждый объект <b>Менеджер</b> имеет такой вид:
</p>

```json5
[
  {
    "id": 1,
    "username": "testUser",
    "email": "admin@admin.com",
  }
]
```
<p>
    Передаваемые параметры объекта <b>Менеджер</b>:
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
             ID как пользователя(int)
        </td>
    </tr>
    <tr>
        <td>
            username
        </td>
        <td>
             Логин(varchar(255))
        </td>
    </tr>
    <tr>
        <td>
            email
        </td>
        <td>
             Электронная почта(string)
        </td>
    </tr>
</table>
<p>
    Если менеджер не найден будет отправлено следующее сообщение:
</p>

```json5
{
  "name": "Not Found",
  "message": "Incorrect manager ID",
  "code": 0,
  "status": 404,
  "type": "yii\\web\\NotFoundHttpException"
}
```

