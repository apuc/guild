# Профиль
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
            profile
        </td>
        <td>
            Возвращает список профилей 
        </td>
    </tr>
    <tr>
        <td>
            profile/{id}
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
    <tr>
        <td>
            profile/get-main-data
        </td>
        <td>
            Получить получить основные данные профиля 
        </td>
    </tr>
    <tr>
        <td>
            profile/portfolio-projects
        </td>
        <td>
            Массив проектов в портфолио(для страницы мой код) 
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
</p>

```json5
{
    "id": 1,
    "fio": "йцукенг дльпдрьап",
    "photo": "",
    "gender": 0,
    "dob": null,
    "status": 3,
    "created_at": null,
    "updated_at": "2022-12-23 01:01:34",
    "salary": null,
    "position_id": 1,
    "deleted_at": null,
    "id_user": 1,
    "city": "",
    "vc_text": "<h3><strong>Itguild</strong></h3><h4>Стек – Yii2, MySQL, Adminlte, PHPWord, Widgets – Kartik, Yii2-mpdf</h4><p>Разработка модулей:</p><p>Тестирования кандидатов. Обеспечивает: подготовку тестовых анкет с различными типами вопросов(открытый вопрос; несколько вариантов ответа; истина — ложь и т. д.); проведения тестирования; автоматическое оценивание результата.</p><p>Управление сотрудниками. Обеспечивает: менеджмент сотрудников; контроль распределения и выполнения задч.</p><p>Документы. Обеспечивает: создание шаблонов документов и генирацию файлов на их основе в формате DOCX и PDF.</p><p>Доработка иеющихся функциональных модулей, тестирование, разработка апи, ведение документации проекта.</p><p>&nbsp;</p><h3><strong>keepminingstrong</strong></h3><h4>Стек – Yii2, swiftmailer, HTML, CSS</h4><p>Многоязычного сайта-визитка, с возможностью обратной связи для пользователей по средствам электронных сообщений.</p><p>&nbsp;</p><h3><strong>PeopleControl</strong></h3>",
    "level": 1,
    "vc_text_short": "<br><br><br><br><h3>dfghjk uuu@mail.com <br/<br/<br/<br/Женщина dfghj Middlejjkbd</h3><p>&nbsp;br</p><p>&nbsp;<i><br><strong> dcdvcds</strong></br></i></p><h4>kdsmc</h4><p>kjnd</p><p>&nbsp;</p><ul><li>djnj &nbsp;&nbsp;</li></ul><ol><li>dknckn &nbsp;</li></ol>",
    "years_of_exp": null,
    "specification": "",
    "test_task_getting_date": null,
    "test_task_complete_date": null,
    "resume_text": "<h3><strong>Itguild</strong></h3>\n        <h4>Стек – Yii2, MySQL, Adminlte, PHPWord, Widgets – Kartik, Yii2-mpdf</h4>\n        <p>Разработка модулей:</p>\n        <p>Тестирования кандидатов. Обеспечивает: подготовку тестовых анкет с различными типами вопросов(открытый вопрос; несколько вариантов ответа; истина — ложь и т. д.); проведения тестирования; автоматическое оценивание результата.</p>\n        <p>Управление сотрудниками. Обеспечивает: менеджмент сотрудников; контроль распределения и выполнения задч.</p>\n        <p>Документы. Обеспечивает: создание шаблонов документов и генирацию файлов на их основе в формате DOCX и PDF.</p>\n        <p>Доработка иеющихся функциональных модулей, тестирование, разработка апи, ведение документации проекта.</p>\n        <p>&nbsp;</p>\n        <h3><strong>keepminingstrong</strong></h3>\n        <h4>Стек – Yii2, swiftmailer, HTML, CSS</h4>\n        <p>Многоязычного сайта-визитка, с возможностью обратной связи для пользователей по средствам электронных сообщений.</p>\n        <p>&nbsp;</p>\n        <h3><strong>PeopleControl</strong></h3>",
    "resume_template_id": 4,
    "resume_tariff": null,
    "at_project": null,
    "skillValues": [
        {
            "id": 1,
            "card_id": 1,
            "skill_id": 1,
            "skill": {
                "id": 1,
                "name": "JS",
                "category_id": 1
            }
        }
    ],
    "achievements": []
}
```

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

## Основные данные пользователя

`https://guild.craft-group.xyz/api/profile/get-main-data?user_id=1`
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
            user_id
        </td>
        <td>
            Id профиля пользователя
        </td>
    </tr>
</table>

<p>
    Возвращает объект <b>Пользователь</b>. <br>
    Каждый объект <b>Пользователь</b> имеет такой вид:
</p>

```json5
{
  "fio": "Тест менеджер для апи запроса",
  "photo": null,
  "gender": 1,
  "level": 2,
  "years_of_exp": null,
  "specification": null,
  "position_name": "Должность 1"
}
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
            fio
        </td>
        <td>
            ФИО
        </td>
    </tr>
    <tr>
        <td>
            photo
        </td>
        <td>
            Ссылка на фото
        </td>
    </tr>
    <tr>
        <td>
            gender
        </td>
        <td>
            Пол
        </td>
    </tr>
    <tr>
        <td>
            level
        </td>
        <td>
            Уровень
        </td>
    </tr>
    <tr>
        <td>
            years_of_exp
        </td>
        <td>
            Лет опыта
        </td>
    </tr>
    <tr>
        <td>
            position_name
        </td>
        <td>
            Должность
        </td>
    </tr>
</table>

## Массив проектов в портфолио(для страницы мой код)

`https://guild.craft-group.xyz/api/profile/profile/portfolio-projects?card_id=9`
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
            card_id
        </td>
        <td>
            Id профиля пользователя
        </td>
    </tr>
</table>

<p>
    Возвращает массив объектов <b>Проект в портфолио</b>. <br>
    Ответ имеет следующий вид:
</p>

```json5
[
  {
    "id": 11,
    "title": "yguyyyyy",
    "description": "пппппппппппп",
    "main_stack": "JS",
    "additional_stack": "jnvbklfbmklfdv",
    "link": "11111"
  },
  {
    "id": 12,
    "title": "smclksdmk",
    "description": "ссссссссссс",
    "main_stack": "JS",
    "additional_stack": "ksdlkcmskl",
    "link": "kwemfdkflefmkl"
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
            id
        </td>
        <td>
            Id
        </td>
    </tr>
    <tr>
        <td>
            title
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
            описание
        </td>
    </tr>
    <tr>
        <td>
            main_stack
        </td>
        <td>
            основной язык проекта
        </td>
    </tr>
    <tr>
        <td>
            additional_stack
        </td>
        <td>
            используемые технологии
        </td>
    </tr>
    <tr>
        <td>
            link
        </td>
        <td>
            ссылка на репозиторий
        </td>
    </tr>
</table>

