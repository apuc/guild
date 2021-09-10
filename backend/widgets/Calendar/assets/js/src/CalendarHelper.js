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
        let contentBoard = document.querySelector('.sidebar__list');

        this._updateContent(datePicker.value)
            .then(content => {

                this._runBuild(DateHelper.stringToDate(datePicker.value), content)

                datePicker.onchange = function (day = null) {
                    let days = document.querySelectorAll('.calendar__day ')

                    for (let i = 0; i < days.length; i++) {
                        if (days[i].classList.contains('active_day'))
                            days[i].classList.remove('active_day')
                    }

                    if (!CalendarHelper.isOldDatePicker(datePicker, oldDate)) {
                        oldDate = datePicker.value.substr(0, 7);

                        CalendarHelper._updateContent(datePicker.value)
                            .then(content => {

                                CalendarHelper.main(day)
                                let date = new Date(datePicker.value);
                                let monthName = date.toLocaleString('default', {month: 'long'});
                                let dayWeekName = date.toLocaleString('default', {weekday: 'long'});
                                nameDateBoard.innerHTML = `${dayWeekName} <br>${monthName} ${datePicker.value.substr(8, 2)}`;
                                contentBoard.innerHTML = CalendarHelper._getHtmlContentForDate(content, datePicker.value)
                            })

                    }
                    let date = new Date(datePicker.value);
                    let monthName = date.toLocaleString('default', {month: 'long'});
                    let dayWeekName = date.toLocaleString('default', {weekday: 'long'});
                    nameDateBoard.innerHTML = `${dayWeekName} <br>${monthName} ${datePicker.value.substr(8, 2)}`;
                    contentBoard.innerHTML = CalendarHelper._getHtmlContentForDate(content, datePicker.value)
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
                            let date = CalendarHelper._getFutureDate(datePicker.value, parseInt(days[i].textContent))
                            datePicker.value = date;
                            datePicker.onchange(this)
                        }
                    } else {
                        days[i].onclick = function () {
                            datePicker.value = datePicker.value.substr(0, 8) + DateHelper.intToDate(dateDay);
                            datePicker.onchange(this)
                            days[i].classList.add('active_day')
                        }
                    }
                }


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
    async _updateContent(date) {
        let monthNumber = date.substr(5, 2);
        return fetch('../ajax/get-birthday-by-month?' +
            'month=' + monthNumber)
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
        return `<div class="calendar__day ${className}">
                <span class="calendar__date ${color}">${dayNum}</span>
            </div>`;
    }

    static _getColor(date, dates = null) {
        if (dates != null && dates.includes(DateHelper.dateToString(date))) {
            return 'success';
        }
        if ([6, 0].includes(date.getDay()))
            return;

        return 'danger';
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

}
