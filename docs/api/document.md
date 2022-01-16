# Документы

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
            get-document-list
        </td>
        <td>
            Возвращает список документов 
        </td>
    </tr>
    <tr>
        <td>
            get-document
        </td>
        <td>
            Возвращает документ 
        </td>
    </tr>
    <tr>
        <td>
            create-document
        </td>
        <td>
            Создание документа 
        </td>
    </tr>
</table>

## Список документов

`https://guild.craft-group.xyz/api/document/get-document-list?document_type=1`
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
            document_type
        </td>
        <td>
            Тип документа. Возможные значения: 1 - Акт; 2 - Договор
        </td>
    </tr>
</table>
<p>
    Без передачи параметра возвращает массив объектов <b>Документ</b> . С параметром <b>document_type</b>, 
метод возвращает объекты <b>Документ</b> определённого типа(<b>1 - Акт; 2 - Договор</b>).
 При отсутствии документов возвращает ошибку: "Not Found".
</p>

<p>
    Возвращает <b>массив</b> объектов <b>Документ</b>. <br>
    Каждый объект <b>Документ</b> имеет такой вид:
</p>

```json5
[
  {
    "id": "88",
    "title": "Act2",
    "created_at": "2022-01-12 16:39:41",
    "updated_at": "2022-01-12 16:39:41",
    "template_id": "94",
    "manager_id": "5",
    "template": {
      "id": "94",
      "title": "Акт",
      "created_at": "2022-01-11 11:47:11",
      "updated_at": null,
      "template_file_name": null,
      "document_type": "2"
    }
  },
 '...'
]
```
<p>
    Пример ошибки:
</p>

```json5
{
  "name": "Not Found",
  "message": "Documents not found",
  "code": 0,
  "status": 404,
  "type": "yii\\web\\NotFoundHttpException"
}
```

## Получить документ

`https://guild.craft-group.xyz/api/document/get-document?document_id=88`
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
            document_id
        </td>
        <td>
            Id документа
        </td>
    </tr>
</table>

<p>
    Возвращает объект <b>Документ</b>. <br>
    Каждый объект <b>Документ</b> имеет такой вид:
</p>

```json5
[
  {
    "id": "88",
    "title": "Act2",
    "created_at": "2022-01-12 16:39:41",
    "updated_at": "2022-01-12 16:39:41",
    "template_id": "94",
    "manager_id": "5",
    "documentFieldValues": [
      {
        "id": "105",
        "field_id": "43",
        "document_id": "88",
        "value": "№ документа111",
        "field": {
          "id": "43",
          "title": "№ документа",
          "field_template": "№ dokumenta"
        }
      },
      {
        "id": "106",
        "field_id": "44",
        "document_id": "88",
        "value": "от111",
        "field": {
          "id": "44",
          "title": "от",
          "field_template": "ot"
        }
      },
      {
        "id": "107",
        "field_id": "45",
        "document_id": "88",
        "value": "Сумма с НДС111",
        "field": {
          "id": "45",
          "title": "Сумма с НДС",
          "field_template": "Summa s NDS"
        }
      },
      {
        "id": "108",
        "field_id": "46",
        "document_id": "88",
        "value": "НДС111",
        "field": {
          "id": "46",
          "title": "НДС",
          "field_template": "NDS"
        }
      },
      {
        "id": "109",
        "field_id": "47",
        "document_id": "88",
        "value": "Основание111",
        "field": {
          "id": "47",
          "title": "Основание",
          "field_template": "Osnovaniye"
        }
      }
    ]
  }
]
```
<p>
    Пример ошибки:
</p>

```json5
{
  "name": "Not Found",
  "message": "There is no such document",
  "code": 0,
  "status": 404,
  "type": "yii\\web\\NotFoundHttpException"
}
```

## Создать документ

`https://guild.craft-group.xyz/api/document/create-document`
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
            title
        </td>
        <td>
            Название документа
        </td>
    </tr>
    <tr>
        <td>
            template_id
        </td>
        <td>
            Id шаблона
        </td>
    </tr>
    <tr>
        <td>
            manager_id
        </td>
        <td>
            Id менеджера
        </td>
    </tr>
    <tr>
        <td>
            field_id
        </td>
        <td>
            Id поля
        </td>
    </tr>
    <tr>
        <td>
            value
        </td>
        <td>
            Значение поля
        </td>
    </tr>
</table>

<p>
    Создаёт <b>Документ</b>. Требует передачи <b>POST</b> запроса с соответствующими
параметрами документа и полей документа
</p>

<p>
    Пример передаваемого объекта:
</p>

```json5
{
  "title": "Act64",
  "template_id": "94",
  "manager_id": "5",
  "documentFieldValues": [
    {
      "field_id": "43",
      "value": "№ документа111"
    },
    {
      "field_id": "44",
      "value": "от111"
    },
    {
      "field_id": "45",
      "value": "Сумма с НДС111"
    },
    {
      "field_id": "46",
      "value": "НДС111"
    },
    {
      "field_id": "47",
      "value": "Основание111"
    }
  ]
}
```
<p>
    В случае указания не верных параметров буде возвращена соответствующая ошибка. Пример ошибки:
</p>

```json5
{
  "name": "Bad Request",
  "message": "{\"template_id\":[\"\Ш\а\б\л\о\н cannot be blank.\"]}",
  "code": 0,
  "status": 400,
  "type": "yii\\web\\BadRequestHttpException"
}
```