<template>
    <div class="container-fulid">
        <mainHeader></mainHeader>
        <main class="contanier-fulid user-content area">
            <div class="User-content__mypage">
                <div class="row w-100 m-0 justify-content-center flex-column align-items-center">
                    <div class="content-area row col-12 col-lg-6">
                        <div class="col-12 p-0 mb-3">
                            <mypageContent :userId="data.userid"></mypageContent>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 p-0 mt-3 nav-area">
                        <nav class="d-inline-flex w-100">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <router-link to="/MyPage" class="p-3 nav-link">マイページ</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/profile" class="p-3 nav-link">プロフィール</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/account" class="p-3 nav-link">登録情報</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/itemIsRental" class="p-3 nav-link">レンタル中</router-link>
                                </li>
                                <li class="nav-item" v-if="data.sellerid">
                                    <router-link to="/itemSelling" class="p-3 nav-link">出品中</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/itemDraft" class="p-3 nav-link">退会する</router-link>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </main>
        <footerMenu @changePage="changePage"></footerMenu>
    </div>
</template>
<script>
import mainHeader from '../../components/mainHeader';
import footerMenu from '../../components/footerMenu';
import methods from '../../methods';
import mypageContent from '../../components/mypageContent';

export default {
    components: {
        mainHeader,
        footerMenu,
        mypageContent,
    },
    data() {
        return {
            data: this.$store.state.auth,
            mypageData: {},
        };
    },
    created: function() {
    },
    beforeMount:function(){
            const self = this;
            const baseUrl = methods.apiUrl.url;
            this.url = baseUrl;

            const myHttpClient = this.axios.create({
                xsrfHeaderName: 'X-CSRF-Token',
                withCredentials: true,
            });
            const userId = new URLSearchParams();
            userId.append('user_id', this.data.userid);
            userId.append('token','getuser')

            myHttpClient
                .post(baseUrl + 'mypage.php', userId)
                .then(function(res) {
                    console.log(res);
                    self.mypageData = res.data;
                })
                .catch(function() {
                    alert('通信エラーが発生しました');
                })
                .finally(function() {});
    },
    methods: {
        changePage: function(request) {
            const router = this.$router;
            methods.changeUserPage(request, router);
        },
    },
};
</script>
<style scoped>
p {
    margin: 0;
}
ul {
    width: 100%;
}
ul li {
    text-align: start;
    border-top: 1px solid #eee;
    width: 100%;
}
ul li.nav-item a {
    color: black;
    text-decoration: none;
}
ul li.nav-item a:hover {
    color: black;
}
ul li a.active {
    background: #eee;
}
.nav-area,
.mypage-container {
    background-color: white;
}
</style>
