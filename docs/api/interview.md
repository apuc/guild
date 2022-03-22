## Интервью 
### Пригласить на собеседование
`https://guild.craft-group.xyz/api/interview-request/create-interview-request`

<p>
    Для того, отправить приглашение профилю на собеседование, необходимо сделать 
    <b>POST</b> запрос на URL https://guild.craft-group.xyz/api/interview-request/create-interview-request
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

