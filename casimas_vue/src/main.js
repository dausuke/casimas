import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import BootstrapVue from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import axios from 'axios';
import VueAxios from 'vue-axios';

import { extend, ValidationProvider, ValidationObserver } from 'vee-validate';
import { required, email, min, max, numeric, oneOf, regex } from 'vee-validate/dist/rules';

// バリデーションルール
extend('required', { ...required, message: '必須項目です' });
extend('email', { ...email, message: 'メールアドレスの形式が違います' });
extend('min', { ...min, message: '指定文字数で入力してください' });
extend('max', { ...max, message: '指定文字数で入力してください' });
extend('numeric', { ...numeric, message: '半角数字で入力してください' });
extend('oneOf', { ...oneOf, message: '選択項目から選択してください' });
extend('regex', { ...regex, message: '入力できるのは半角英数記号のみです' });

Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);

Vue.use(BootstrapVue);
Vue.use(VueAxios, axios);
Vue.config.productionTip = false;

new Vue({
    router,
    store,
    render: h => h(App),
}).$mount('#app');
