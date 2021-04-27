<template>
    <div class="container-fluid p-0 mypage-container">
        <section class="mypage-seller-icon">
            <div class="row justify-content-center align-items-center">
                <div class="profile p-5">
                    <div v-b-modal.modal-center>
                        <b-avatar v-show="this.userData.profile_img == null" class="profile-img"></b-avatar>
                        <div v-show="this.userData.profile_img != null" class="profile-img" id="profileImg"></div>
                    </div>
                    <div class="profile-name py-lg-5 py-3">{{ this.userData.nickname }}</div>
                </div>
            </div>
        </section>
        <div>
            <b-modal id="modal-center" centered title="プロフィール画像を編集" no-close-on-backdrop="true" no-close-on-esc="true" hide-footer="true">
                <div class="col-12 p-0 d-flex justify-content-center align-items-center">
                    <label for="userImgFile" class=" d-flex justify-content-center align-items-center flex-column w-100 h-100 m-0">
                        <input type="file" id="userImgFile" ref="userImgFile" accept="image/png,image/jpeg" style="display:none;" @change="uploadFile" />
                        <p class="mt-4">
                            タップしてプロフィールを編集する
                        </p>
                        <div class="profile-img" id="pleviewImg"></div>
                    </label>
                </div>
                <footer id="modal-center___BV_modal_footer_" class="modal-footer">
                    <button type="button" class="btn btn-success" @click="submit">編集する</button>
                    <button type="button" class="btn btn-outline-secondary" @click="modalClose">キャンセル</button>
                </footer>
            </b-modal>
        </div>
    </div>
</template>
<script>
//import footerMenu from '../footerMenu.vue';
import methods from './../../methods';
export default {
    data() {
        return {
            userData: {},
            pleviewImgUrl: null,
            apiUrl: '',
        };
    },
    props: {
        userId: String,
    },
    beforeMount: async function() {
        await this.getUser();
        // if (this.userData.profile_img != null) {
        document.getElementById('profileImg').style.backgroundImage = 'url(' + this.apiUrl + this.userData.profile_img + ')';
        // }
    },
    methods: {
        getUser: async function() {
            const baseUrl = methods.apiUrl.url;
            this.apiUrl = baseUrl;
            const self = this;
            const myHttpClient = this.axios.create({
                xsrfHeaderName: 'X-CSRF-Token',
                withCredentials: true,
            });
            const userId = new URLSearchParams();
            userId.append('user_id', this.userId);
            userId.append('token', 'getuser');

            await myHttpClient
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
        submit: async function() {
            await this.updateProfileImg();
            this.changeProfileImg();
        },
        updateProfileImg: async function() {
            const self = this;
            const myHttpClient = this.axios.create({
                xsrfHeaderName: 'X-CSRF-Token',
                withCredentials: true,
            });
            const imgData = new FormData();
            imgData.append('user_id', this.userId);
            imgData.append('img_path', this.imgUrl);
            imgData.append('token', 'update_profile_img');

            await myHttpClient
                .post(this.apiUrl + 'mypage.php', imgData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                })
                .then(function(res) {
                    console.log(res);
                    self.userData.profile_img = res.data;
                })
                .catch(function() {
                    alert('通信エラーが発生しました');
                })
                .finally(function() {});
            this.$bvModal.hide('modal-center');
        },
        changeProfileImg: async function() {
            const self = this;
            const myHttpClient = this.axios.create({
                xsrfHeaderName: 'X-CSRF-Token',
                withCredentials: true,
            });
            const imgData = new FormData();
            imgData.append('user_id', this.userId);
            imgData.append('token', 'get_profile_img');

            await myHttpClient
                .post(this.apiUrl + 'mypage.php', imgData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                })
                .then(function(res) {
                    console.log(res.data.profile_img);
                    self.userData.profile_img = res.data.profile_img;
                })
                .catch(function() {
                    alert('通信エラーが発生しました');
                })
                .finally(function() {});
            document.getElementById('profileImg').style.backgroundImage = 'url(' + this.apiUrl + this.userData.profile_img + ')';
        },
        modalClose: function() {
            this.$bvModal.hide('modal-center');
            console.log(this.userData.profile_img);
        },
        uploadFile() {
            console.log('hoge');
            const file = this.$refs.userImgFile.files[0];
            this.imgUrl = file;
            this.pleviewImgUrl = URL.createObjectURL(file);
            document.getElementById('pleviewImg').style.backgroundImage = 'url(' + this.pleviewImgUrl + ')';
        },
    },
    // watch: {
    //     submit: {
    //         handler: function() {
    //             const self = this;
    //             const baseUrl = methods.apiUrl.url;
    //             this.url = baseUrl;
    //             const myHttpClient = this.axios.create({
    //                 xsrfHeaderName: 'X-CSRF-Token',
    //                 withCredentials: true,
    //             });
    //             const userId = new URLSearchParams();

    //             userId.append('user_id', this.userId.userid);
    //             userId.append('token', 'get_profile_img');

    //             myHttpClient.post(baseUrl + 'mypage.php', userId).then(function(res) {
    //                 console.log(res);
    //                 self.imgUrl = res.data;
    //             });
    //         },
    //     },
    // },
};
</script>
<style scoped>
ul li {
    list-style: none;
    background-color: black;
    height: 120px;
}
.mypage-seller-icon {
    background-color: bisque;
}
.profile-img {
    background-position: center center;
    /* background-repeat: no-repeat; */
    background-size: contain;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    margin: 0 auto;
}
</style>
