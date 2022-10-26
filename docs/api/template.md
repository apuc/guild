# Шаблоны

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
            get-template-list
        </td>
        <td>
            Возвращает список шаблонов 
        </td>
    </tr>
    <tr>
        <td>
            get-template-fields
        </td>
        <td>
            Возвращает поля шаблона 
        </td>
    </tr>
    <tr>
        <td>
            get-template
        </td>
        <td>
            Возвращает шаблон 
        </td>
    </tr>
</table>

## Список шаблонов

`https://guild.craft-group.xyz/api/template/get-template-list?document_type=1`
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
    Без передачи параметра возвращает массив объектов <b>Шаблон</b> . С параметром <b>document_type</b>, 
метод возвращает объекты <b>Шаблон</b> определённого типа(<b>1 - Акт; 2 - Договор</b>).
</p>

<p>
    Возвращает <b>массив</b> объектов <b>Шаблон</b>. <br>
    Каждый объект <b>Шаблон</b> имеет такой вид:
</p>

```json5
[
  {
    "id": "94",
    "title": "Акт",
    "created_at": "2022-01-11 11:47:11",
    "updated_at": null,
    "template_file_name": null,
    "document_type": "2"
  },
 '...'
]
```

## Получить шаблон

`https://guild.craft-group.xyz/api/template/get-template?template_id=94`
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
            template_id
        </td>
        <td>
            Id шаблона
        </td>
    </tr>
</table>

<p>
    Возвращает объект <b>Шаблон</b>. <br>
    Каждый объект <b>Шаблон</b> имеет такой вид:
</p>

```json5
{
  "id": "94",
  "title": "Акт",
  "created_at": "2022-01-11 11:47:11",
  "updated_at": null,
  "template_file_name": null,
  "document_type": "2"
}
```

## Получить поля шаблона

`https://guild.craft-group.xyz/api/template/get-template-fields?template_id=94`
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
            template_id
        </td>
        <td>
            Id шаблона
        </td>
    </tr>
</table>

<p>
    Возвращает объект <b>Шаблон</b>. <br>
    Каждый объект <b>Шаблон</b> имеет такой вид:
</p>

```json5
{
  "id": "94",
  "title": "Акт",
  "created_at": "2022-01-11 11:47:11",
  "updated_at": null,
  "template_file_name": null,
  "document_type": "2",
  "templateDocumentFields": [
    {
      "id": "159",
      "template_id": "94",
      "field_id": "43",
      "field": {
        "id": "43",
        "title": "№ документа",
        "field_template": "№ dokumenta"
      }
    },
    {
      "id": "160",
      "template_id": "94",
      "field_id": "44",
      "field": {
        "id": "44",
        "title": "от",
        "field_template": "ot"
      }
    },
    {
      "id": "161",
      "template_id": "94",
      "field_id": "45",
      "field": {
        "id": "45",
        "title": "Сумма с НДС",
        "field_template": "Summa s NDS"
      }
    },
    {
      "id": "162",
      "template_id": "94",
      "field_id": "46",
      "field": {
        "id": "46",
        "title": "НДС",
        "field_template": "NDS"
      }
    },
    {
      "id": "163",
      "template_id": "94",
      "field_id": "47",
      "field": {
        "id": "47",
        "title": "Основание",
        "field_template": "Osnovaniye"
      }
    }
  ]
}
```
