<template>
    <div 
        class="content__item padding-m rounded-s d-flex"
        :class="{ 'content__item--active': showMore }"
    >
        <div class="item__wrapper p-relative">
            <div 
                class="item__more-btn p-absolute cursor-pointer"
                @click="toggleShowMore"
            ></div>
            <div class="item__ext">{{ isStattrak ? 'ST | ' + shortExterior : shortExterior }}</div>
            <div class="item__img-wrapper">
                <img class="item__img" :src="item?.steam_market_csgo_item?.icon ? `${marketItemImgUrl}/${item.steam_market_csgo_item.icon}/360fx360f` : dota2ImgPlaceholder">
            </div>
            <div class="item__type">{{ itemType }}</div>
            <div class="item__name">{{ itemName }}</div>
            <table class="item__stats">
                <caption class="stats__title"><a :href="shadowpayWebsiteUrl" target="_blank" class="link">Shadowpay</a></caption>
                <tr>
                    <td class="stats__name">Sold</td>
                    <td class="stats__value">{{ item.sold }}</td>
                </tr>
                <tr>
                    <td class="stats__name">Avg discount</td>
                    <td class="stats__value">{{ item.avg_discount.toFixed(2) + ' %' }}</td>
                </tr>
                <tr>
                    <td class="stats__name">Avg sell price</td>
                    <td class="stats__value">{{ realSellPrice ? realSellPrice.toFixed(2) + ' $' : '-' }}</td>
                </tr>
                <tr>
                    <td class="stats__name">Avg suggested price</td>
                    <td class="stats__value">{{ item.avg_suggested_price ? item.avg_suggested_price.toFixed(2) + ' $' : '-' }}</td>
                </tr>
                <tr>
                    <td class="stats__name">Last sold at</td>
                    <td class="stats__value">{{ item.last_sold }}</td>
                </tr>
            </table>
            <table class="item__stats">
                <caption class="stats__title"><a :href="`${csgoMarketItemUrl}/${item.hash_name}`" target="_blank" class="link">Steam</a></caption>
                <tr>
                    <td class="stats__name">Volume</td>
                    <td class="stats__value">{{ item?.steam_market_csgo_item?.volume ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="stats__name">Current price</td>
                    <td class="stats__value">{{ item?.steam_market_csgo_item?.price ? item.steam_market_csgo_item.price.toFixed(2) + ' $' : '-' }}</td>
                </tr>
                <tr>
                    <td class="stats__name">Avg price</td>
                    <td class="stats__value">{{ item.avg_steam_price ? item.avg_steam_price.toFixed(2) + ' $' : '-' }}</td>
                </tr>
                <tr>
                    <td class="stats__name">Profitability ratio</td>
                    <td class="stats__value">{{ realSellPrice && item?.steam_market_csgo_item?.price ? (realSellPrice / item.steam_market_csgo_item.price).toFixed(2) : '-' }}</td>
                </tr>
                <tr>
                    <td class="stats__name">Updated at</td>
                    <td class="stats__value">{{ item?.steam_market_csgo_item?.updated_at ? item.steam_market_csgo_item.updated_at : '-' }}</td>
                </tr>
            </table>
        </div>
        <div 
            v-show="showMore"
            class="item__charts d-flex"
        >
            <canvas ref="priceChart"></canvas>
            <canvas ref="sellChart"></canvas>
        </div>
    </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import Chart from 'chart.js/auto'

export default {
    name: 'Item',
    props: {
        item: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            mutableHashName: this.item.hash_name,
            exteriors: Object.freeze({
                FN: '(Factory New)',
                MW: '(Minimal Wear)',
                FT: '(Field-Tested)',
                BS: '(Battle-Scarred)',
                WW: '(Well-Worn)',
                FOIL: '(Foil)',
                HOLO: '(Holo)'
            }),
            shortExterior: '',
            isStattrak: false,
            itemType: '',
            itemName: '',
            realSellPrice: null,
            showMore: false,
            trendLoaded: false,
            charts: {
                priceTrend: null,
                sellTrend: null
            }
        }
    },
    computed: {
        ...mapState({
            marketItemImgUrl: state => state.app.steam.marketItemImgUrl,
            csgoMarketItemUrl: state => state.app.steam.csgoMarketItemUrl,
            dota2ImgPlaceholder: state => state.app.steam.dota2ImgPlaceholder,
            shadowpayWebsiteUrl: state => state.app.shadowpay.websiteUrl
        }),
        ...mapGetters({
            conduitApiUrl: 'app/conduitApiUrl'
        })
    },
    methods: {
        reduceHashName(value) {
            if(this.mutableHashName.search(value) > -1) {
                this.mutableHashName = this.mutableHashName.replace(value, '')
                return true
            }

            return false
        },
        unpackHashName() {
            if(this.reduceHashName('StatTrak™ ')) this.isStattrak = true

            for(let pair of Object.entries(this.exteriors)) {
                if(this.reduceHashName(pair[1])) {
                    this.shortExterior = pair[0]
                    break
                }
            }

            const itemTypeName = this.mutableHashName.split('|')

            this.itemType = itemTypeName[0]
            this.itemName = itemTypeName[1]
        },
        getRealSellPrice() {
            if(this.item.avg_suggested_price) this.realSellPrice = this.item.avg_suggested_price * (100 - this.item.avg_discount) / 100
        },
        toggleShowMore() {
            if(!this.showMore) {
                this.showMore = true
                this.loadTrend()
            }
            else this.showMore = false
        },
        async loadTrend() {
            if(this.trendLoaded) return

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
        }
    },
    created() {
        this.unpackHashName()
        this.getRealSellPrice()
        this.initChartDefaults()
    }
}
</script>

<style scoped>
.content__item {
    background-color: var(--alt-bg-color);
    width: 320px;
    min-height: 400px;
    color: var(--alt-text-color);
    overflow-x: auto;
}

.content__item--active {
    width: 100%;
}

.item__wrapper {
    flex: 0 0 300px;
}

.item__more-btn {
    background-image: url('../../img/more.png');
    background-size: 100%;
    right: 0;
    top: 0;
    height: 20px;
    width: 20px;
}

.item__ext {
    height: 16px;
    line-height: 100%;
    font-size: 14px;
    font-weight: bold;
}

.item__img-wrapper {
    text-align: center;
    height: 200px;
}

.item__img {
    height: 100%;
    background-image: radial-gradient(var(--secondary-bg-color), transparent 70%);
}

.item__type {
    font-size: 16px;
    line-height: 100%;
    height: 18px;
}

.item__name {
    font-weight: bold;
    color: var(--main-text-color);
    font-size: 18px;
    line-height: 100%;
    height: 20px;
}

.item__stats {
    width: 100%;
    font-size: 14px;
    border-collapse: collapse;
    margin-top: 20px;
}

.item__stats td {
    border-bottom: 1px solid var(--secondary-bg-color);
    padding: 8px 0px;
}

.item__stats tr:last-child td {
    border-bottom: none;
}

.stats__title {
    text-align: left;
    padding: 4px 0;
    font-weight: bold;
}

.stats__name {
    text-align: left;
}

.stats__value {
    text-align: right;
    color: var(--main-text-color);
}

.item__charts {
    margin-left: 10px;
    width: 100%;
    min-width: 680px;
    border-left: 1px solid var(--secondary-bg-color);
    padding-left: 10px;
    flex-direction: column;
    justify-content: space-around;
}
</style>