import router from '../router'
import moment from 'moment'

const appendUrlParam = param => {
    router.push({query: {...router.currentRoute._value.query, ...param}})
}

const dateDiff = (date1, date2, unit) => {
    return moment(date1).diff(date2, unit)
}

const setDocumentTitle = (title) => {
    document.title = title
}

const formatPrice = (price, decimals = 2) => {
    const modifier = Math.pow(10, decimals)

    return Math.round(price * modifier) / modifier
}

export { 
    appendUrlParam, 
    dateDiff, 
    setDocumentTitle,
    formatPrice 
}