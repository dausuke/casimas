import Vue from 'vue';
import VueRouter from 'vue-router';
import topPage from '../views/topPage';
import login from '../views/login';
import register from '../views/register';

//ログイン後ページ
import Home from '../views/after_login/home';
import rule from '../views/after_login/rule';
import sell from '../views/after_login/sell';
import MyPage from '../views/after_login/mypage';
import notice from '../views/after_login/notice';
import item from '../components/after_login/item';
import category from '../views/after_login/category';

//マイページ内
import profile from '../components/after_login/profile';
import account from '../components/after_login/account';
import itemSelling from '../components/after_login/itemSelling';
import itemIsRental from '../components/after_login/itemIsRental';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'top',
        component: topPage,
    },
    {
        path: '/login',
        name: 'login',
        component: login,
    },
    {
        path: '/register',
        name: 'register',
        component: register,
    },
    //ログイン後
    {
        //ホーム
        path: '/Home',
        name: 'Home',
        component: Home,
    },
    {
        //ルール
        path: '/rule',
        name: 'rule',
        component: rule,
    },
    {
        //出品
        path: '/sell',
        name: 'sell',
        component: sell,
    },
    {
        //マイページ
        path: '/MyPage',
        name: 'MyPage',
        component: MyPage,
    },
    {
        //カテゴリー
        path: '/category',
        name: 'category',
        component: category,
    },
    {
        //通知
        path: '/notice',
        name: 'notice',
        component: notice,
    },
    {
        //商品ページ
        path: '/item',
        name: 'item',
        component: item,
    },

    //マイページ内
    {
        path: '/profile',
        name: 'profile',
        component: profile,
    },
    {
        path: '/account',
        name: 'account',
        component: account,
    },
    {
        path: '/itemSelling',
        name: 'itemSelling',
        component: itemSelling,
    },
    {
        path: '/itemIsRental',
        name: 'itemIsRental',
        component: itemIsRental,
    },
];

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes,
});

export default router;
