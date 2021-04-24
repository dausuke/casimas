<template>
    <div>
        <mainHeaderBack></mainHeaderBack>
        <main class="container-fluid d-flex flex-column justify-content-center align-items-center mypage-container user-content">
            <h3 class="py-2 py-lg-3 m-0 font-weight-bold container-title">プロフィール</h3>
            <mypageContent :userId="data.userid"></mypageContent>
            <section class="mypage-user-update_container col-12 col-lg-6 ">
                <form class="mypage-user-update_container__content d-flex flex-column justify-content-center align-items-center">
                    <div class="form-group col-12 nickname">
                        <label for="nickname">ニックネーム</label>
                        <input class="form-control nickname-area" name="nickname" id="nickname" v-model="userData.nickname" />
                    </div>
                    <div class="form-group col-12 introdution">
                        <label for="introduction">自己紹介</label>
                        <textarea class="form-control  introduction-area" name="introduction" id="introduction" v-model="userData.introduction"></textarea>
                    </div>

                    <button type="button" class="btn btn-success w-50 mt-3 mt-lg-5" id="submitSellBtn" @click="updateProfile">
                        変更する
                    </button>
                </form>
            </section>
        </main>
        <footerMenu @changePage="changePage"></footerMenu>
    </div>
</template>

<script>
import mainHeaderBack from '../mainHeaderBack';
import footerMenu from '../../components/footerMenu';
import methods from '../../methods';
import mypageContent from './mypageContent';

export default {
    components: {
        mainHeaderBack,
        footerMenu,
        mypageContent,
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
        updateProfile: function() {
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
                .post('http://localhost/casimas/casimas_php/mypage.php', userUpdateData)
                .then(function(res) {
                    console.log(res);
                })
                .catch(function() {
                    alert('通信エラーが発生しました');
                })
                .finally(function() {});
        },
        changePage: function(request) {
            const router = this.$router;
            methods.changeUserPage(request, router);
        },
    },
};
</script>
<style scoped>
.mypage-user-icon {
    background-color: bisque;
}
.profile-img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background-color: black;
    margin: 0 auto;
}
.mypage-user-update_container {
    background-color: white;
}
.mypage-user-update_container__content {
    padding: 40px 16px;
}
.introduction-area {
    border: 1px solid #ccc;
}
</style>
