<template>
    <div class="header area">
        <div class="container-fluid heder-content">
            <header class="row w-100 m-0 align-items-center justify-content-center">
                <div class="row w-100">
                    <logo class="col-5"></logo>
                    <div class="d-flex align-items-center justify-content-end col-7">
                        <p class="m-0" @click="logout">ログアウト</p>
                    </div>
                </div>
                <div class="row w-100">
                    <router-link to="/category" class="my-lg-3 my-1 ml-3">カテゴリーから探す</router-link>
                </div>
            </header>
        </div>
    </div>
</template>
<script>
import logo from './logo';
export default {
    components: {
        logo,
    },
    methods: {
        logout: function() {
            if (confirm('ログアウトしますか？')) {
                localStorage.removeItem('vuex')
                this.$store.commit('auth/logout');
                this.$store.commit('notice/logout');
                this.$router.push({ name: 'top' });
            }
        },
    },
};
</script>
<style scoped>
.header {
    width: 100%;
    box-shadow: rgb(0 0 0 / 18%) 0px 2px 4px;
}
.header-area {
    margin: 0 auto;
}
a {
    color: black;
}
a:hover {
    color: black;
    text-decoration: none;
}
</style>
