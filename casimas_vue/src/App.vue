<template>
    <div id="app">
        <router-view />
    </div>
</template>

<style>
html {
    font-size: 12px !important;
}
body {
    background-color: rgb(247, 247, 248) !important;
}
.area {
    background-color: white !important;
}
.heder-content {
    width: 100% !important;
}
.footer-menu__content {
    width: 100% !important;
}
.user-content {
    margin-top: 30px !important;
}
@media screen and (min-width: 990px) {
    html {
        font-size: 14px !important;
    }
    .heder-content {
        width: 75% !important;
    }
    .footer-menu__content {
        width: 75% !important;
    }
    .user-content {
        width: 75% !important;
        margin: 0 auto !important;
        margin-top: 50px !important;
    }
}
#app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
}

#nav {
    padding: 30px;
}

#nav a {
    font-weight: bold;
    color: #42b983;
}

#nav a.router-link-exact-active {
    color: #2c3e50;
}
</style>
