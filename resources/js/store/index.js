import { createStore } from "vuex"
import appModule from './modules/app'

const store = createStore({
    modules: {
        app: appModule
    }
})

export default store