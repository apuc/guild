# Пользователь

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
            get-user-card
        </td>
        <td>
            Данные пользователя 
        </td>
    </tr>
</table>

## Данные пользователя

`https://guild.craft-group.xyz/api/user-card/get-user-card?user_id=1`
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
            user_id
        </td>
        <td>
            Id пользователя
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
