<template>
    <div class="header">
        <div class="container">
            <div>
                <header class="row">
                    <router-link to="/" class="col-4 d-flex align-items-center"
                        ><h1 class="m-0">CASIMAS</h1></router-link
                    >
                    <div id="nav" class="col-8">
                        <div class="d-flex justify-content-end">
                            <router-link to="/login">ログイン</router-link> |
                            <router-link to="/register">新規登録</router-link>
                        </div>
                    </div>
                </header>
            </div>
        </div>
    </div>
</template>
<style scoped>
.header {
    width: 100%;
}
a {
    color: black;
}
a:hover {
    color: black;
    text-decoration: none;
}
#nav a{
    margin: 0 10px 0 10px;
}
</style>
