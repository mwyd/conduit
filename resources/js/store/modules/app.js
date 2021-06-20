export default {
    namespaced: true,
    state: () => ({
        conduit: {
            apiUrl: 'http://localhost:8000/api',
            apiEndpoints: Object.freeze({
                SHADOWPAY_SOLD_ITEMS: '/shadowpay-sold-items'
            })
        },
        steam: {
            csgoMarketItemUrl: 'https://steamcommunity.com/market/listings/730',
            marketItemImgUrl: 'https://community.cloudflare.steamstatic.com/economy/image',
            dota2ImgPlaceholder: 'https://community.cloudflare.steamstatic.com/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KW1Zwwo4NUX4oFJZEHLbXP7g1bJ4Q1lgheXknVSffi0MPSUFR1KTtDs6i3JBVf3_zJdTRM6-Oll5KOkvnLP7rDkW4fv5Yh3biVot2t3APm-UVsMmCmdofGdAM3NQrS-VK7xufog5S-6p2czWwj5HfFbDKgOw/360fx360f'
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