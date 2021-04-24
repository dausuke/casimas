<template>
    <div class="container-fluid p-0 mypage-container">
        <mainHeaderBack></mainHeaderBack>
        <main class="user-content">
            <h3 class="py-2 py-lg-3 m-0 font-weight-bold">アカウント登録情報</h3>
            <form class="account-content area col-lg-6 mt-3 mt-lg-5 pt-3 pt-lg-5">
                <div class="form-group">
                    <label for="userName">お名前</label>
                    <p>{{ userData.first_name }}{{ userData.last_name }}</p>
                </div>
                <div class="form-group">
                    <label>生年月日</label>
                    <p>{{ userData.birthday }}</p>
                </div>
                <div class="form-group">
                    <label for="address">住所</label>
                    <input type="text" class="form-control" id="address" v-model="userData.address" />
                </div>
                <div class="form-group">
                    <label for="phone">電話番号</label>
                    <input type="text" class="form-control" id="phone" v-model="userData.phone" />
                </div>
                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="text" class="form-control" id="email" v-model="userData.email" />
                </div>
                <div class="form-group pb-lg-5 pb-3">
                    <button type="button" class="btn btn-primary form-control w-50 mt-3 mt-lg-5" id="submitSellBtn">
                        変更する
                    </button>
                </div>
            </form>
        </main>
    </div>
</template>

<script>
import mainHeaderBack from '../mainHeaderBack';
import methods from '../../methods';

export default {
    components: {
        mainHeaderBack,
    },
    data() {
        return {
            data: null,
            userData: {},
            token: 'getuser',
        };
    },
    created: function() {
        this.data = this.$store.state.auth;
    },
    mounted: function() {
        const self = this;
        const baseUrl = methods.apiUrl.url;

        const myHttpClient = this.axios.create({
            xsrfHeaderName: 'X-CSRF-Token',
            withCredentials: true,
        });
        const userId = new URLSearchParams();
        userId.append('user_id', this.data.userid);
        userId.append('token', this.token);

        myHttpClient
            .post(baseUrl + 'mypage.php', userId)
            .then(function(res) {
                console.log(res);
                self.userData = res.data;
            })
            .catch(function() {
                alert('通信エラーが発生しました');
            })
            .finally(function() {});
    },
    methods: {
        updateaccount: function() {
            this.token = 'updade_profile';
            //const self = this;
            const myHttpClient = this.axios.create({
                xsrfHeaderName: 'X-CSRF-Token',
                withCredentials: true,
            });
            const userUpdateData = new URLSearchParams();
            userUpdateData.append('user_id', this.data.userid);
            userUpdateData.append('token', this.token);
            userUpdateData.append('nickname', this.userData.nickname);
            userUpdateData.append('introduction', this.userData.introduction);

            myHttpClient
                .post(baseUrl + 'mypage.php', userUpdateData)
                .then(function(res) {
                    console.log(res);
                })
                .catch(function() {
                    alert('通信エラーが発生しました');
                })
                .finally(function() {});
        },
    },
};
</script>

<style scoped>
.account-content {
    margin: 0 auto;
}
</style>
