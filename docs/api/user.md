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
            login
        </td>
        <td>
            Аторизация пользователя 
        </td>
    </tr>
</table>

## Аторизация пользователя

POST: `https://guild.craft-group.xyz/api/user/login`

<table>
    <tr>
        <th>
            Параметры <br> 
            * - обязательные
        </th>
        <th>
            Значение
        </th>
    </tr>
    <tr>
        <td>
            username*
        </td>
        <td>
            Логин пользователя(адресс электронной почты пользователя)
        </td>
    </tr>
    <tr>
        <td>
            password*
        </td>
        <td>
            Пароль пользователя
        </td>
    </tr>
</table>

<p>
    Пример возвращаемых данных:
</p>

```json5
{
  "access_token": "RKZIA06yVbIkcbzdD7szVE5nnbRuxISV",
  "access_token_expired_at": "2022-12-30",
  "user_id": 1,
  "card_id": 1
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
            access_token
        </td>
        <td>
            токен доступа
        </td>
    </tr>
    <tr>
        <td>
            access_token_expired_at
        </td>
        <td>
            дата истечения срока действия токена доступа
        </td>
    </tr>
    <tr>
        <td>
            id
        </td>
        <td>
            id пользователя
        </td>
    </tr>
    <tr>
        <td>
            card_id
        </td>
        <td>
            id профиля пользователя (при отсутствии профиля будет возвращено NULL)
        </td>
    </tr>
</table>
