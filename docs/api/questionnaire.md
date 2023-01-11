## Анкеты

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
            user-questionnaire/questionnaires-list
        </td>
        <td>
            Cписок анкет 
        </td>
    </tr>
    <tr>
        <td>
            user-questionnaire/questionnaire-completed
        </td>
        <td>
            Завершение прохождение анкеты, проверка ответов 
        </td>
    </tr>
    <tr>
        <td>
            question/get-questions
        </td>
        <td>
            Вопросы анкеты 
        </td>
    </tr>
    <tr>
        <td>
            answer/get-answers
        </td>
        <td>
            Список возможных ответов на вопрос 
        </td>
    </tr>
    <tr>
        <td>
            user-response/set-response
        </td>
        <td>
            Сохранить ответ пользователя
        </td>
    </tr>
    <tr>
        <td>
            user-response/set-responses
        </td>
        <td>
            Сохранить массив ответов пользователя
        </td>
    </tr>
</table>

### Список анкет

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
            user_id
        </td>
        <td>
             ID пользователя(int), без этого параметра будет возвращён список анкет для текущего пользователя
        </td>
    </tr>
    <tr>
        <td>
            expand(вывод дополнительных полей)
        </td>
        <td>
            принимаемые значения: question_number(количество вопросов),points_number(количество балов в анкете)
        </td>
    </tr>
</table>
<p>
    Пример запроса:
</p>

`GET https://guild.craft-group.xyz/api/user-questionnaire/questionnaires-list?user_id=10&expand=question_number,points_number`

<p>
    Возвращает <b>массив</b> объектов <b>Назначенная анкета</b>. <br>
</p>

```json5
[
  {
    "questionnaire_title": "всыв",
    "uuid": "051900d9-be83-4b8a-8536-7cf3e2754263",
    "created_at": "2023-01-10 19:58:53",
    "score": null,
    "status": 1,
    "percent_correct_answers": null,
    "testing_date": null,
    "question_number": 3,
    "points_number": "116"
  },
  {
    "questionnaire_title": "всыв",
    "uuid": "4a1eb766-6076-4b27-a82a-766bb4269cb8",
    "created_at": "2023-01-10 20:12:27",
    "score": null,
    "status": 1,
    "percent_correct_answers": null,
    "testing_date": null,
    "question_number": 3,
    "points_number": "116"
  }
]
```

<p>
    Возвращаемые параметры:
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
            questionnaire_title
        </td>
        <td>
            Название анкеты
        </td>
    </tr>
    <tr>
        <td>
            uuid
        </td>
        <td>
             uuid анкеты пользователя
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
            status
        </td>
        <td>
             Статус: 0 - не активен; 1 - активен; 2 - завершён; 3 - на проверке;
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
    <tr>
        <td>
            testing_date
        </td>
        <td>
            Дата тестирования
        </td>
    </tr>
    <tr>
        <td>
            question_number
        </td>
        <td>
            количество вопросов
        </td>
    </tr>
    <tr>
        <td>
            points_number
        </td>
        <td>
            количество балов за все вопросы в анкете
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

### Проверить ответы в анкете
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
    <tr>
        <td>
            expand(вывод дополнительных полей)
        </td>
        <td>
            принимаемые значения: question_number(количество вопросов),points_number(количество балов в анкете)
        </td>
    </tr>
</table>
<p>
    Пример запроса:
</p>

`GET https://guild.craft-group.xyz/api/user-questionnaire/questionnaire-completed?user_questionnaire_uuid=d222f858-60fd-47fb-8731-dc9d5fc384c5`

<p>
    Возвращает <b>объект Анкета</b> с заполнеными полями <b>баллы</b> и <b>процент правильных ответов</b>. <br>
</p>

```json5
{
  "questionnaire_title": "всыв",
  "uuid": "f8e15715-18e4-4369-9c8c-3968a0c54129",
  "created_at": "2022-12-15 20:43:41",
  "score": 0,
  "status": 2,
  "percent_correct_answers": 0,
  "testing_date": "2023:01:10 18:33:26",
  "question_number": 3,
  "points_number": "116"
}
```

### Вопросы анкеты

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
[
  {
    "id": 1,
    "question_type_id": 1,
    "question_body": "фывф",
    "question_priority": 1,
    "next_question": 2,
    "time_limit": null
  },
  {
    "id": 2,
    "question_type_id": 1,
    "question_body": "ьбьььььь",
    "question_priority": null,
    "next_question": null,
    "time_limit": null
  },
  {
    "id": 3,
    "question_type_id": 1,
    "question_body": "ждьждьлд",
    "question_priority": 1,
    "next_question": 2,
    "time_limit": null
  }
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
            question_type_id
        </td>
        <td>
             ID типа вопроса(int): 1 - открытый вопрос; 2 - один правильный ответ; 3 - 	несколько вариантов ответа;
            4 - истина или ложь;
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

`GET https://guild.craft-group.xyz/api/answer/get-answers?question_id=7`

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
            user_id
        </td>
        <td>
             ID пользователя
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
            response_body
        </td>
        <td>
             Ответ пользователя(string 255)
        </td>
    </tr>
    <tr>
        <td>
            user_questionnaire_uuid
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
  "user_id": "1",
  "question_id": "7",
  "response_body": "oooooooooooo111111111",
  "user_questionnaire_uuid": "d222f858-60fd-47fb-8731-dc9d5fc384c5"
}
```

`https://guild.craft-group.xyz/api/user-response/set-response`

<p>
    Возвращает объект <b>Ответа</b>. <br>
    Объект <b>Ответа</b> имеет такой вид:
</p>

```json5
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
  "id": 191,
  "answer_flag": 0
}
```

<p>
    Ответ содержит:
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
             ID пользователя
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
            response_body
        </td>
        <td>
             Ответ пользователя(string 255)
        </td>
    </tr>
    <tr>
        <td>
            user_questionnaire_uuid
        </td>
        <td>
             UUID анкеты назначенной пользователю(string 36)
        </td>
    </tr>
    <tr>
        <td>
            answer_flag
        </td>
        <td>
            Флаг ответа(1 - верно, 0 - ложно). Если отправлен ответ на открытый вопрос, флаг ответа не будет возвращаться до момента проверки в админ панели.
        </td>
    </tr>
</table>

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
            user_id
        </td>
        <td>
             ID пользователя
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
            response_body
        </td>
        <td>
             Ответ пользователя(string 255)
        </td>
    </tr>
    <tr>
        <td>
            user_questionnaire_uuid
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
    "id": 192,
    "answer_flag": 0
  },
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
    "id": 193,
    "answer_flag": 0
  }
]
```

<p>
    Ответ содержит:
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
             ID пользователя
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
            response_body
        </td>
        <td>
             Ответ пользователя(string 255)
        </td>
    </tr>
    <tr>
        <td>
            user_questionnaire_uuid
        </td>
        <td>
             UUID анкеты назначенной пользователю(string 36)
        </td>
    </tr>
    <tr>
        <td>
            answer_flag
        </td>
        <td>
            Флаг ответа(1 - верно, 0 - ложно)
        </td>
    </tr>
</table>
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
