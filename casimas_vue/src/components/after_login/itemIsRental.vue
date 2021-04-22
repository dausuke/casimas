<template>
    <div>
        <mainHeaderBack></mainHeaderBack>
        <main class="container-fluid user-content mypage-container">
            <mypageContent :userId="userId.sellerid"></mypageContent>
            <div class="area mt-3">
                <div class="row justify-content-center mb-3">
                    <h2 class="font-weight-bold container-title mt-3">レンタル中の商品</h2>
                </div>
                <div class="row w-100 m-0 justify-content-center">
                    <div class="item-area">
                        <ul class=" row d-flex justify-content-around m-0 p-0 col-12">
                            <li class="col-12 p-3" v-for="(content, index) in rentaledItem" :key="index">
                                <div class="col-12 d-flex">
                                    <div class="col-4 m-0 p-0 d-flex justify-content-center align-items-center flex-column">
                                        <div :id="'rentalItemImg' + index" class="m-0 rental-item-img"></div>
                                        <!--  -->
                                    </div>
                                    <div class="col-6 d-flex align-items-end flex-column">
                                        <p class="p-0 col-12">{{ content.item_name }}</p>
                                        <p class="p-0 col-12">返却日：{{ content.return_date }}</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
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
            rentaledItem: {},
            userId: {},
        };
    },
    created: function() {
        this.userId = this.$store.state.auth;
    },
    mounted: async function() {
        const self = this;
        const baseUrl = methods.apiUrl.url;
        const myHttpClient = this.axios.create({
            xsrfHeaderName: 'X-CSRF-Token',
            withCredentials: true,
        });
        const itemRequest = new URLSearchParams();
        itemRequest.append('user_id', this.userId.userid);
        itemRequest.append('token', 'rentaled');

        await myHttpClient.post(baseUrl + 'rental.php', itemRequest).then(function(res) {
            self.rentaledItem = res.data;
            console.log(res.data);
        });
        this.rentaledItem.forEach(function(v, k) {
            document.getElementById('rentalItemImg' + k).style.backgroundImage = 'url(' + baseUrl + v.photo1 + ')';
        });
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
.item-area ul li {
    list-style: none;
    border-top: 1px solid #eee;
}
.rental-item-img {
    background-position: center center;
    /* background-repeat: no-repeat; */
    background-size: contain;
    width: 60px;
    height: 60px;
    margin: 0 auto;
}
</style>
