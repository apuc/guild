<?php

use yii\helpers\Html;
use common\models\Reports;
use backend\modules\reports\models\Month;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\reports\models\ReportsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$reports = $dataProvider->getModels();
$USER_ID = $searchModel->user_card_id;

$reports_array = array_column($reports, 'attributes');
foreach ($reports as $i => $report){
    $reports_array[$i]['today'] = array_column($report->task, 'attributes');
}
$reports_month = json_encode(array_merge(
        ['reports' => $reports_array],
        ['month' => (array)new Month()])
);

$this->registerCssFile('@web/css/calendar.css');
$this->title = 'Календарь пользователя - ' . Reports::getFio($searchModel);
?>

<?=Html::beginTag('section', ['class' => 'calendar-contain'])?>
    <?=Html::beginTag('aside', ['class' => 'calendar__sidebar'])?>
        <?=Html::beginTag('section', ['class' => 'title-bar'])?>
            <?= Html::a('<i class="fas fa-long-arrow-alt-left"></i> Назад', Yii::$app->request->referrer, ['class' => 'btn btn-primary',]) ?>
            <?= Html::input('date', null, date('Y-m-d'), ['class' => 'form-control', 'id' => 'date',]) ?>
        <?=Html::endTag('section')?>

        <?=Html::tag('h2', date('l').'<br>'.date('F d'), ['class' => 'sidebar__heading'])?>

        <?=Html::beginTag('ul', ['class' => 'sidebar__list'])?>
        <?=Html::endTag('ul')?>
    <?=Html::endTag('aside')?>

    <?=Html::beginTag('section', ['class' => 'calendar__days'])?>
    <?=Html::endTag('section')?>

<?=Html::endTag('section')?>


<script>
class HtmlCalendar {

    constructor(month, reports, before = '') {
        this.month = month;
        this.reports = reports;
        this.before = before;
        this.datePicker = datePicker;

        this.classDay = 'calendar__day';

        this.initBefore();
    }

    getHtml() {
        console.log(reports)
        this.getInactiveBegin();
        this.getActive();
        this.getInactiveEnd();
        return this.html;
    }

    update(month, reports) {
        this.month = month;
        this.reports = reports;
        this.initBefore();

    }

    initBefore() {
        this.html = '';
        this.index = 1;
        this.indexRaw = 0;
        this.date = document.querySelector('#date').value.substr(0, 7);
    }

    getInactiveBegin() {
        if (Object.keys(this.month['inactive_begin']).length > 0) {
            this.html += '<section class="calendar__week">';

            for (; this.index <= Object.keys(this.month['inactive_begin']).length; this.index++, this.indexRaw++) {
                this.html += this.getCalendarDay('inactive_begin', 'inactive');
            }
        }
    }

    getActive() {
        for (; this.index <= this.getLastKey(this.month['active']); this.index++, this.indexRaw++) {
            if (this.indexRaw % 7 == 0) {
                if (this.index != 1) {
                    this.html += '</section>';
                }
                this.html += '<section class="calendar__week">';
            }
            this.html += this.getCalendarDay('active')
        }
    }

    getInactiveEnd() {
        for (; this.index <= this.getLastKey(this.month['inactive_end']); this.index++, this.indexRaw++) {
            if (this.indexRaw % 7 == 0) {
                this.html += `</section>
                            <section class="calendar__week ">`;
            }
            this.html += this.getCalendarDay('inactive_end', 'inactive');
        }
    }

    getCalendarDay(type, className = '') {
        return `<div class="${this.classDay} ${className}">
                <span class="calendar__date ${this.getColor(this.date + '-' + IntToDate(this.month[type][this.index]) )}">${this.month[type][this.index]}</span>
            </div>`;
    }

    getColor(date) {
        let d = new Date(date)
        if ([6, 0].includes(d.getDay()))
            return;
        for (let i = 0; i < Object.keys(this.reports).length; i++) {

            if (this.reports[i]['created_at'] == date) {
                return 'success';
            }
        }

        return 'danger';

    }

    getLastKey(obj) {
        return Object.keys(obj)[Object.keys(obj).length - 1];
    }
}

class HtmlReports {
constructor(reports) {
    //TODO выходные дни - праздники
this.reports = reports;
}

    getHtmlByDate(date) {

        if ([0, 6].includes(new Date(date).getDay())) {
            return "Выходной день";
        }
        if (!this.reports)
            return 'Нет репортов за месяц';
        let j = 0;
        let html = `<ul class="sidebar__list">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><a href="/secure/reports/reports/index?date=2021-08-31&amp;sort=today" data-sort="today">Что
                            было сделано
                            сегодня?</a></th>
                        <th><a href="/secure/reports/reports/index?date=2021-08-31&amp;sort=difficulties"
                               data-sort="difficulties">Какие
                            сложности возникли?</a></th>
                        <th><a href="/secure/reports/reports/index?date=2021-08-31&amp;sort=tomorrow" data-sort="tomorrow">Что
                            планируется сделать завтра?</a></th>
                        <th class="action-column">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>`;
        for (let k = 0, i = 0, report = this.reports[i]; i < Object.keys(this.reports).length; i++) {
    report = this.reports[i];
    if (report['created_at'] == date) {
        k++;
        html += `<tr data-key="${report['id']}">
                    <td>${k}</td><td>`;

        for (j = 0; j < Object.keys(report['today']).length; j++) {
            html += `<p>${j + 1}. (${report['today'][j]['hours_spent']} ч.)
${report['today'][j]['task']}</p>`
                }

        html += `</td>
                    <td>${report['difficulties']}</td>
                    <td>${report['tomorrow']}</td>
                    <td>
<a href="/secure/reports/reports/view?id=${report['id']}" title="Просмотр" aria-label="Просмотр"
                           data-pjax="0">
                            <svg aria-hidden="true"
                                 style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1.125em"
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <path fill="currentColor"
                                      d="M573 241C518 136 411 64 288 64S58 136 3 241a32 32 0 000 30c55 105 162 177 285 177s230-72 285-177a32 32 0 000-30zM288 400a144 144 0 11144-144 144 144 0 01-144 144zm0-240a95 95 0 00-25 4 48 48 0 01-67 67 96 96 0 1092-71z"></path>
                            </svg>
                        </a>
<a href="/secure/reports/reports/update?id=${report['id']}" title="Редактировать"
                                aria-label="Редактировать"
                                data-pjax="0">
                            <svg aria-hidden="true"
                                 style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1em"
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor"
                                      d="M498 142l-46 46c-5 5-13 5-17 0L324 77c-5-5-5-12 0-17l46-46c19-19 49-19 68 0l60 60c19 19 19 49 0 68zm-214-42L22 362 0 484c-3 16 12 30 28 28l122-22 262-262c5-5 5-13 0-17L301 100c-4-5-12-5-17 0zM124 340c-5-6-5-14 0-20l154-154c6-5 14-5 20 0s5 14 0 20L144 340c-6 5-14 5-20 0zm-36 84h48v36l-64 12-32-31 12-65h36v48z"></path>
                            </svg>
                        </a>
<a href="/secure/reports/reports/delete?id=${report['id']}" title="Удалить" aria-label="Удалить"
                                data-pjax="0"
                                data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post">
                            <svg aria-hidden="true"
                                 style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:.875em"
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path fill="currentColor"
                                      d="M32 464a48 48 0 0048 48h288a48 48 0 0048-48V128H32zm272-256a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zM432 32H312l-9-19a24 24 0 00-22-13H167a24 24 0 00-22 13l-9 19H16A16 16 0 000 48v32a16 16 0 0016 16h416a16 16 0 0016-16V48a16 16 0 00-16-16z"></path>
                            </svg>
                        </a></td>
`;
    }
}
        if (j == 0) {
            return "За этот день не было отчетов";
        }


        return html;
    }
}

const CALENDAR_BAR = ` < section

                class

                = "calendar__top-bar" >
                    < span

                class

                = "top-bar__days" > Mon < /span>
                <span class="top-bar__days">Tue</span>
                <span class="top-bar__days">Wed</span>
                <span class="top-bar__days">Thu</span>
                <span class="top-bar__days">Fri</span>
                <span class="top-bar__days">Sat</span>
                <span class="top-bar__days">Sun</span>
            </section>
                `;

let reports = (JSON.parse('<?=$reports_month?>'))['reports'];
let month = (JSON.parse('<?=$reports_month?>'))['month'];
let datePicker = document.querySelector('#date');
let oldDate = datePicker.value.substr(0, 7);
let nameDateBoard = document.querySelector('.sidebar__heading');

let reportsBoard = document.querySelector('.sidebar__list');
let htmlReports = new HtmlReports(reports);

let htmlCalendar = new HtmlCalendar(month, reports, CALENDAR_BAR);
let calendar = document.querySelector('.calendar__days');


calendar.load = async function (day) {
    htmlCalendar.update(month, reports)
    calendar.innerHTML = htmlCalendar.getHtml();

    htmlReports.reports = reports;
    htmlReports.getHtmlByDate('2021-08-31')

    datePicker.onchange = function (day=null) {
        let days = document.querySelectorAll('.calendar__day ')

        for (let i = 0; i < days.length; i++) {
            if (days[i].classList.contains('active_day'))
                days[i].classList.remove('active_day')

        }

        if (!isOldDatePicker(datePicker, oldDate)) {
            oldDate = datePicker.value.substr(0, 7);

            updateMonthReports(datePicker.value)
            .then(reportsMonth => {
                reports = reportsMonth['reports'];
                month = reportsMonth['month'];

                calendar.load(day);
                let date = new Date(datePicker.value);
                let monthName = date.toLocaleString('default', {month: 'long'});
                let dayWeekName = date.toLocaleString('default', {weekday: 'long'});
                nameDateBoard.innerHTML = `${dayWeekName} <br>${monthName} ${datePicker.value.substr(8, 2)}`;
                reportsBoard.innerHTML = htmlReports.getHtmlByDate(datePicker.value)
            })

        }
        let date = new Date(datePicker.value);
        let monthName = date.toLocaleString('default', {month: 'long'});
        let dayWeekName = date.toLocaleString('default', {weekday: 'long'});
        nameDateBoard.innerHTML = `${dayWeekName} <br>${monthName} ${datePicker.value.substr(8, 2)}`;
        reportsBoard.innerHTML = htmlReports.getHtmlByDate(datePicker.value)
    }

    let days = document.querySelectorAll('.calendar__day');
    for (let i = 0; i < Object.keys(days).length; i++) {
        let dateDay = parseInt(days[i].textContent);
        if (day) {
            if (parseInt(day.textContent) == dateDay && !days[i].classList.contains('inactive')) {
                days[i].classList.add('active_day')
            }
        }

        if (days[i].classList.contains('inactive')) {
            days[i].onclick = function () {
                let date = getFutureDate(datePicker.value, parseInt(days[i].textContent))
                datePicker.value = date;
                datePicker.onchange(this)
            }
        } else {
            days[i].onclick = function () {

                datePicker.value = datePicker.value.substr(0, 8) + IntToDate(dateDay);
                datePicker.onchange(this)
                days[i].classList.add('active_day')
            }
        }
    }
}

calendar.load()
datePicker.onchange()

function isOldDatePicker(datePicker, oldDate) {
    if (datePicker.value.substr(0, 7) == oldDate)
        return true;
    return false
}

async function updateMonthReports(date) {

    let monthNumber = date.substr(5, 2);
    let yearNumber = date.substr(0, 4);
    return fetch('../ajax/get-reports-for-month-by-id-year-month?user_id=<?=$USER_ID?>' +
            '&month=' + monthNumber +
            '&year=' + yearNumber)
        .then((res) => {
        return res.json()
        })

}

function getFutureDate(dat, value) {
    let date = new Date(dat);
    if (value < 8) {
        if (date.getMonth() == 11) {
            date = new Date(date.getFullYear() + 1, 0, value);
        } else {
            date = new Date(date.getFullYear(), date.getMonth() + 1, value);
        }
    } else {
        if (date.getMonth() == 0) {
            date = new Date(date.getFullYear() - 1, 11, value);
        } else {
            date = new Date(date.getFullYear(), date.getMonth() - 1, value);
        }
    }
    return date.getFullYear() + '-' + IntToDate(date.getMonth() + 1) + '-' + IntToDate(value);

}

function IntToDate(number_date) {
    if (Math.floor(number_date / 10) === 0)
        number_date = '0' + number_date;
    return number_date
}
</script>


