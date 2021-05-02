import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import auth from './modules/auth';
import notice from './modules/notice'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        notice,
    },
    plugins: [createPersistedState()],
});
