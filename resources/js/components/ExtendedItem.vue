<template>
    <div 
        v-if="item"
        class="d-flex flex-jc-c flex-ai-c w-100 wrapper"
    >
        <div class="content__item padding-m rounded-s d-flex w-100">
            <base-item 
                class="item__details padding-clear"
                :style="{ padding: 0 }"
                :item="item"
            ></base-item>
            <div class="item__charts d-flex flex-ai-c w-100">
                <div class="chart-wrapper w-100 h-100">
                    <canvas ref="priceChart"></canvas>
                </div>
                <div class="chart-wrapper w-100 h-100">
                    <canvas ref="sellChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <app-loader v-else></app-loader>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import { setDocumentTitle } from '../helpers'
import Chart from 'chart.js/auto'
import moment from 'moment'
import BaseItem from './BaseItem'
import AppLoader from './ui/AppLoader'

export default {
    name: 'ExtendedItem',
    components: {
        BaseItem,
        AppLoader
    },
    props: {
        hashName: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            item: null,
            itemLoaded: false,
            trendLoaded: false,
            dateStart: moment().subtract('30', 'days').format('YYYY-MM-DD'),
            charts: {
                priceTrend: null,
                sellTrend: null
            }
        }
    },
    computed: {
        ...mapState({
            fetchDelay: state => state.app.fetchDelay
        }),
        ...mapGetters({
            conduitApiUrl: 'app/conduitApiUrl'
        })
    },
    created() {
        this.initChartDefaults()
        this.loadItem()
    },
    methods: {
        async loadItem() {
            await new Promise(r => setTimeout(r, this.fetchDelay))

            try {
                const response = await axios.get(`${this.conduitApiUrl('SHADOWPAY_SOLD_ITEMS')}/${this.hashName}`, {
                    params: {
                        date_start: this.dateStart
                    }
                })

                const {success, data} = response.data

                if(success) {
                    setDocumentTitle(`Conduit - ${this.hashName}`)
                    this.item = data
                    this.loadTrend()
                }
            }
            catch(err) {
                this.$router.push({
                    name: 'NotFound',
                    params: {
                        pathMatch: decodeURI(this.$route.path.substring(1)).split('/')
                    },
                    query: this.$route.query,
                    hash: this.$route.hash
                })
            }

            this.itemLoaded = true
        },
        initChartDefaults() {
            Chart.defaults.color = '#cbd5e0'
            Chart.defaults.plugins.legend.position = 'bottom'
            Chart.defaults.responsive = true
            Chart.defaults.maintainAspectRatio = false
            Chart.defaults.plugins.title = Object.assign(Chart.defaults.plugins.title, {
                display: true,
                align: 'start',
                font: {
                    size: 14,
                    weight: 'bold'
                },
                padding: {
                    bottom: 20
                }
            })
            Chart.defaults.font = Object.assign(Chart.defaults.font, {
                family: "'Nunito', sans-serif"
            })
        },
        async loadTrend() {
            if(this.trendLoaded) return

            try {
                const response = await axios.get(`${this.conduitApiUrl('SHADOWPAY_SOLD_ITEMS')}/${this.item.hash_name}/trend`, {
                    params: {
                        date_start: this.dateStart
                    }
                })

                const {success, data} = response.data

                let labels = []
                let shadowpayPrices = []
                let steamPrices = []
                let shadowpaySold = []

                if(success) {
                    for(let row of data) {
                        labels.push(row.date)
                        shadowpayPrices.push(row.avg_sell_price)
                        steamPrices.push(row.avg_steam_price)
                        shadowpaySold.push(row.sold)
                    }

                    labels = labels.map(date => moment(date).format('MMMM DD'))
                }

                this.createPriceTrendChart(labels, shadowpayPrices, steamPrices)
                this.createSellTrendChart(labels, shadowpaySold)
            }
            catch(err) {
                console.log(err?.message)
            }

            this.trendLoaded = true
        },
        createPriceTrendChart(labels, shadowpayPrices, steamPrices) {
            this.charts.priceTrend = new Chart(this.$refs.priceChart, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Avg sell price',
                            data: shadowpayPrices,
                            backgroundColor: '#1a202c',
                            borderColor: '#1a202c',
                            borderWidth: 1
                        },
                        {
                            label: 'Avg steam price',
                            data: steamPrices,
                            backgroundColor: 'grey',
                            borderColor: 'grey',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        title: {
                            text: 'Price trend'
                        },
                    }
                }
            })
        },
        createSellTrendChart(labels, shadowpaySold) {
            this.charts.sellTrend = new Chart(this.$refs.sellChart, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Sold',
                        data: shadowpaySold,
                        backgroundColor: '#1e2533',
                        borderColor: '#1a202c',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        title: {
                            text: 'Sell trend'
                        }
                    }
                }
            })
        }
    }
}
</script>

<style scoped>
.wrapper {
    min-height: 100vh;
}

.content__item {
    max-width: 1024px;
    background-color: var(--alt-bg-color);
    color: var(--alt-text-color);
}

.item__details {
    flex: 0 0 300px;
}

.item__charts {
    margin-left: 10px;
    border-left: 1px solid var(--secondary-bg-color);
    padding-left: 10px;
    flex-direction: column;
    justify-content: space-around;
}

@media screen and (max-width: 1024px) {
    .content__item {
        max-width: 680px;
        flex-direction: column;
    }

    .item__details {
        flex: 1;
        width: 100%;
    }

    .item__charts {
        flex: 1;
        width: 100%;
        padding-left: 0;
        margin-left: 0;
        border-left: none;
    }

    .chart-wrapper {
        min-height: 350px;
        margin-top: 20px;
    }
}
</style>