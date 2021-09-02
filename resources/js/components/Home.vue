<template>
    <div class="home w-100">
        <div class="home__top-bar p-fixed padding-m w-100">
            <div class="top-bar__search p-relative">
                <app-input
                    v-model="search"
                    :type="'text'"
                    :placeholder="'Item name...'"
                >
                </app-input>
                <button 
                    class="clear-filters p-absolute cursor-pointer"
                    @click="$router.push({query: {}})"
                >
                </button>
            </div>
            <div 
                class="top-bar__filters-button padding-m cursor-pointer"
                :class="{'top-bar__filters-button--active': showFilters}"
                @click="showFilters = !showFilters"
            >
            </div>
            <div 
                v-if="showFilters"
                class="top-bar__filters d-grid rounded-s padding-m"
            >
                <div class="filters__filter">
                    <label class="d-block">Sort</label>
                    <div class="filters__input-pair filters__sort-pair d-grid">
                        <select 
                            v-model="order_by"
                            class="filters__select app-input__field app-input__field--idle padding-m"
                        >
                            <option 
                                v-for="(sort, index) in sorts"
                                :key="`${sort.name}-${index}`"
                                :value="sort.value"
                            >
                                {{ sort.name }} 
                            </option>
                        </select>
                        <button 
                            class="filters__sort-dir app-input__field--idle rounded-s cursor-pointer"
                            :class="{'filters__sort-dir--asc': order_dir == 'asc'}"
                            @click="updateSortDir"
                        >
                        </button>
                    </div>
                </div>
                <div class="filters__filter">
                    <label class="d-block">Date</label>
                    <div class="filters__input-pair d-grid">
                        <app-input
                            v-model="date_start"
                            :type="'date'"
                            :validator="value => dateDiff(value, date_end, 'days') <= 0"
                        >
                        </app-input>
                        <app-input
                            v-model="date_end"
                            :type="'date'"
                            :validator="value => dateDiff(value, date_start, 'days') >= 0"
                        >
                        </app-input>
                    </div>
                </div>
                <div class="filters__filter">
                    <label class="d-block">{{ currency.symbol }} Price</label>
                    <div class="filters__input-pair d-grid">
                        <app-input
                            v-model.number="price_from"
                            :type="'number'"
                            :validator="value => value >= 0 && value <= price_to"
                        >
                        </app-input>
                        <app-input
                            v-model.number="price_to"
                            :type="'number'"
                            :validator="value => value > price_from"
                        >
                        </app-input>
                    </div>
                </div>
                <div class="filters__filter">
                    <label class="d-block">Sold</label>
                    <div class="filters__input-pair d-grid">
                        <app-input
                            v-model.number="min_sold"
                            :type="'number'"
                            :validator="value => value >= 0 && value <= max_sold"
                        >
                        </app-input>
                        <app-input
                            v-model.number="max_sold"
                            :type="'number'"
                            :validator="value => value >= min_sold"
                        >
                        </app-input>
                    </div>
                </div>
                <div class="filters__filter">
                    <label class="d-block">Exterior</label>
                    <div class="filters__input-pair d-grid">
                        <select 
                            v-model="exteriors"
                            class="filters__select app-input__field app-input__field--idle padding-m"
                        >
                            <option 
                                v-for="(exterior, index) in exteriorsFilters"
                                :key="`exterior-${exterior.value}-${index}`"
                                :value="exterior.value"
                            >
                                {{ exterior.name }} 
                            </option>
                        </select>
                        <select 
                            v-model="is_stattrak"
                            class="filters__select app-input__field app-input__field--idle padding-m"
                        >
                            <option 
                                v-for="(stattrak, index) in stattrakFilters"
                                :key="`stattrak-${stattrak.value}-${index}`"
                                :value="stattrak.value"
                            >
                                {{ stattrak.name }} 
                            </option>
                        </select>
                    </div>
                </div>
                <div class="filters__filter">
                    <label class="d-block">Currency</label>
                    <select 
                        class="filters__select app-input__field app-input__field--idle padding-m w-100"
                        v-model="currencyModel"
                    >
                        <option 
                            v-for="currency in currencies"
                            :key="`currency-${currency.iso}}`"
                            :value="currency.iso"
                        >
                            {{ currency.iso + ' - ' + currency.symbol }} 
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="home__content d-flex flex-jc-c">
            <base-item
                v-for="(item, index) in items"
                :key="`${item.hash_name}-${index}`"
                :item="item"
            >
            </base-item>
        </div>
        <app-loader v-if="!contentLoaded"></app-loader>
    </div>
</template>

<script>
import { dateDiff, setDocumentTitle, formatPrice } from '../helpers'
import { mapState, mapGetters, mapActions } from 'vuex'
import AppInput from './ui/AppInput'
import AppLoader from './ui/AppLoader'
import BaseItem from './BaseItem'
import itemFiltersMixin from '../mixins/itemFiltersMixin'

export default {
    name: 'Home',
    components: {
        AppInput,
        AppLoader,
        BaseItem
    },
    mixins: [itemFiltersMixin],
    data() {
        return {
            contentLoaded: false,
            showFilters: false,
            items: [],
            gotAll: false,
            offset: 0,
            limit: 50
        }
    },
    computed: {
        ...mapState({
            currency: state => state.app.currency,
            currencies: state => state.app.currencies
        }),
        ...mapGetters({
            conduitApiUrl: 'app/conduitApiUrl'
        }),
        currencyModel: {
            get() {
                return this.currency.iso
            },
            set(value) {
                this.updateCurrency(value)
            }
        }
    },
    watch: {
        $route(to) {
            if(to.name == 'Home') this.fetchItems()
        }
    },
    beforeMount() {
        this.addScrollEvent()
    },
    mounted() {
        setDocumentTitle('Conduit')
        this.fetchItems()
    },
    beforeUnmount() {
        this.removeScrollEvent()
    },
    methods: {
        dateDiff,
        ...mapActions({
            updateCurrency: 'app/updateCurrency'
        }),
        scrollEvent() {
            if(Math.ceil(window.innerHeight + window.scrollY) + 2 >= document.body.scrollHeight && this.contentLoaded) this.fetchItems(true)
        },
        addScrollEvent() {
            window.addEventListener('scroll', this.scrollEvent)
        },
        removeScrollEvent() {
            window.removeEventListener('scroll', this.scrollEvent)
        },
        async fetchItems(append = false) {
            let params = { ...this.$route.query }

            let callback = items => {
                window.scrollTo(0, 0)
                this.items = items
            }

            if(params.price_from) {
                params.price_from = formatPrice(params.price_from / this.currency.ratio)
            }

            if(params.price_to) {
                params.price_to = formatPrice(params.price_to / this.currency.ratio)
            }

            if(append) {
                if(this.gotAll) return

                this.offset += this.limit
                params.offset = this.offset

                callback = items => this.items.push(...items)
            }
            else {
                this.gotAll = false
                this.offset = 0
            }

            this.contentLoaded = false

            try {
                const response = await axios.get(this.conduitApiUrl('SHADOWPAY_SOLD_ITEMS'), {params: params})
                const { success, data } = response.data

                if(success) {
                    callback(data)
                    if(data.length < this.limit) this.gotAll = true
                }
            }
            catch(err) {
                console.log(err?.message)
            }

            this.contentLoaded = true
        }
    }
}
</script>

<style scoped>
.home__top-bar {
    background-color: var(--main-bg-color);
}

.top-bar__search, .top-bar__filters {
    max-width: 1024px;
    margin: 0 auto;
}

.clear-filters {
    background-image: url('../../img/close.png');
    background-size: 25%;
    background-repeat: no-repeat;
    background-position: center;
    background-color: transparent;
    height: 40px;
    width: 40px;
    top: 0;
    right: 0;
    border: none;
    outline: none;
}

.top-bar__filters {
    grid-template-columns: 2fr 2fr;
    grid-gap: 10px;
    background-color: var(--secondary-bg-color);
    max-height: 70vh;
    overflow: auto;
}

.top-bar__filters-button {
    margin: 0 auto;
    width: 80px;
    height: 40px;
    background-image: url('../../img/arrow.png');
    background-size: 15%;
    background-position: center;
    background-repeat: no-repeat;
}

.top-bar__filters-button--active {
    transform: rotateX(180deg);
}

.filters__filter {
    padding-bottom: 10px;
}

.filters__filter > label {
    padding-bottom: 4px;
    color: var(--alt-text-color);
    font-weight: bold;
}

.filters__input-pair {
    grid-template-columns: 1fr 1fr;
    grid-gap: 10px;
}

.filters__sort-pair {
    grid-template-columns: 1fr 40px;
}

.filters__select {
    background-color: var(--alt-bg-color);
    color: var(--alt-text-color);
}

.filters__sort-dir {
    height: 40px;
    width: 40px;
    background-color: var(--alt-bg-color);
    background-image: url('../../img/arrow.png');
    background-size: 25%;
    background-repeat: no-repeat;
    background-position: center;
}

.filters__sort-dir--asc {
    transform: rotateX(180deg);
}

.home__content {
    max-width: 1024px;
    margin: 0 auto;
    padding-top: 100px;
    padding-bottom: 20px;
    grid-gap: 20px;
    flex-wrap: wrap;
}

@media (max-width: 768px) {
    .top-bar__filters {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 320px) {
    .filters__input-pair {
        grid-template-columns: 1fr;
    }
}
</style>