import { appendUrlParam } from '../helpers'
import moment from 'moment'

export default {
    data() {
        return {
            sorts: [
                { name: 'Item name', value: 'hash_name' },
                { name: 'Sold', value: 'sold' },
                { name: 'Avg discount', value: 'avg_discount' },
                { name: 'Avg shadowpay price', value: 'avg_suggested_price' },
                { name: 'Avg steam price', value: 'avg_steam_price' },
                { name: 'Sold at', value: 'last_sold' }
            ],
            exteriorsFilters: [
                { name: '-- all --', value: 'all' },
                { name: 'Factory New', value: 'fn' },
                { name: 'Minimal Wear', value: 'mw' },
                { name: 'Field-Tested', value: 'ft' },
                { name: 'Well-Worn', value: 'ww' },
                { name: 'Battle-Scarred', value: 'bs' }
            ],
            stattrakFilters: [
                { name: '-- all --', value: 'all' },
                { name: 'With StatTrak™', value: 'true' },
                { name: 'Without StatTrak™', value: 'false' }
            ]
        }
    },
    computed: {
        search: {
            get() {
                return this.$route.query.search ?? ''
            },
            set(value) {
                appendUrlParam({ search: value })
            }
        },
        price_from: {
            get() {
                return parseFloat(this.$route.query.price_from) || 0
            },
            set(value) {
                appendUrlParam({ price_from: value })
            }
        },
        price_to: {
            get() {
                return parseFloat(this.$route.query.price_to) || (10000 * this.currency.ratio)
            },
            set(value) {
                appendUrlParam({ price_to: value })
            }
        },
        min_sold: {
            get() {
                return parseInt(this.$route.query.min_sold) || 0
            },
            set(value) {
                appendUrlParam({ min_sold: value })
            }
        },
        max_sold: {
            get() {
                return parseInt(this.$route.query.max_sold) || 10000
            },
            set(value) {
                appendUrlParam({ max_sold: value })
            }
        },
        date_start: {
            get() {
                return this.$route.query.date_start ?? moment().subtract(7, 'days').format('YYYY-MM-DD')
            },
            set(value) {
                appendUrlParam({ date_start: value })
            }
        },
        date_end: {
            get() {
                return this.$route.query.date_end ?? moment().format('YYYY-MM-DD')
            },
            set(value) {
                appendUrlParam({ date_end: value })
            }
        },
        order_by: {
            get() {
                return this.$route.query.order_by ?? 'sold'
            },
            set(value) {
                appendUrlParam({ order_by: value })
            }
        },
        order_dir: {
            get() {
                return this.$route.query.order_dir ?? 'desc'
            },
            set(value) {
                appendUrlParam({ order_dir: value })
            }
        },
        exteriors: {
            get() {
                return this.$route.query.exteriors ?? 'all'
            },
            set(value) {
                appendUrlParam({ exteriors: value == 'all' ? undefined : value })
            }
        },
        is_stattrak: {
            get() {
                return this.$route.query.is_stattrak ?? 'all'
            },
            set(value) {
                appendUrlParam({ is_stattrak: value == 'all' ? undefined : value })
            }
        }
    },
    methods: {
        updateSortDir() {
            if(this.order_dir == 'asc') this.order_dir = 'desc'
            else this.order_dir = 'asc'
        }
    }
}