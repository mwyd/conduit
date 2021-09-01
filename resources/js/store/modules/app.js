export default {
    namespaced: true,
    state: () => ({
        currency: { iso: 'USD', ratio: 1, symbol: '$' },
        currencies: [
            { iso: 'USD', ratio: 1, symbol: '$' },
            { iso: 'PLN', ratio: null, symbol: 'zł' }
        ],
        conduit: {
            apiUrl: '/api/v1',
            apiEndpoints: Object.freeze({
                SHADOWPAY_SOLD_ITEMS: '/shadowpay-sold-items'
            })
        },
        steam: {
            csgoMarketItemUrl: 'https://steamcommunity.com/market/listings/730',
            marketItemImgUrl: 'https://community.cloudflare.steamstatic.com/economy/image'
        },
        shadowpay: {
            websiteUrl: 'https://shadowpay.com'
        }
    }),
    getters: {
        conduitApiUrl: state => endpoint => {
            return state.conduit.apiUrl + state.conduit.apiEndpoints[endpoint]
        }
    },
    mutations: {
        setCurrency(state, currency) {
            state.currency = currency
        }
    },
    actions: {
        setup({ dispatch }) {
            dispatch('loadCurrency')
        },
        async loadCurrency({ commit, state }) {
            const iso = localStorage.getItem('currency')

            let currency = state.currencies.find(e => e.iso == iso)

            if(!currency) return

            switch(iso) {
                case 'PLN':
                        try {
                            const response = await fetch('https://api.nbp.pl/api/exchangerates/rates/A/USD?format=json')
                            const { rates } = await response.json()

                            currency.ratio = rates[0].mid
                        }
                        catch(err) {
                            currency = state.currencies[0]
                            console.log(err)
                        }
                    break
            }

            commit('setCurrency', currency)
        },
        updateCurrency({ dispatch }, iso) {
            localStorage.setItem('currency', iso)

            dispatch('loadCurrency')
        }
    }
}