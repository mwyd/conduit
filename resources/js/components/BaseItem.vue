<template>
    <div class="content__item padding-m rounded-s">
        <div class="item__ext d-flex">
            <div v-html="itemExterior"></div>
            <div 
                class="ext__color rounded-s"
                :style="{ 'backgroundColor': item.steam_market_csgo_item?.type_color }"
            >
            </div>
        </div>
        <div class="item__img-wrapper">
            <img 
                class="item__img h-100"
                v-if="item.steam_market_csgo_item" 
                :src="itemImage"
            >
            <img
                class="item__img h-100"
                src="../../img/placeholder-image.png"
                v-else
            >
        </div>
        <router-link 
            class="link" 
            :to="{ name: 'Item', params: { 'hashName': item.hash_name } }"
        >
            <div class="item__type overflow-text">{{ itemType }}</div>
            <div class="item__name overflow-text">{{ itemName }}</div>
        </router-link>
        <table class="item__stats w-100">
            <caption class="stats__title">
                <a 
                    :href="shadowpayItemUrl" 
                    target="_blank" 
                    class="link"
                >
                    Shadowpay
                </a>
            </caption>
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
                <td class="stats__value">{{ realSellPrice ? exchangePrice(realSellPrice) : '-' }}</td>
            </tr>
            <tr>
                <td class="stats__name">Avg suggested price</td>
                <td class="stats__value">{{ item.avg_suggested_price ? exchangePrice(item.avg_suggested_price) : '-' }}</td>
            </tr>
            <tr>
                <td class="stats__name">Last sold at</td>
                <td class="stats__value">{{ item.last_sold }}</td>
            </tr>
        </table>
        <table class="item__stats w-100">
            <caption class="stats__title">
                <a 
                    :href="steamItemUrl" 
                    target="_blank" 
                    class="link"
                >
                    Steam
                </a>
            </caption>
            <tr>
                <td class="stats__name">Volume</td>
                <td class="stats__value">{{ item.steam_market_csgo_item?.volume ?? '-' }}</td>
            </tr>
            <tr>
                <td class="stats__name">Current price</td>
                <td class="stats__value">{{ item.steam_market_csgo_item?.price ? exchangePrice(item.steam_market_csgo_item.price) : '-' }}</td>
            </tr>
            <tr>
                <td class="stats__name">Avg price</td>
                <td class="stats__value">{{ item.avg_steam_price ? exchangePrice(item.avg_steam_price) : '-' }}</td>
            </tr>
            <tr>
                <td class="stats__name">Profitability ratio</td>
                <td class="stats__value">{{ realSellPrice && item.steam_market_csgo_item?.price ? (realSellPrice / item.steam_market_csgo_item.price).toFixed(2) : '-' }}</td>
            </tr>
            <tr>
                <td class="stats__name">Updated at</td>
                <td class="stats__value">{{ item.steam_market_csgo_item?.updated_at ? item.steam_market_csgo_item.updated_at : '-' }}</td>
            </tr>
        </table>
    </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'

export default {
    name: 'BaseItem',
    props: {
        item: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            marketHashName: '',
            itemType: '',
            itemName: '',
            realSellPrice: null
        }
    },
    computed: {
        ...mapState({
            currency: state => state.app.currency,
            marketItemImgUrl: state => state.app.steam.marketItemImgUrl,
            csgoMarketItemUrl: state => state.app.steam.csgoMarketItemUrl,
            shadowpayWebsiteUrl: state => state.app.shadowpay.websiteUrl
        }),
        ...mapGetters({
            conduitApiUrl: 'app/conduitApiUrl'
        }),
        itemExterior() {
            let exterior = ''

            if(this.item.steam_market_csgo_item?.is_stattrak) {
                exterior += `<span style="color: ${this.item.steam_market_csgo_item.name_color}">ST</span>`
            }

            if(this.item.steam_market_csgo_item?.exterior) {
                exterior += ` ${this.item.steam_market_csgo_item.exterior.toUpperCase()}`
            }

            return exterior
        },
        itemImage() {
            return `${this.marketItemImgUrl}/${this.item.steam_market_csgo_item.icon_large ?? this.item.steam_market_csgo_item.icon}/360fx360f`
        },
        shadowpayItemUrl() {
            return `${this.shadowpayWebsiteUrl}?search=${this.marketHashName}`
        },
        steamItemUrl() {
            return `${this.csgoMarketItemUrl}/${this.marketHashName}`
        }
    },
    created() {
        this.getMarketHashName()
        this.splitName()
        this.getRealSellPrice()
    },
    methods: {
        splitName() {
            const splitName = this.item.steam_market_csgo_item?.name 
                ? this.item.steam_market_csgo_item.name.split('|')
                : this.item.hash_name.split('|')

            this.itemType = splitName[0]
            this.itemName = splitName.slice(1).join('|')
        },
        getMarketHashName() {
            const phase = this.item.steam_market_csgo_item?.phase

            this.marketHashName = phase ? this.item.hash_name.replace(' ' + phase, '') : this.item.hash_name
        },
        getRealSellPrice() {
            if(this.item.avg_suggested_price) {
                this.realSellPrice = this.item.avg_suggested_price * (100 - this.item.avg_discount) / 100
            }
        },
        exchangePrice(price) {
            return `${(price * this.currency.ratio).toFixed(2)} ${this.currency.symbol}`
        }
    }
}
</script>

<style scoped>
.content__item {
    background-color: var(--alt-bg-color);
    width: 320px;
    min-height: 400px;
    color: var(--alt-text-color);
}

.item__ext {
    height: 16px;
    line-height: 100%;
    font-size: 14px;
    font-weight: bold;
    justify-content: space-between;
    align-items: flex-start;
}

.ext__color {
    height: 10px;
    width: 20px;
}

.item__img-wrapper {
    text-align: center;
    height: 200px;
}

.item__img {
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
</style>