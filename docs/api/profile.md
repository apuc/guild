## Профиль
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
            api/profile
        </td>
        <td>
            Возвращает список профилей 
        </td>
    </tr>
    <tr>
        <td>
            api/profile/{id}
        </td>
        <td>
            Возвращает один профиль 
        </td>
    </tr>
    <tr>
        <td>
            profile/profile-with-report-permission
        </td>
        <td>
            Получить профиль с флагом прав на просмотр отчётов этого пользователя 
        </td>
    </tr>
</table>

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

### Получить профиль с флагом прав на просмотр отчётов этого пользователя
`https://guild.craft-group.xyz/api/profile/profile-with-report-permission`

<p>
    Для получения профиля пользователя с флагом прав на просмотр отчётов этого пользователя, необходимо сделать 
    <b>GET</b> запрос на URL https://guild.craft-group.xyz/api/profile/add-to-interview
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
            id
        </td>
        <td>
            ID профиля пользователя
        </td>
    </tr>
</table>

