<template>
    <div class="content__item padding-m rounded-s">
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
                <td class="stats__value">{{ item.avg_sell_price ? item.avg_sell_price.toFixed(2) + ' $' : '-' }}</td>
            </tr>
            <tr>
                <td class="stats__name">Last sold at</td>
                <td class="stats__value">{{ moment(item.last_sold).format('YYYY-MM-DD H:mm:ss') }}</td>
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
                <td class="stats__value">{{ item?.steam_market_csgo_item?.updated_at ? moment(item.steam_market_csgo_item.updated_at).format('YYYY-MM-DD H:mm:ss') : '-' }}</td>
            </tr>
        </table>
    </div>
</template>

<script>
import moment from 'moment'
import { mapState } from 'vuex'

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
            realSellPrice: null
        }
    },
    computed: {
        ...mapState({
            marketItemImgUrl: state => state.app.steam.marketItemImgUrl,
            csgoMarketItemUrl: state => state.app.steam.csgoMarketItemUrl,
            dota2ImgPlaceholder: state => state.app.steam.dota2ImgPlaceholder,
            shadowpayWebsiteUrl: state => state.app.shadowpay.websiteUrl
        })
    },
    methods: {
        moment,
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
            if(this.item.avg_sell_price) this.realSellPrice = this.item.avg_sell_price * (100 - this.item.avg_discount) / 100
        }
    },
    created() {
        this.unpackHashName()
        this.getRealSellPrice()
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
</style>