<?php
use yii\helpers\Html;

$this->title = 'Календарь ДР';
?>
<?= \backend\widgets\Calendar::widget([

    'css' => '.success{color: orange;}',

    'button' => Html::a('<i class="fas fa-long-arrow-alt-left"></i> Назад',
        Yii::$app->request->referrer, ['class' => 'btn btn-primary',]),
    'runBuild' => "function (date, content){
        this.build(date, content)
    }",
    'updateContent' => "function(date){
        let monthNumber = date.substr(5, 2);
        return fetch('../ajax/get-birthday-by-month?' +
            'month=' + monthNumber)
            .then((res) => {
                return res.json()
            })
    }",
    'getColor' => "function (date, dates = null) {
        for (let contentDate of dates) {
            if (contentDate['dob'].substr(8, 2) == DateHelper.intToDate(date.getDate())) {
                return 'success';
            }
        }
    }",
    'getHtmlContentForDate' => 'function (content, date) {
        let flag = false
        let html = `<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>#</th>
        <th>ФИО</th>
        <th>Дата рождения</th>
        <th class="action-column">&nbsp;</th>
    </tr>
    </thead><tbody>`;
        for (let i = 1; i <= content.length; i++) {
            let model = content[i - 1];
            if (model["dob"].substr(8, 2) == date.substr(8, 2)) {
                flag = true;
                html += `<tr data-key="${model["id"]}">`
                html += `<td>${i}</td>`
                html += `<td>${model["fio"]}</td>`
                html += `<td>${model["dob"]}</td>`
                html += CalendarHelper._getActionColumn(`secure/calendar/calendar`,model[`id`])
                html += `</tr>`
            }
        }
        html += `</tbody></table>`
        if (flag) return html;
        return "empty"
    }'
]) ?>


