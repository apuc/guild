class DateHelper {
    static getMonth(date) {
        date = this.nextMonth(date)
        date = this.prevDay(date)
        let days = [], last = date, quantity = this.getQuantity(date)
        for (let i = 0; i < (7 - last.getDay()) % 7; i++) {
            days.push((7 - last.getDay()) % 7 - i)
        }
        for (let i = 0; i < last.getDate(); i++) {
            days.push(last.getDate() - i)
        }
        date = this.prevMonth(date)
        date = this.nextMonth(date)
        date = this.prevDay(date)
        for (let i = 0, lenDays = quantity - days.length; i < lenDays; i++) {
            days.push(date.getDate() - i)
        }
        return days.reverse();
    }

    static getQuantity(date) {
        if (this.isDayOff(date)) {
            return 42
        }
        if (this.prevDay(this.nextMonth(date)).getDate() == 28 && new Date(date.getFullYear(), date.getMonth(), 0).getDay() === 0) {
            return 28;
        }
        return 35

    }

    static isDayOff(date) {
        return [6, 0].includes(new Date(date.getFullYear(), date.getMonth(), 1).getDay())
    }

    static prevDay(date) {
        return new Date(date.getTime() - 1000 * 3600 * 24)
    }

    static nextMonth(date) {
        if (this.isDecember(date)) {
            return new Date(date.getFullYear() + 1, 0, 1)
        }
        return new Date(date.getFullYear(), date.getMonth() + 1, 1)
    }

    static prevMonth(date) {
        if (this.isJanuary(date)) {
            return new Date(date.getFullYear() - 1, 11, 1)
        }
        return new Date(date.getFullYear(), date.getMonth() - 1, 1)
    }

    static isDecember(date) {
        return 11 == date.getMonth()
    }

    static isJanuary(date) {
        return 0 == date.getMonth()
    }

    static intToDate(number_date) {
        if (Math.floor(number_date / 10) === 0)
            number_date = '0' + number_date;
        return number_date
    }

    static dateToString(date) {
        let year = date.getFullYear()
        let day = this.intToDate(date.getDate())
        let month = this.intToDate(date.getMonth() + 1)
        return year + '-' + month + '-' + day
    }

    static stringToDate(date) {
        let month = parseInt(date.substr(5, 2))
        return new Date(date.substr(0, 4), month, date.substr(7, 2))
    }

    static getDates(array) {
        let dates = []
        for (let model of array) {
            dates.push(model['date'])
        }
        return dates
    }
}
