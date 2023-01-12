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
            profile?{card_id}
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
            profile/portfolio-projects
        </td>
        <td>
            Массив проектов в портфолио(для страницы мой код) 
        </td>
    </tr>
</table>

### Список профилей

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
    Возвращает <b>массив</b> объектов <b>Профилей</b> который имеет такой вид:
</p>

```json5
[
  {
    "fio": "Admin",
    "photo": "",
    "gender": 0,
    "status": 4,
    "position_id": 1,
    "city": "",
    "vc_text": "<h3><strong>Itguild</strong></h3><h4>Стек – Yii2, MySQL, Adminlte, PHPWord, Widgets – Kartik, Yii2-mpdf</h4><p>Разработка модулей:</p><p>Тестирования кандидатов. Обеспечивает: подготовку тестовых анкет с различными типами вопросов(открытый вопрос; несколько вариантов ответа; истина — ложь и т. д.); проведения тестирования; автоматическое оценивание результата.</p><p>Управление сотрудниками. Обеспечивает: менеджмент сотрудников; контроль распределения и выполнения задч.</p><p>Документы. Обеспечивает: создание шаблонов документов и генирацию файлов на их основе в формате DOCX и PDF.</p><p>Доработка иеющихся функциональных модулей, тестирование, разработка апи, ведение документации проекта.</p><p>&nbsp;</p><h3><strong>keepminingstrong</strong></h3><h4>Стек – Yii2, swiftmailer, HTML, CSS</h4><p>Многоязычного сайта-визитка, с возможностью обратной связи для пользователей по средствам электронных сообщений.</p><p>&nbsp;</p><h3><strong>PeopleControl</strong></h3>",
    "level": 1,
    "vc_text_short": "<br><br><br><br><h3>dfghjk uuu@mail.com <br/<br/<br/<br/Женщина dfghj Middlejjkbd</h3><p>&nbsp;br</p><p>&nbsp;<i><br><strong> dcdvcds</strong></br></i></p><h4>kdsmc</h4><p>kjnd</p><p>&nbsp;</p><ul><li>djnj &nbsp;&nbsp;</li></ul><ol><li>dknckn &nbsp;</li></ol>",
    "years_of_exp": null,
    "specification": "",
    "resume_text": "<h3><strong>Itguild</strong></h3>\n        <h4>Стек – Yii2, MySQL, Adminlte, PHPWord, Widgets – Kartik, Yii2-mpdf</h4>\n        <p>Разработка модулей:</p>\n        <p>Тестирования кандидатов. Обеспечивает: подготовку тестовых анкет с различными типами вопросов(открытый вопрос; несколько вариантов ответа; истина — ложь и т. д.); проведения тестирования; автоматическое оценивание результата.</p>\n        <p>Управление сотрудниками. Обеспечивает: менеджмент сотрудников; контроль распределения и выполнения задч.</p>\n        <p>Документы. Обеспечивает: создание шаблонов документов и генирацию файлов на их основе в формате DOCX и PDF.</p>\n        <p>Доработка иеющихся функциональных модулей, тестирование, разработка апи, ведение документации проекта.</p>\n        <p>&nbsp;</p>\n        <h3><strong>keepminingstrong</strong></h3>\n        <h4>Стек – Yii2, swiftmailer, HTML, CSS</h4>\n        <p>Многоязычного сайта-визитка, с возможностью обратной связи для пользователей по средствам электронных сообщений.</p>\n        <p>&nbsp;</p>\n        <h3><strong>PeopleControl</strong></h3>",
    "at_project": null,
    "skillValues": [
      {
        "id": 1,
        "name": "JS",
        "category_id": 1
      },
      {
        "id": 2,
        "name": "jhbjhbh",
        "category_id": 1
      }
    ],
    "achievements": [
      {
        "id": 1,
        "slug": "sefs",
        "title": "achive",
        "img": "/media/upload/guild.png",
        "description": "wedfse",
        "status": 1
      }
    ]
  },
  {
    "fio": "vcvvvvvvc",
    "photo": "",
    "gender": 0,
    "status": 4,
    "position_id": 1,
    "city": "",
    "vc_text": "",
    "level": 1,
    "vc_text_short": "",
    "years_of_exp": null,
    "specification": "",
    "resume_text": null,
    "at_project": null,
    "skillValues": [],
    "achievements": [
      {
        "id": 1,
        "slug": "sefs",
        "title": "ee",
        "img": "/media/upload/guild.png",
        "description": "wedfse",
        "status": 1
      }
    ]
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

### Один профиль
`https://guild.craft-group.xyz/api/profile?{card_id}`

<p>
    Для получения данных одного профиля необходимо отправить <b>GET</b> запрос
    на URL https://guild.craft-group.xyz/api/profile с параметром <b>card_id</b> , где <b>card_id</b> это идентификатор 
    профиля
</p>
<p> 
    Пример запроса:
</p>

`https://guild.craft-group.xyz/api/profile?card_id=1`

<p>
    Возвращает объект <b>Профиля</b>. <br>
</p>

```json5
{
  "fio": "Admin",
  "photo": "",
  "gender": 0,
  "status": 4,
  "position_id": 1,
  "city": "",
  "vc_text": "<h3><strong>Itguild</strong></h3><h4>Стек – Yii2, MySQL, Adminlte, PHPWord, Widgets – Kartik, Yii2-mpdf</h4><p>Разработка модулей:</p><p>Тестирования кандидатов. Обеспечивает: подготовку тестовых анкет с различными типами вопросов(открытый вопрос; несколько вариантов ответа; истина — ложь и т. д.); проведения тестирования; автоматическое оценивание результата.</p><p>Управление сотрудниками. Обеспечивает: менеджмент сотрудников; контроль распределения и выполнения задч.</p><p>Документы. Обеспечивает: создание шаблонов документов и генирацию файлов на их основе в формате DOCX и PDF.</p><p>Доработка иеющихся функциональных модулей, тестирование, разработка апи, ведение документации проекта.</p><p>&nbsp;</p><h3><strong>keepminingstrong</strong></h3><h4>Стек – Yii2, swiftmailer, HTML, CSS</h4><p>Многоязычного сайта-визитка, с возможностью обратной связи для пользователей по средствам электронных сообщений.</p><p>&nbsp;</p><h3><strong>PeopleControl</strong></h3>",
  "level": 1,
  "vc_text_short": "<br><br><br><br><h3>dfghjk uuu@mail.com <br/<br/<br/<br/Женщина dfghj Middlejjkbd</h3><p>&nbsp;br</p><p>&nbsp;<i><br><strong> dcdvcds</strong></br></i></p><h4>kdsmc</h4><p>kjnd</p><p>&nbsp;</p><ul><li>djnj &nbsp;&nbsp;</li></ul><ol><li>dknckn &nbsp;</li></ol>",
  "years_of_exp": null,
  "specification": "",
  "resume_text": "<h3><strong>Itguild</strong></h3>\n        <h4>Стек – Yii2, MySQL, Adminlte, PHPWord, Widgets – Kartik, Yii2-mpdf</h4>\n        <p>Разработка модулей:</p>\n        <p>Тестирования кандидатов. Обеспечивает: подготовку тестовых анкет с различными типами вопросов(открытый вопрос; несколько вариантов ответа; истина — ложь и т. д.); проведения тестирования; автоматическое оценивание результата.</p>\n        <p>Управление сотрудниками. Обеспечивает: менеджмент сотрудников; контроль распределения и выполнения задч.</p>\n        <p>Документы. Обеспечивает: создание шаблонов документов и генирацию файлов на их основе в формате DOCX и PDF.</p>\n        <p>Доработка иеющихся функциональных модулей, тестирование, разработка апи, ведение документации проекта.</p>\n        <p>&nbsp;</p>\n        <h3><strong>keepminingstrong</strong></h3>\n        <h4>Стек – Yii2, swiftmailer, HTML, CSS</h4>\n        <p>Многоязычного сайта-визитка, с возможностью обратной связи для пользователей по средствам электронных сообщений.</p>\n        <p>&nbsp;</p>\n        <h3><strong>PeopleControl</strong></h3>",
  "at_project": null,
  "skillValues": [
    {
      "id": 1,
      "name": "JS",
      "category_id": 1
    },
    {
      "id": 2,
      "name": "jhbjhbh",
      "category_id": 1
    }
  ],
  "achievements": [
    {
      "id": 1,
      "slug": "sefs",
      "title": "ee",
      "img": "/media/upload/guild.png",
      "description": "wedfse",
      "status": 1
    }
  ]
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
            card_id
        </td>
        <td>
            ID профиля пользователя
        </td>
    </tr>
</table>

<p>
    Возвращает объект <b>Профиля</b>. <br>
</p>

```json5
{
  "fio": "dfghjk",
  "photo": "/media/upload/guild.png",
  "gender": 1,
  "status": 4,
  "position_id": 1,
  "city": "",
  "vc_text": "...",
  "level": 2,
  "vc_text_short": "...",
  "years_of_exp": null,
  "specification": "",
  "resume_text": "...",
  "at_project": null,
  "report_permission": "0" // 0 - запрещено, 1 - разрешино
}
```

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

