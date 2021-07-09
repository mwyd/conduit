<template>
    <div class="home w-100">
        <div class="home__top-bar p-fixed padding-m w-100">
            <div class="top-bar__search p-relative">
                <app-input
                    v-model="search"
                    :type="'text'"
                    :placeholder="'Item name...'"
                ></app-input>
                <button 
                    class="clear-filters p-absolute cursor-pointer"
                    @click="$router.push({query: {}})"
                ></button>
            </div>
            <div 
                class="top-bar__filters-button padding-m cursor-pointer"
                :class="{'top-bar__filters-button--active': showFilters}"
                @click="showFilters = !showFilters"
            ></div>
            <div 
                v-if="showFilters"
                class="top-bar__filters d-grid rounded-s padding-m"
            >
                <div class="filters__filter">
                    <label class="d-block">Sort</label>
                    <div class="filters__input-pair filters__sort-pair d-grid">
                        <select 
                            v-model="order_by"
                            class="filters__sort-select rounded-s app-input__field app-input__field--idle padding-m"
                            @change="fetchItems"
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
                        ></app-input>
                        <app-input
                            v-model="date_end"
                            :type="'date'"
                            :validator="value => dateDiff(value, date_start, 'days') >= 0"
                        ></app-input>
                    </div>
                </div>
                <div class="filters__filter">
                    <label class="d-block">$ Price</label>
                    <div class="filters__input-pair d-grid">
                        <app-input
                            v-model.number="price_from"
                            :type="'number'"
                            :validator="value => value >= 0 && value <= price_to"
                        ></app-input>
                        <app-input
                            v-model.number="price_to"
                            :type="'number'"
                            :validator="value => value >= price_from"
                        ></app-input>
                    </div>
                </div>
                <div class="filters__filter">
                    <label class="d-block">Sold</label>
                    <div class="filters__input-pair d-grid">
                        <app-input
                            v-model.number="min_sold"
                            :type="'number'"
                            :validator="value => value >= 0 && value <= max_sold"
                        ></app-input>
                        <app-input
                            v-model.number="max_sold"
                            :type="'number'"
                            :validator="value => value >= min_sold"
                        ></app-input>
                    </div>
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
import { appendUrlParam, dateDiff, setDocumentTitle } from '../helpers'
import { mapState, mapGetters } from 'vuex'
import moment from 'moment'
import AppInput from './AppInput'
import AppLoader from './AppLoader'
import BaseItem from './BaseItem'

export default {
    name: 'Home',
    components: {
        AppInput,
        AppLoader,
        BaseItem
    },
    data() {
        return {
            sorts: [
                {name: 'Item name', value: 'hash_name'},
                {name: 'Sold', value: 'sold'},
                {name: 'Avg discount', value: 'avg_discount'},
                {name: 'Avg shadowpay price', value: 'avg_suggested_price'},
                {name: 'Avg steam price', value: 'avg_steam_price'},
                {name: 'Sold at', value: 'last_sold'}
            ],
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
            fetchDelay: state => state.app.fetchDelay
        }),
        ...mapGetters({
            conduitApiUrl: 'app/conduitApiUrl'
        }),
        search: {
            get() {
                return this.$route.query.search ?? ''
            },
            set(value) {
                appendUrlParam({search: value})
            }
        },
        price_from: {
            get() {
                return this.$route.query.price_from ?? 0
            },
            set(value) {
                appendUrlParam({price_from: value})
            }
        },
        price_to: {
            get() {
                return this.$route.query.price_to ?? 10000
            },
            set(value) {
                appendUrlParam({price_to: value})
            }
        },
        min_sold: {
            get() {
                return this.$route.query.min_sold ?? 0
            },
            set(value) {
                appendUrlParam({min_sold: value})
            }
        },
        max_sold: {
            get() {
                return this.$route.query.max_sold ?? 10000
            },
            set(value) {
                appendUrlParam({max_sold: value})
            }
        },
        date_start: {
            get() {
                return this.$route.query.date_start ?? moment().subtract(7, 'days').format('YYYY-MM-DD')
            },
            set(value) {
                appendUrlParam({date_start: value})
            }
        },
        date_end: {
            get() {
                return this.$route.query.date_end ?? moment().format('YYYY-MM-DD')
            },
            set(value) {
                appendUrlParam({date_end: value})
            }
        },
        order_by: {
            get() {
                return this.$route.query.order_by ?? 'sold'
            },
            set(value) {
                appendUrlParam({order_by: value})
            }
        },
        order_dir: {
            get() {
                return this.$route.query.order_dir ?? 'desc'
            },
            set(value) {
                appendUrlParam({order_dir: value})
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
        scrollEvent() {
            if((window.innerHeight + window.scrollY) >= document.body.scrollHeight && this.contentLoaded) this.fetchItems(true)
        },
        addScrollEvent() {
            window.addEventListener('scroll', this.scrollEvent)
        },
        removeScrollEvent() {
            window.removeEventListener('scroll', this.scrollEvent)
        },
        updateSortDir() {
            if(this.order_dir == 'asc') this.order_dir = 'desc'
            else this.order_dir = 'asc'

            this.fetchItems()
        },
        async fetchItems(append = false) {
            let params = this.$route.query
            let callback = items => {
                window.scrollTo(0, 0)
                this.items = items
            }

            if(append) {
                if(this.gotAll) return

                this.offset += this.limit
                params = {...params, offset: this.offset}
                callback = items => this.items.push(...items)
            }
            else {
                this.gotAll = false
                this.offset = 0
            }

            this.contentLoaded = false

            await new Promise(r => setTimeout(r, this.fetchDelay))

            try {
                const response = await axios.get(this.conduitApiUrl('SHADOWPAY_SOLD_ITEMS'), {params: params})
                const {success, data} = response.data

                if(success) {
                    callback(data)
                    if(data.length < this.limit) this.gotAll = true
                }
            }
            catch(err) {
                console.log(err)
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

.filters__sort-select {
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
    padding-top: 101px;
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