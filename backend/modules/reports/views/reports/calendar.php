<?php

use backend\widgets\Calendar;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $fio */
/* @var $USER_ID */

$this->title = 'Календарь пользователя - ' . $fio;
?>

<?=Calendar::widget([

    'button' => Html::a('<i class="fas fa-long-arrow-alt-left"></i> Назад',
        Yii::$app->request->referrer, ['class' => 'btn btn-primary',]),

    'runBuild' => "function (date, content){
        contentDays = []
        for (let item of content){
            contentDays.push(item['created_at'])
        }
        this.build(date, contentDays)
    }",

    'updateContent' => "function(date){
        let monthNumber = date.substr(5, 2);
        let yearNumber = date.substr(0, 4);
        return fetch('../ajax/get-reports-for-month-by-id-year-month?user_id='+".$USER_ID."+
            '&month=' + monthNumber +
            '&year=' + yearNumber)
        .then((res) => {
            return res.json()
        })
    }",

    'getColor' => "function (date, dates = null) {
        let d = date;
        if ([6, 0].includes(d.getDay()))
            return;
        for (let i = 0; i < dates.length; i++) {
            if (dates[i] == DateHelper.dateToString(date)) {
                return 'success';
            }
        }
        return 'danger';
    }",

    'getHtmlContentForDate' => "function (content, date) {
        if ([0, 6].includes(new Date(date).getDay())) {
            return 'Выходной день';
        }
        let j = 0;
        let html = `<ul class='sidebar__list'>
                <table class='table table-striped table-bordered'>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Что было сделано сегодня?</th>
                        <th>Какие сложности возникли?</th>
                        <th>Что планируется сделать завтра?</th>
                        <th class='action-column'>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>`;
        for (let k = 0, i = 0; i < content.length; i++) {
            let report = content[i];
            if (report['created_at'] == date) {
                k++;
                html += `<tr data-key='\${report['id']}'>
                    <td>\${k}</td><td>`;
                    
                for (j = 0; j < Object.keys(report['today']).length; j++) {
                    html += `<p>\${j + 1}. (\${report['today'][j]['hours_spent']} ч.)
\${report['today'][j]['task']}</p>`
                }
                
                html += `</td>
                    <td>\${report['difficulties']}</td>
                    <td>\${report['tomorrow']}</td>
                    \${CalendarHelper._getActionColumn(`/secure/reports/reports`, report['id'])}`;
            }
        }
        if (j == 0) {
            return 'За этот день не было отчетов';
        }
        return html;
    }"
]) ?>
