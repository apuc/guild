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
            get-document-list
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

`https://guild.craft-group.xyz/api/reports/index?fromDate=2021-08-01&toDate=2021-08-31&user_id=2&limit=3&offset=2`

### Один отчет
`https://guild.craft-group.xyz/api/reports/{id}`
<p>
    Для получения отчета необходимо отправить <b>GET</b> запрос на URL https://guild.craft-group.xyz/api/reports/{id}
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
            id*
        </td>
        <td>
            ID отчета.
        </td>
    </tr>
</table>
<p>
    Пример запроса на просмотр отчета с ID 13:
</p>

`https://guild.craft-group.xyz/api/reports/13`

### Отчёт по дате
`https://guild.craft-group.xyz/api/reports/find-by-date`
<p>
    Для получения отчета необходимо отправить <b>GET</b> запрос на URL https://guild.craft-group.xyz/api/reports/find-by-date
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
            user_card_id*
        </td>
        <td>
            ID профиля пользователя
        </td>
    </tr>
    <tr>   
        <td>
            date*
        </td>
        <td>
            Дата в формате: Y-m-d
        </td>
    </tr>
</table>
<p>
    Пример запроса :
</p>

`https://guild.craft-group.xyz/api/reports/find-by-date?user_card_id=17&date=2022-02-14`

<p>
    Пример ответа:
</p>

```json5
[
  {
    "id": "1",
    "created_at": "2022-02-14",
    "today": null,
    "difficulties": "",
    "tomorrow": "",
    "status": null,
    "user_card_id": "17",
    "task": [
      {
        "id": "1",
        "report_id": "1",
        "task": "dfghjkl",
        "hours_spent": "2",
        "created_at": "1644842433",
        "status": "1",
        "minutes_spent": "4"
      }
    ]
  },
  {
    "id": "2",
    "created_at": "2022-02-14",
    "today": "dxvxv",
    "difficulties": "сложности возникли",
    "tomorrow": "завтра",
    "status": null,
    "user_card_id": "17",
    "task": [
      {
        "id": "2",
        "report_id": "2",
        "task": "54651513",
        "hours_spent": "4",
        "created_at": "1644842630",
        "status": "1",
        "minutes_spent": "2"
      }
    ]
  }
]
```

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
            tasks*
        </td>
        <td>
            JSON массив содержащий объекты задач 
<pre>
[{ 
    "task" : "Рефакторинг",
    "created_at": 1638260728,
    "status": 1,
    "minutes_spent": 26,
    "hours_spent" : 3
}]
</pre>
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
    "fio": "testUser",
    "id": 1,
    "email": "admin@admin.com"
  },
  {
    "fio": "workerTest22",
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
            fio
        </td>
        <td>
             ФИО пользователя(varchar(255))
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
    "fio": "workerTest",
    "email": "testUseweewer@testUser.com",
  },
  {
    "id": 4,
    "fio": "worker1",
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
             ID пользователя(работника) у менеджера(int)
        </td>
    </tr>
    <tr>
        <td>
            fio
        </td>
        <td>
             ФИО сотрудника(varchar(255))
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
    "id": 5,
    "fio": "Иванов Иван Иванович",
    "email": "testmail@mail.com",
    "photo": "",
    "gender": 0
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
             ID пользователя(работника) у менеджера(int)
        </td>
    </tr>
    <tr>
        <td>
            fio
        </td>
        <td>
             ФИО сотрудника(varchar(255))
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
## Задачи
### Задача
`https://guild.craft-group.xyz/api/task/get-task`
<p>
    Для получения данных задачи необходимо отправить <b>GET</b> запрос на URL https://guild.craft-group.xyz/task/get-task
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
             ID менеджера
        </td>
    </tr>
</table>

<p>
    Пример запроса:
</p>

`https://guild.craft-group.xyz/api/task/get-task?task_id=3`

<p>
    Возвращает объект <b>Задачи</b>. <br>
    Каждый объект <b>Задачи</b> имеет такой вид:
</p>

```json5
{
  "id": 14,
  "project_id": 2,
  "title": "Пробная 2",
  "status": 0,
  "created_at": "2021-12-03 17:22:15",
  "updated_at": "2021-12-03 17:22:15",
  "user_id": null,
  "description": "смасмс",
  "user_id_creator": 1
}
```
<p>
    Передаваемые параметры объекта <b>Задача</b>:
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
             ID задачи(int)
        </td>
    </tr>
    <tr>
        <td>
            project_id
        </td>
        <td>
            ID проекта(int)
        </td>
    </tr>
    <tr>
        <td>
            title
        </td>
        <td>
             Название задачи(string)
        </td>
    </tr>
    <tr>
        <td>
            status
        </td>
        <td>
             Статус(int)
        </td>
    </tr>
    <tr>
        <td>
            created_at
        </td>
        <td>
             Дата создания(string)
        </td>
    </tr>
    <tr>
        <td>
            updated_at
        </td>
        <td>
             Дата изменения(string)
        </td>
    </tr>
    <tr>
        <td>
            user_id
        </td>
        <td>
             ID наблюдателя проекта(int)
        </td>
    </tr>
    <tr>
        <td>
            description
        </td>
        <td>
             Описание задачи(string)
        </td>
    </tr>
    <tr>
        <td>
            user_id_creator
        </td>
        <td>
             ID создателя задачи(int)
        </td>
    </tr>
    

</table>
<p>
    Если задача не найдена будет отправлено следующее сообщение:
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
### Список задач
`https://guild.craft-group.xyz/api/task/get-task-list`
<p>
    Для получения списка данных задач необходимо отправить <b>GET</b> запрос на URL https://guild.craft-group.xyz/task/get-task-list
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

`https://guild.craft-group.xyz/api/task/get-task-list?project_id=2`

<p>
    Возвращает массив объектов <b>Задачи</b>. <br>
    Каждый объект <b>Задачи</b> имеет такой вид:
</p>

```json5
[
  {
    "id": 3,
    "project_id": 2,
    "title": "polkjhgbfv task",
    "status": 1,
    "created_at": "2021-11-24 11:53:11",
    "updated_at": "2021-11-24 11:53:11",
    "user_id_creator": 1,
    "user_id": null,
    "description": "dfvdfvfdvfd"
  },
  {
    "id": 7,
    "project_id": 2,
    "title": "polkjhgbfv taskdfsdfsd",
    "status": 1,
    "created_at": "2021-11-24 14:55:01",
    "updated_at": "2021-11-24 14:55:01",
    "user_id_creator": 1,
    "user_id": null,
    "description": "dfvdfvfdvfdsddsfds"
  }
]
```
<p>
    Передаваемые параметры объекта <b>Задача</b>:
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
             ID задачи(int)
        </td>
    </tr>
    <tr>
        <td>
            project_id
        </td>
        <td>
            ID проекта(int)
        </td>
    </tr>
    <tr>
        <td>
            title
        </td>
        <td>
             Название задачи(string)
        </td>
    </tr>
    <tr>
        <td>
            status
        </td>
        <td>
             Статус(int)
        </td>
    </tr>
    <tr>
        <td>
            created_at
        </td>
        <td>
             Дата создания(string)
        </td>
    </tr>
    <tr>
        <td>
            updated_at
        </td>
        <td>
             Дата изменения(string)
        </td>
    </tr>
    <tr>
        <td>
            user_id_creator
        </td>
        <td>
             ID создателя задачи(int)
        </td>
    </tr>
    <tr>
        <td>
            user_id
        </td>
        <td>
             ID наблюдателя(int)
        </td>
    </tr>
    <tr>
        <td>
            description
        </td>
        <td>
             Описание задачи(string)
        </td>
    </tr>


</table>
<p>
    Если задачи не найдена будет отправлено следующее сообщение:
</p>

```json5
{
  "name": "Not Found",
  "message": "The project does not exist or there are no tasks for it",
  "code": 0,
  "status": 404,
  "type": "yii\\web\\NotFoundHttpException"
}
```
### Создать задачу
`https://guild.craft-group.xyz/api/task/create-task`
<p>
    Для создания задачи необходимо отправить <b>POST</b> запрос на URL https://guild.craft-group.xyz/task/create-task
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
            ID проекта(int)
        </td>
    </tr>
    <tr>
        <td>
            title
        </td>
        <td>
             Название задачи(string)
        </td>
    </tr>
    <tr>
        <td>
            status
        </td>
        <td>
             Статус(int)
        </td>
    </tr>
    <tr>
        <td>
            user_id_creator
        </td>
        <td>
             ID сотрудника, создатель задачи(int)
        </td>
    </tr>
    <tr>
        <td>
            description
        </td>
        <td>
             Описание задачи(string)
        </td>
    </tr>
   
</table>

<p>
    Пример запроса:
</p>

`http://guild.loc/api/task/create-task`

<p>
    Возвращает объект <b>Задачи</b>. <br>
    Каждый объект <b>Задачи</b> имеет такой вид:
</p>

```json5
{
  "project_id": "2",
  "title": "polkjhgbfv taskdfsdfsd",
  "status": "1",
  "user_id_creator": "1",
  "description": "dfvdfvfdvfdsddsfds",
  "created_at": {
    "expression": "NOW()",
    "params": []
  },
  "updated_at": {
    "expression": "NOW()",
    "params": []
  },
  "id": 12
}
```

<p>
    Если требуемый параметр задачи не будет получен, будет отправлено сообщение следующего вида:
</p>

```json5
{
  "name": "Bad Request",
  "message": "{\"user_id_creator\":[\"\С\о\з\д\а\т\е\л\ь cannot be blank.\"]}",
  "code": 0,
  "status": 400,
  "type": "yii\\web\\BadRequestHttpException"
}
```
### Изменить задачу
`https://guild.craft-group.xyz/api/task/update`
<p>
    Для изменения задачи необходимо отправить <b>POST</b> запрос на URL https://guild.craft-group.xyz/task/update
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

`https://guild.craft-group.xyz/api/task/update`

<p>
    Возвращает объект <b>Задачи</b>. <br>
    Каждый объект <b>Задачи</b> имеет такой вид:
</p>

```json5
{
  "id": 11,
  "project_id": 2,
  "title": "432423",
  "status": 1,
  "created_at": "2021-11-24 14:40:25",
  "updated_at": "2021-11-25 11:44:30",
  "user_id_creator": 5,
  "user_id": 2,
  "description": "888"
}
```
<p>
    Параметры объекта <b>Задача</b>:
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
             ID задачи(int)
        </td>
    </tr>
    <tr>
        <td>
            project_id
        </td>
        <td>
            ID проекта(int)
        </td>
    </tr>
    <tr>
        <td>
            title
        </td>
        <td>
             Название задачи(string)
        </td>
    </tr>
    <tr>
        <td>
            status
        </td>
        <td>
             Статус(int)
        </td>
    </tr>
    <tr>
        <td>
            created_at
        </td>
        <td>
             Дата создания(string)
        </td>
    </tr>
    <tr>
        <td>
            updated_at
        </td>
        <td>
             Дата изменения(string)
        </td>
    </tr>
    <tr>
        <td>
            user_id_creator
        </td>
        <td>
             ID сотрудника, создатель задачи(int)
        </td>
    </tr>
    <tr>
        <td>
            user_id
        </td>
        <td>
             ID сотрудника(int)
        </td>
    </tr>
    <tr>
        <td>
            description
        </td>
        <td>
             Описание задачи(string)
        </td>
    </tr>


</table>
<p>
    Если задача не найдена будет отправлено следующее сообщение:
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
`https://guild.craft-group.xyz/api/task-user/get-task-users`
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