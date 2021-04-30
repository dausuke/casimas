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
                    <button type="button" class="btn btn-primary form-control w-50 mt-3 mt-lg-5" @click="updateaccount">
                        変更する
                    </button>
                </div>
            </form>
        </main>
    </div>
</template>

<script>
import mainHeaderBack from '../../components/mainHeaderBack';
import methods from '../../methods';

export default {
    components: {
        mainHeaderBack,
    },
    data() {
        return {
            data: this.$store.state.auth,
            userData: {},
        };
    },
    created: function() {
        const self = this;
        methods
            .mypageAction({
                token: 'getuser',
                userId: this.$store.state.auth.userid,
            })
            .then(value => {
                self.userData = value;
            });
    },
    methods: {
        updateaccount: function() {
            methods
                .mypageAction({
                    token: 'update_account',
                    userId: this.$store.state.auth.userid,
                    address:this.userData.address,
                    phone:this.userData.phone,
                    email:this.userData.email
                })
                .then(() => {
                    alert('登録情報を編集しました');
                });
        },
    },
};
</script>

<style scoped>
.account-content {
    margin: 0 auto;
}
</style>
