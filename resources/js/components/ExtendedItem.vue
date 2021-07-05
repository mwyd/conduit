<template>
    <div 
        v-if="item"
        class="d-flex flex-jc-c flex-ai-c w-100 wrapper"
    >
        <div class="content__item padding-m rounded-s d-flex">
            <base-item 
                class="item__details padding-clear"
                :style="{ padding: 0 }"
                :item="item"
            ></base-item>
            <div class="item__charts d-flex">
                <canvas ref="priceChart"></canvas>
                <canvas ref="sellChart"></canvas>
            </div>
        </div>
    </div>
    <app-not-found v-else-if="itemLoaded"></app-not-found>
    <app-loader v-else></app-loader>
</template>

<script>
import { mapGetters } from 'vuex'
import { setDocumentTitle } from '../helpers'
import Chart from 'chart.js/auto'
import BaseItem from '../components/BaseItem'
import AppNotFound from './AppNotFound.vue'
import AppLoader from './AppLoader'

export default {
    name: 'ExtendedItem',
    components: {
        BaseItem,
        AppNotFound,
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
            dateZero: '2021-05-01',
            fetchDelay: 1000,
            charts: {
                priceTrend: null,
                sellTrend: null
            }
        }
    },
    computed: {
        ...mapGetters({
            conduitApiUrl: 'app/conduitApiUrl'
        })
    },
    methods: {
        async loadItem() {
            await new Promise(r => setTimeout(r, this.fetchDelay))

            try {
                const response = await axios.get(this.conduitApiUrl('SHADOWPAY_SOLD_ITEMS'), {params: {
                    search: this.hashName,
                    limit: 1,
                    date_start: this.dateZero
                }})

                const {success, data} = response.data

                if(success && data?.length > 0) {
                    setDocumentTitle(`Conduit - ${this.hashName}`)
                    this.item = data[0]
                    this.loadTrend()
                }
                else {
                    
                }
            }
            catch(err) {
                console.log(err)
            }

            this.itemLoaded = true
        },
        initChartDefaults() {
            Chart.defaults.color = '#cbd5e0'
            Chart.defaults.plugins.legend.position = 'bottom'
            Chart.defaults.plugins.title = Object.assign(Chart.defaults.plugins.title, {
                display: true,
                align: 'start',
                font: {
                    size: 16,
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
                const response = await axios.get(`${this.conduitApiUrl('SHADOWPAY_SOLD_ITEMS')}/${this.item.hash_name}/trend`)
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
                }

                this.createPriceTrendChart(labels, shadowpayPrices, steamPrices)
                this.createSellTrendChart(labels, shadowpaySold)
            }
            catch(err) {
                console.log(err)
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
    },
    created() {
        this.initChartDefaults()
        this.loadItem()
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
    overflow-x: auto;
}

.item__details {
    flex: 0 0 300px;
}

.item__charts {
    margin-left: 10px;
    min-width: 680px;
    border-left: 1px solid var(--secondary-bg-color);
    padding-left: 10px;
    flex-direction: column;
    justify-content: space-around;
}
</style>