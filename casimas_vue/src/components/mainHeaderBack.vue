<template>
    <div class="header area">
        <div class="container-fluid heder-content">
            <header class="row w-100 m-0 align-items-center justify-content-center">
                <div class="row w-100 justify-content-between">
                    <svg class="my-3 p-0 d-inline-flex justify-content-start" @click="back" width="35" height="35" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            class="text-left"
                            d="M24.9595 31.463L13.9595 20.463L24.9595 9.46295"
                            stroke="black"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                    <h1 class="m-0 py-3 px-0 text-center">CASIMAS</h1>
                    <div class="d-flex align-items-center justify-content-end p-0">
                        <p class="m-0" @click="logout">ログアウト</p>
                    </div>
                </div>
            </header>
        </div>
    </div>
</template>
<script>
export default {
    methods: {
        logout: function() {
            if (confirm('ログアウトしますか？')) {
                this.$store.commit('auth/logout');
                this.$router.push({ name: 'top' });
            }
        },
        back:function(){
            this.$router.go(-1)
        }
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
