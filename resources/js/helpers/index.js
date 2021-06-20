import router from '../router'
import moment from 'moment'

const appendUrlParam = param => {
    router.push({query: {...router.currentRoute._value.query, ...param}})
}

const dateDiff = (date1, date2, unit) => {
    return moment(date1).diff(date2, unit)
}

export { appendUrlParam, dateDiff }