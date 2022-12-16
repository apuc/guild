## Отчеты
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
            api/reports
        </td>
        <td>
            Список отчётов
        </td>
    </tr>
    <tr>
        <td>
            api/reports/{id}
        </td>
        <td>
            Один отчёт 
        </td>
    </tr>
    <tr>
        <td>
            find-by-date
        </td>
        <td>
            Отчёт по дате
        </td>
    </tr>
    <tr>
        <td>
            create
        </td>
        <td>
            Создать отчёт
        </td>
    </tr>
    <tr>
        <td>
            delete
        </td>
        <td>
            Удалить отчёт
        </td>
    </tr>
    <tr>
        <td>
            update
        </td>
        <td>
            Изменить отчёт
        </td>
    </tr>
</table>

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
    Для создания отчёта, необходимо сделать 
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
