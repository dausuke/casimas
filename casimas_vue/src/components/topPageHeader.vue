<template>
    <div class="header area">
        <div class="container">
            <header class="row align-items-center py-3">
                <logo class="col-5"></logo>
                <div id="nav" class="col-7 p-0">
                    <div class="d-flex justify-content-end">
                        <router-link to="/login">ログイン</router-link> |
                        <router-link to="/register">新規登録</router-link>
                    </div>
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
};
</script>
<style scoped>
.header {
    width: 100%;
    box-shadow: rgb(0 0 0 / 18%) 0px 2px 4px;
}
a {
    color: black;
}
a:hover {
    color: black;
    text-decoration: none;
}
#nav a {
    margin: 0 10px 0 10px;
}
.log h1 {
    font-size: 2rem;
}
</style>
