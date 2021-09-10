<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $fio */
/* @var $USER_ID */

$this->title = 'Календарь пользователя - ' . $fio;
?>
<?= \backend\widgets\Calendar::widget([
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
                        <th><a href='/secure/reports/reports/index?date=2021-08-31&amp;sort=today' data-sort='today'>Что
                            было сделано
                            сегодня?</a></th>
                        <th><a href='/secure/reports/reports/index?date=2021-08-31&amp;sort=difficulties'
                               data-sort='difficulties'>Какие
                            сложности возникли?</a></th>
                        <th><a href='/secure/reports/reports/index?date=2021-08-31&amp;sort=tomorrow' data-sort='tomorrow'>Что
                            планируется сделать завтра?</a></th>
                        <th class='action-column'>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>`;
        for (let k = 0, i = 0, report = content[i]; i < content.length; i++) {
            report = content[i];
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
                    <td>
<a href='/secure/reports/reports/view?id=\${report['id']}' title='Просмотр' aria-label='Просмотр'
                           data-pjax='0'>
                            <svg aria-hidden='true'
                                 style='display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1.125em'
                                 xmlns='http://www.w3.org/2000/svg' viewBox='0 0 576 512'>
                                <path fill='currentColor'
                                      d='M573 241C518 136 411 64 288 64S58 136 3 241a32 32 0 000 30c55 105 162 177 285 177s230-72 285-177a32 32 0 000-30zM288 400a144 144 0 11144-144 144 144 0 01-144 144zm0-240a95 95 0 00-25 4 48 48 0 01-67 67 96 96 0 1092-71z'></path>
                            </svg>
                        </a>
<a href='/secure/reports/reports/update?id=\${report['id']}' title='Редактировать'
                                aria-label='Редактировать'
                                data-pjax='0'>
                            <svg aria-hidden='true'
                                 style='display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1em'
                                 xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'>
                                <path fill='currentColor'
                                      d='M498 142l-46 46c-5 5-13 5-17 0L324 77c-5-5-5-12 0-17l46-46c19-19 49-19 68 0l60 60c19 19 19 49 0 68zm-214-42L22 362 0 484c-3 16 12 30 28 28l122-22 262-262c5-5 5-13 0-17L301 100c-4-5-12-5-17 0zM124 340c-5-6-5-14 0-20l154-154c6-5 14-5 20 0s5 14 0 20L144 340c-6 5-14 5-20 0zm-36 84h48v36l-64 12-32-31 12-65h36v48z'></path>
                            </svg>
                        </a>
<a href='/secure/reports/reports/delete?id=\${report['id']}' title='Удалить' aria-label='Удалить'
                                data-pjax='0'
                                data-confirm='Вы уверены, что хотите удалить этот элемент?' data-method='post'>
                            <svg aria-hidden='true'
                                 style='display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:.875em'
                                 xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512'>
                                <path fill='currentColor'
                                      d='M32 464a48 48 0 0048 48h288a48 48 0 0048-48V128H32zm272-256a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zM432 32H312l-9-19a24 24 0 00-22-13H167a24 24 0 00-22 13l-9 19H16A16 16 0 000 48v32a16 16 0 0016 16h416a16 16 0 0016-16V48a16 16 0 00-16-16z'></path>
                            </svg>
                        </a></td>
`;
            }
        }
        if (j == 0) {
            return 'За этот день не было отчетов';
        }


        return html;
    }"
]) ?>





