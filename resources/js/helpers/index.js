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

const copyToClipboard = async (data) => {
    const alert = document.createElement('div')

    alert.classList.add('alert', 'rounded-s')

    try {
        await navigator.clipboard.writeText(data)

        alert.innerText = 'Copied'
    }
    catch(err) {
        alert.innerText = 'Error: ' + err?.message
    }

    document.querySelector('#app').appendChild(alert)

    setTimeout(() => alert.remove(), 1000)
}

export { 
    appendUrlParam, 
    dateDiff, 
    setDocumentTitle,
    formatPrice,
    copyToClipboard
}