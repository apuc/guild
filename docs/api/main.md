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

