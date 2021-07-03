# Документация  API

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
            Количество профилей, которое вернет сервер при запроск. 
        </td>
    </tr>
    <tr>
        <td>
            offset
        </td>
        <td>
            Количество записей на которое нужно отчтупить в списке профилей. 
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

`https://guild.craft-group.xyz/api/profile?limit=5&offset=5&skills=1`

### Одна запись
`https://guild.craft-group.xyz/api/profile/{id}`

<p>
    Для того чтобы получить данные одной записи необходимо отправить <b>GET</b> запрос
    на URL https://guild.craft-group.xyz/api/profile/{id} , где <b>id</b> это идинтификатор 
    профиля.
</p>
<p>
    Пример запроса:
</p>

`https://guild.craft-group.xyz/api/profile/6`