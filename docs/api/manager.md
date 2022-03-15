# Менеджеры

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
            get-manager-list
        </td>
        <td>
            Возвращает список менеджеров 
        </td>
    </tr>
    <tr>
        <td>
            get-manager-employees-list
        </td>
        <td>
            Возвращает список сотрудников менеджера 
        </td>
    </tr>
    <tr>
        <td>
            get-manager
        </td>
        <td>
            Возвращает менеджера 
        </td>
    </tr>
</table>

## Список менеджеров

`https://guild.craft-group.xyz/api/manager/get-manager-list`

<p>
    Возвращает <b>массив</b> объектов <b>Менеджер</b>. <br>
    Каждый объект <b>Менеджер</b> имеет такой вид:
</p>

```json5
[
  {
    "fio": "Иванов Иван Иванович",
    "id": 5,
    "email": "testmail@mail.com"
  },
 '...'
]
```

## Получить менеджера

`https://guild.craft-group.xyz/api/manager/get-manager?manager_id=5`
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
            manager_id
        </td>
        <td>
            Id менеджера
        </td>
    </tr>
</table>

<p>
    Возвращает объект <b>Менеджер</b>. <br>
    Каждый объект <b>Менеджер</b> имеет такой вид:
</p>

```json5
{
  "id": "5",
  "fio": "Иванов Иван Иванович",
  "email": "testmail@mail.com",
  "photo": "",
  "gender": "0",
  "manager": {
    "id": "3"
  }
}
```

## Получить сотрудников менеджера

`https://guild.craft-group.xyz/api/manager/get-manager-employees-list?manager_id=5`
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
            manager_id
        </td>
        <td>
            Id менеджера
        </td>
    </tr>
</table>

<p>
    Возвращает массив объектов <b>Профиль</b> сотрудников, что закреплены за менеджером. <br>
    Каждый объект <b>Профиль</b> имеет такой вид:
</p>

```json5
[
  {
    "id": 2,
    "fio": "тусыавт2",
    "email": "jnjhbdhvf@mail.com"
  },
  '...'
]
```
