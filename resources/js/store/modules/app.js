export default {
    namespaced: true,
    state: () => ({
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
    mutations: {},
    actions: {}
}