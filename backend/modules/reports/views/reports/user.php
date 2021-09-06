<?php

use backend\modules\reports\models\ReportsSearch;
use kartik\grid\GridView;
use yii\data\Pagination;
use yii\helpers\Html;
use common\models\Reports;
use  \common\classes\Debug;
use backend\modules\reports\models\Month;


/* @var $this yii\web\View */
/* @var $searchModel backend\modules\reports\models\ReportsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $reports common\models\Reports */
/* @var $ID */


$month = new Month($date);
$index_raw = 0;

function next_day($date, $number)
{
    return date('Y-m-d', strtotime($date) + 3600 * 24 * $number);
}

function get_dates_created_at(Reports $report)
{
    return $report->created_at;
}

function get_color($date, $dates_created_at)
{
    if (in_array(Month::get_day_week($date), array(6, 7)))
        return;
    if (in_array($date, $dates_created_at)) {
        return 'success';
    } else
        return 'danger';
}

$this->title = 'Календарь пользователя - ' . Reports::getFio($reports[0]);
$dates_created_at = array_unique(array_map('get_dates_created_at', $reports));

//for ($date = '2021-08-01', $i = 0; $date != '2021-09-01'; $date = next_day($date, 1), $i++) {
//    if ($i == 7) {
//        echo '<div>';
//        $i = 0;
//    }
//    if (in_array($date, $dates_created_at)) {
//        $color = 'primary';
//    } else
//        $color = 'danger';
//    echo Html::a($date, ['reports/?date=' . $date], ['class' => 'btn btn-' . $color . '',
//        'style' => 'margin: 10px;']);
//
//}
//

//
//?>
<?= Html::csrfMetaTags() ?>
<section class="calendar-contain">


    <aside class="calendar__sidebar">
        <section class="title-bar">
            <?= Html::input('date', 'date', isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'), [
                'class' => 'form-control',
                'style' => 'display:',
                'id' => 'date',
            ]) ?>

        </section>
        <h2 class="sidebar__heading"><?= date('l') ?><br><?= date('F d') ?></h2>
        <ul class="sidebar__list">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
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
                <tbody>
                <tr data-key="4">
                    <td>1</td>
                    <td><p>1. (1 ч.) asd</p></td>
                    <td></td>
                    <td></td>
                    <td><a href="/secure/reports/reports/view?id=4" title="Просмотр" aria-label="Просмотр"
                           data-pjax="0">
                            <svg aria-hidden="true"
                                 style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1.125em"
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <path fill="currentColor"
                                      d="M573 241C518 136 411 64 288 64S58 136 3 241a32 32 0 000 30c55 105 162 177 285 177s230-72 285-177a32 32 0 000-30zM288 400a144 144 0 11144-144 144 144 0 01-144 144zm0-240a95 95 0 00-25 4 48 48 0 01-67 67 96 96 0 1092-71z"></path>
                            </svg>
                        </a> <a href="/secure/reports/reports/update?id=4" title="Редактировать"
                                aria-label="Редактировать"
                                data-pjax="0">
                            <svg aria-hidden="true"
                                 style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1em"
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor"
                                      d="M498 142l-46 46c-5 5-13 5-17 0L324 77c-5-5-5-12 0-17l46-46c19-19 49-19 68 0l60 60c19 19 19 49 0 68zm-214-42L22 362 0 484c-3 16 12 30 28 28l122-22 262-262c5-5 5-13 0-17L301 100c-4-5-12-5-17 0zM124 340c-5-6-5-14 0-20l154-154c6-5 14-5 20 0s5 14 0 20L144 340c-6 5-14 5-20 0zm-36 84h48v36l-64 12-32-31 12-65h36v48z"></path>
                            </svg>
                        </a> <a href="/secure/reports/reports/delete?id=4" title="Удалить" aria-label="Удалить"
                                data-pjax="0"
                                data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post">
                            <svg aria-hidden="true"
                                 style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:.875em"
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path fill="currentColor"
                                      d="M32 464a48 48 0 0048 48h288a48 48 0 0048-48V128H32zm272-256a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zM432 32H312l-9-19a24 24 0 00-22-13H167a24 24 0 00-22 13l-9 19H16A16 16 0 000 48v32a16 16 0 0016 16h416a16 16 0 0016-16V48a16 16 0 00-16-16z"></path>
                            </svg>
                        </a></td>
                </tr>
                <tr data-key="9">
                    <td>2</td>
                    <td><p>1. (23 ч.) asdasd</p></td>
                    <td></td>
                    <td></td>
                    <td><a href="/secure/reports/reports/view?id=9" title="Просмотр" aria-label="Просмотр"
                           data-pjax="0">
                            <svg aria-hidden="true"
                                 style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1.125em"
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                            </svg>
                        </a> <a href="/secure/reports/reports/update?id=9" title="Редактировать"
                                aria-label="Редактировать"
                                data-pjax="0">
                            <svg aria-hidden="true"
                                 style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1em"
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            </svg>
                        </a> <a href="/secure/reports/reports/delete?id=9" title="Удалить" aria-label="Удалить"
                                data-pjax="0"
                                data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post">
                            <svg aria-hidden="true"
                                 style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:.875em"
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            </svg>
                        </a></td>
                </tr>
                </tbody>
            </table>
        </ul>
    </aside>


    <section class="calendar__days">
        <!--        <section class="calendar__top-bar">-->
        <!--            <span class="top-bar__days">Mon</span>-->
        <!--            <span class="top-bar__days">Tue</span>-->
        <!--            <span class="top-bar__days">Wed</span>-->
        <!--            <span class="top-bar__days">Thu</span>-->
        <!--            <span class="top-bar__days">Fri</span>-->
        <!--            <span class="top-bar__days">Sat</span>-->
        <!--            <span class="top-bar__days">Sun</span>-->
        <!--        </section>-->
        <!---->
        <!--        --><?php
        //        $index = 1;
        //        if (count($month->inactive_begin)) {
        //            echo '<section class="calendar__week">';
        //
        //            for ($index = 1; $index <= count($month->inactive_begin); $index++, $index_raw++)
        //                echo '                <div class="calendar__day inactive">
        //
        //                    <span class="calendar__date">' . $month->inactive_begin[$index] . '</span>
        //                </div>';
        //        }
        //        for (; $index <= array_key_last($month->active); $index++, $index_raw++) {
        //
        //            if ($index_raw % 7 == 0) {
        //                if ($index != 1) echo '</section>';
        //                echo '<section class="calendar__week">
        //        ';
        //            }
        //            echo '
        //        <div class="calendar__day">
        //                    <span class="calendar__date ' . get_color(date('Y-m-' . $month->active[$index], strtotime($date)), $dates_created_at) . '">
        //                        ' . $month->active[$index] . '
        //        </span>
        //        </div>
        //        ';
        //        }
        //        ?>
        <!--        --><?php //for (; $index <= array_key_last($month->inactive_end); $index++, $index_raw++): ?>
        <!--            --><?php //if ($index_raw % 7 == 0)
        //                echo '
        //                </section>
        //        <section class="calendar__week ">
        //        ';
        //            ?>
        <!--            <div class="calendar__day inactive">-->
        <!--                <span class="calendar__date "><? //= $month->inactive_end[$index] ?><!--</span>-->
        <!--            </div>-->
        <!--        --><?php //endfor; ?>
    </section>

</section>
<script>

    class HtmlCalendar {

        constructor(month, reports, before = '') {
            this.month = month;
            this.reports = reports;
            this.before = before;
            this.datePicker = datePicker;

            this.classDay = 'calendar__day';

            this.nameDate = document.querySelector('.sidebar__heading');

            this.initBefore();
        }

        getHtml() {
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
                <span class="calendar__date ${this.getColor(this.date + '-' + this.month[type][this.index])}">${this.month[type][this.index]}</span>
            </div>`;
        }

        getColor(date) {
            let d = new Date(date)
            if ([6, 0].includes(d.getDay()))
                return;
            for (let i in this.reports) {
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
    };


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
    let nameDate = document.querySelector('.sidebar__heading');

    let reportsBoard = document.querySelector('.sidebar__list');
    let htmlReports = new HtmlReports(reports);

    let htmlCalendar = new HtmlCalendar(month, reports, CALENDAR_BAR);
    let calendar = document.querySelector('.calendar__days');


    calendar.load = async function () {

        htmlCalendar.update(month, reports)
        calendar.innerHTML = htmlCalendar.getHtml();

        htmlReports.reports = reports;
        htmlReports.getHtmlByDate('2021-08-31')

        datePicker.onchange = function () {
            if (!isOldDatePicker(datePicker, oldDate)) {
                oldDate = datePicker.value.substr(0, 7);

                updateMonthReports(datePicker.value)
                    .then(reportsMonth => {
                        reports = reportsMonth['reports'];
                        month = reportsMonth['month'];

                        calendar.load();
                    })

            }
            let date = new Date(datePicker.value);
            let monthName = date.toLocaleString('default', {month: 'long'});
            let dayWeekName = date.toLocaleString('default', {weekday: 'long'});
            nameDate.innerHTML = `${dayWeekName} <br>${monthName} ${datePicker.value.substr(8, 2)}`;
            reportsBoard.innerHTML = htmlReports.getHtmlByDate(datePicker.value)
        }

        let days = document.querySelectorAll('.calendar__day');
        for (let i = 0; i < Object.keys(days).length; i++) {
            let dateDay = parseInt(days[i].textContent);

            if (days[i].classList.contains('inactive')) {
                days[i].onclick = function () {
                    let date = getFutureDate(datePicker.value, parseInt(days[i].textContent))
                    console.log(date)
                    datePicker.value = date;
                    datePicker.onchange()
                }
            } else {
                days[i].onclick = function () {
                    datePicker.value = datePicker.value.substr(0, 8) + IntToDate(dateDay);
                    datePicker.onchange()
                }
            }
        }
    }

    calendar.load()


    function isOldDatePicker(datePicker, oldDate) {
        if (datePicker.value.substr(0, 7) == oldDate)
            return true;
        return false
    }


    async function updateMonthReports(date) {

        let monthNumber = date.substr(5, 2);
        let yearNumber = date.substr(0, 4);

        return fetch('../ajax/get-reports-for-month-by-id-year-month?id=<?=$ID?>' +
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
        return date.getFullYear() + '-' + IntToDate(date.getMonth()+1) + '-' + IntToDate(value);

    }

    function IntToDate(number_date) {
        if (Math.floor(number_date / 10) === 0)
            number_date = '0' + number_date;
        return number_date
    }

</script>

<style>

    .calendar-contain {
        position: relative;
        left: 0;
        right: 0;
        border-radius: 0;
        width: 100%;
        overflow: hidden;
        max-width: 1920px;
        min-width: 450px;
        margin: 1rem auto;
        background-color: #f5f7f6;
        box-shadow: 5px 5px 72px rgba(30, 46, 50, 0.5);
        color: #040605;
    }

    @media screen and (min-width: 55em) {
        .calendar-contain {
            margin: auto;
            top: 5%;
        }
    }

    .title-bar {
        position: relative;
        width: 100%;
        display: table;
        text-align: right;
        background: #f5f7f6;
        padding: 0.5rem;
        margin-bottom: 0;
    }

    .title-bar:after {
        display: table;
        clear: both;
    }

    .title-bar__burger {
        display: block;
        position: relative;
        float: left;
        overflow: hidden;
        margin: 0;
        padding: 0;
        width: 38px;
        height: 30px;
        font-size: 0;
        text-indent: -9999px;
        appearance: none;
        box-shadow: none;
        border: none;
        cursor: pointer;
        background: none;
    }

    .title-bar__burger:focus {
        outline: none;
    }

    .burger__lines {
        display: block;
        position: absolute;
        width: 18px;
        top: 15px;
        left: 0;
        right: 0;
        margin: auto;
        height: 1px;
        background: #040605;
    }

    .burger__lines:before, .burger__lines:after {
        position: absolute;
        display: block;
        left: 0;
        width: 100%;
        height: 1px;
        background-color: #040605;
        content: "";
    }

    .burger__lines:before {
        top: -5px;
    }

    .burger__lines:after {
        bottom: -5px;
    }

    .title-bar__year {
        display: block;
        position: relative;
        float: left;
        font-size: 1rem;
        line-height: 30px;
        width: 43%;
        padding: 0 0.5rem;
        text-align: left;
    }

    @media screen and (min-width: 55em) {
        .title-bar__year {
            width: 27%;
        }
    }

    .title-bar__month {
        position: relative;
        /*float: center;*/
        font-size: 1rem;
        line-height: 30px;
        width: 22%;
        padding: 0 0.5rem;
        text-align: center;
        margin-right: 67px;
        word-spacing: 30px;
    }

    @media screen and (min-width: 55em) {
        .title-bar__month {
            width: 12%;
        }
    }

    .title-bar__minimize, .title-bar__maximize, .title-bar__close {
        position: relative;
        float: left;
        width: 34px;
        height: 34px;
    }

    .title-bar__minimize:before, .title-bar__maximize:before, .title-bar__close:before, .title-bar__minimize:after, .title-bar__maximize:after, .title-bar__close:after {
        top: 30%;
        right: 30%;
        bottom: 30%;
        left: 30%;
        content: " ";
        position: absolute;
        border-color: #8e8e8e;
        border-style: solid;
        border-width: 0 0 2px 0;
    }

    .title-bar .title-bar__controls {
        display: inline-block;
        vertical-align: top;
        position: relative;
        float: right;
        width: auto;
    }

    .title-bar .title-bar__controls:before, .title-bar .title-bar__controls:after {
        content: none;
    }

    .title-bar .title-bar__minimize:before {
        border-bottom-width: 2px;
    }

    .title-bar .title-bar__maximize:before {
        border-width: 1px 1px 2px 1px;
    }

    .title-bar .title-bar__close:before, .title-bar .title-bar__close:after {
        bottom: 50%;
        top: 49.9%;
    }

    .title-bar .title-bar__close:before {
        transform: rotate(45deg);
    }

    .title-bar .title-bar__close:after {
        transform: rotate(-45deg);
    }

    .calendar__sidebar {
        width: 100%;
        margin: 0 auto;
        float: none;
        background: linear-gradient(120deg, #eff3f3, #e1e7e8);
        padding-bottom: 0.7rem;
    }

    @media screen and (min-width: 55em) {
        .calendar__sidebar {
            position: absolute;
            height: 100%;
            width: 50%;
            float: left;
            margin-bottom: 0;
        }
    }

    .calendar__sidebar .content {
        padding: 2rem 1.5rem 2rem 4rem;
        color: #040605;
    }

    .sidebar__nav {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        margin-bottom: 0.9rem;
        padding: 0.7rem 1rem;
        background-color: #f5f7f6;
    }

    .sidebar__nav-item {
        display: inline-block;
        width: 22px;
        margin-right: 23px;
        padding: 0;
        opacity: 0.8;
    }

    .sidebar__list {
        list-style: none;
        margin: 0;
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .sidebar__list-item {
        margin: 1.2rem 0;
        color: #2d4338;
        font-weight: 100;
        font-size: 1rem;
    }

    .list-item__time {
        display: inline-block;
        width: 60px;
    }

    @media screen and (min-width: 55em) {
        .list-item__time {
            margin-right: 2rem;
        }
    }

    .sidebar__list-item--complete {
        color: rgba(4, 6, 5, 0.3);
    }

    .sidebar__list-item--complete .list-item__time {
        color: rgba(4, 6, 5, 0.3);
    }

    .sidebar__heading {
        font-size: 2.2rem;
        font-weight: bold;
        padding-left: 1rem;
        padding-right: 1rem;
        margin-bottom: 3rem;
        margin-top: 1rem;
    }

    .sidebar__heading span {
        float: right;
        font-weight: 300;
    }

    .calendar__heading-highlight {
        color: #2d444a;
        font-weight: 900;
    }

    .calendar__days {
        display: flex;
        flex-flow: column wrap;
        align-items: stretch;
        width: 100%;
        float: none;
        min-height: 580px;
        height: 100%;
        font-size: 12px;
        /*padding: 0.8rem 0 1rem 1rem;*/
        #b8cad6 background: #f5f7f6;
    }

    @media screen and (min-width: 55em) {
        .calendar__days {
            width: 50%;
            float: right;
        }
    }

    .calendar__top-bar {
        background: #b8cad6;
        text-align: center;
        display: flex;
        flex: 56px 0 0;
    }

    .top-bar__days {
        width: 100%;
        padding: 0 5px;
        color: #2d4338;
        font-weight: 100;
        -webkit-font-smoothing: subpixel-antialiased;
        font-size: 1rem;
    }

    .calendar__week {
        display: flex;
        flex: 1 1 0;
    }

    .calendar__day {
        text-align: center;
        display: flex;
        flex-flow: column wrap;
        justify-content: space-between;
        width: 100%;
        padding: 1.9rem 0.2rem 0.2rem;
    }


    .calendar__date {
        color: #040605;
        font-size: 1.7rem;
        font-weight: 600;
        line-height: 0.7;
    }

    @media screen and (min-width: 55em) {
        .calendar__date {
            font-size: 2.3rem;
        }
    }

    .calendar__week .inactive .calendar__date, .calendar__week .inactive .task-count {
        color: #c6c6c6;
    }

    .calendar__week .today .calendar__date {
        color: #fd588a;
    }

    .calendar__task {
        color: #040605;
        display: flex;
        font-size: 0.8rem;
    }

    @media screen and (min-width: 55em) {
        .calendar__task {
            font-size: 1rem;
        }
    }

    .calendar__task.calendar__task--today {
        color: #fd588a;
    }


    .danger {
        color: red;
    }

    .success {
        color: green;
    }

    .calendar__day:hover {
        color: #0a0a0a;
        background: #a6a6a6;
        cursor: pointer;
    }
</style>


