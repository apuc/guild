class CalendarHelper {

    static build(date, dates = null) {
        const _daysNames = `<section class="calendar__top-bar">
    <span class="top-bar__days"> Mon </span>
    <span class="top-bar__days">Tue</span>
    <span class="top-bar__days">Wed</span>
    <span class="top-bar__days">Thu</span>
    <span class="top-bar__days">Fri</span>
    <span class="top-bar__days">Sat</span>
    <span class="top-bar__days">Sun</span>
</section>`;


        let month = DateHelper.getMonth(date)

        let html = `<section class="calendar__week">`, index = 1, indexRaw = 0;

        for (let i = 0, dayNum = month[i]; i < month.length; i++, dayNum = month[i]) {
            let className = ``
            if (this._isInactive(dayNum, i)) {
                className = 'inactive'
            }
            let color = this._getColor(new Date(date.getFullYear(), date.getMonth(), dayNum), dates)
            html += this._getCalendarDay(dayNum, className, color)
            if ((i + 1) % 7 == 0) {

                html += `</section><section class="calendar__week">`


            }

        }
        html = removeExcessTagSection(html)

        document.querySelector('.calendar__days').innerHTML = _daysNames + html


        function removeExcessTagSection(html) {
            return html.substr(0, html.length - 9)
        }
    }

    static main(day = null) {
        let datePicker = document.querySelector('#date');
        let oldDate = datePicker.value.substr(0, 7);

        let nameDateBoard = document.querySelector('.sidebar__heading');


        this._getMonth(datePicker.value.substr(5, 2), datePicker.value.substr(0, 4))
            .then(dates => {
                this.build(DateHelper.stringToDate(datePicker.value), dates)

                datePicker.onchange = async function (day = null) {
                    let days = document.querySelectorAll('.calendar__day ')

                    for (let i = 0; i < days.length; i++) {
                        if (parseInt(days[i].textContent) === parseInt(datePicker.value.substr(8, 2)) &&
                            !days[i].classList.contains('inactive')) {
                            days[i].classList.add('active_day')
                        } else if (days[i].classList.contains('active_day'))
                            days[i].classList.remove('active_day')
                    }

                    if (!CalendarHelper.isOldDatePicker(datePicker, oldDate)) {
                        oldDate = datePicker.value.substr(0, 7);

                        CalendarHelper._getMonth(datePicker.value.substr(5, 2), datePicker.value.substr(0, 4))
                            .then(dates => {

                                CalendarHelper.main(day)
                                let date = new Date(datePicker.value);
                                let monthName = date.toLocaleString('default', {month: 'long'});
                                let dayWeekName = date.toLocaleString('default', {weekday: 'long'});
                                nameDateBoard.innerHTML = `${dayWeekName} <br>${monthName} ${datePicker.value.substr(8, 2)}`;
                                document.querySelector('#p0').innerHTML = CalendarHelper._getHtmlContentForDate(dates, datePicker.value)
                            })

                    }


                    let date = new Date(datePicker.value);
                    let monthName = date.toLocaleString('default', {month: 'long'});
                    let dayWeekName = date.toLocaleString('default', {weekday: 'long'});
                    nameDateBoard.innerHTML = `${dayWeekName} <br>${monthName} ${datePicker.value.substr(8, 2)}`;
                    document.querySelector('#p0').innerHTML = await CalendarHelper._getDayContent(date)
                }

                let days = document.querySelectorAll('.calendar__day');

                for (let i = 0; i < Object.keys(days).length; i++) {
                    let dateDay = parseInt(days[i].textContent);
                    if (parseInt(datePicker.value.substr(8,2)) == dateDay && !days[i].classList.contains('inactive')) {
                        days[i].classList.add('active_day')
                    }


                    if (days[i].classList.contains('inactive')) {
                        days[i].onclick = function () {
                            let date = CalendarHelper._getFutureDate(datePicker.value, parseInt(days[i].textContent))
                            datePicker.value = date;
                            datePicker.onchange(this)
                        }
                    } else {
                        days[i].onclick = function () {
                            datePicker.value = datePicker.value.substr(0, 8) + DateHelper.intToDate(dateDay);
                            datePicker.onchange(this)
                        }
                    }
                }

                datePicker.onchange()

            })
    }

    static _getHtmlContentForDate(content, date) {
        /* making html content; Example: return "In this day Birthday of " +content['date']['user']; */
    }


    static _runBuild(date, content) {
        /*making something for dates from content = [date1, date2, ...]*/

        this.build(date, content)
    }

    static
    async _getMonth(month, year) {
        return fetch('../ajax/get-birthday-by-month?' +
            'month=' + month)
            .then((res) => {
                return res.json()
            })

    }

    static isOldDatePicker(datePicker, oldDate) {
        if (datePicker.value.substr(0, 7) == oldDate)
            return true;
        return false
    }

    static _isInactive(numDay, i) {
        if (i < 8 && numDay !== i + 1) {
            return (numDay > i)
        } else {
            return (i - 8) > numDay
        }
    }

    static _getCalendarDay(dayNum, className = ``, color = ``) {
        let day = ''
        if (color === 'danger' && className !== 'inactive') {
            day = 'empty_day'
        }
        else if (color === 'success' && className !== 'inactive') {
            day = 'fully_day'
        }

        return `<div class="calendar__day ${className} ${day} ">
                <span class="calendar__date ${color}">${dayNum}</span>
            </div>`;
    }

    static _getColor(date, dates = null) {
        if (dates == null || dates.length == 0) {
            return ``;
        }
        for (dateContent of dates){
            if (dateContent['date'] == date){
                return dateContent['class'];
            }
        }
        return ``;
    }

    static async _getDayContent(date){

    }

    static _getFutureDate(dat, value) {
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
        return date.getFullYear() + '-' + DateHelper.intToDate(date.getMonth() + 1) + '-' + DateHelper.intToDate(value);

    }

    static _getActionColumn(url, id) {

        return `
        <td>
            <a href="${url}/view?id=${id}" title="Просмотр" aria-label="Просмотр" data-pjax="0">
<svg aria-hidden="true"
             style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1.125em"
             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
            <path fill="currentColor"
                  d="M573 241C518 136 411 64 288 64S58 136 3 241a32 32 0 000 30c55 105 162 177 285 177s230-72 285-177a32 32 0 000-30zM288 400a144 144 0 11144-144 144 144 0 01-144 144zm0-240a95 95 0 00-25 4 48 48 0 01-67 67 96 96 0 1092-71z"></path>
        </svg>
    </a> 
            <a href="${url}/update?id=${id}" title="Редактировать" aria-label="Редактировать"
            data-pjax="0">
            <svg aria-hidden="true"
                 style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1em"
                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path fill="currentColor"
                      d="M498 142l-46 46c-5 5-13 5-17 0L324 77c-5-5-5-12 0-17l46-46c19-19 49-19 68 0l60 60c19 19 19 49 0 68zm-214-42L22 362 0 484c-3 16 12 30 28 28l122-22 262-262c5-5 5-13 0-17L301 100c-4-5-12-5-17 0zM124 340c-5-6-5-14 0-20l154-154c6-5 14-5 20 0s5 14 0 20L144 340c-6 5-14 5-20 0zm-36 84h48v36l-64 12-32-31 12-65h36v48z"></path>
            </svg>
        </a> 
            <a href="${url}/delete?id=${id}" title="Удалить" aria-label="Удалить" data-pjax="0"
                data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post">
            <svg aria-hidden="true"
                 style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:.875em"
                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path fill="currentColor"
                      d="M32 464a48 48 0 0048 48h288a48 48 0 0048-48V128H32zm272-256a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zM432 32H312l-9-19a24 24 0 00-22-13H167a24 24 0 00-22 13l-9 19H16A16 16 0 000 48v32a16 16 0 0016 16h416a16 16 0 0016-16V48a16 16 0 00-16-16z"></path>
            </svg>   
            </a>
        </td>`;
    }

}


