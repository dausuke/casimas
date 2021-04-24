<template>
    <div>
        <mainHeaderBack></mainHeaderBack>
        <main class="container-fulid user-content">
            <div class="row area m-0 w-100 justify-content-center">
                <div class="col-12 itemimg-area">
                    <ul class="d-flex justify-content-center p-0 m-0">
                        <li>
                            <div class="item-img">
                                <div class="img-content" id="imgContent1" :data-url="itemData.photo1"></div>
                            </div>
                        </li>
                        <li v-show="itemData.photo2">
                            <div class="item-img">
                                <div class="img-content" id="imgContent2" :data-url="itemData.photo2"></div>
                            </div>
                        </li>
                        <li v-show="itemData.photo3">
                            <div class="item-img">
                                <div class="img-content" id="imgContent3" :data-url="itemData.photo3"></div>
                            </div>
                        </li>
                        <li v-show="itemData.photo4">
                            <div class="item-img">
                                <div class="img-content" id="imgContent4" :data-url="itemData.photo4"></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row area m-0 mt-3 px-3 px-lg-5 w-100 justify-content-center">
                <div class="row w-100 justify-content-center item-name">
                    <p>{{ itemData.item_name }}</p>
                </div>
                <div class="row w-100 flex-column rental-price">
                    <p class="text-left">7日間レンタル：¥{{ itemData.price_1w }}</p>
                    <p class="text-left">30日間レンタル：¥{{ itemData.price_1m }}</p>
                </div>
                <div class="row w-100 justify-content-between">
                    <div class="purchase ">
                        <div class="d-flex" v-if="itemData.purchase_judg == 'true'">
                            <p>購入：可</p>
                            <p class="ml-3">購入価格：¥{{ itemData.price_purchase }}</p>
                        </div>
                        <div class="d-flex" v-if="itemData.purchase_judg == 'false'">
                            <p>購入：不可</p>
                        </div>
                    </div>
                    <div class="pr-3 pb-2 favorite">
                        <svg width="30" height="30" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M31.2601 6.91499C30.4939 6.1485 29.5843 5.54046 28.5831 5.12562C27.5819 4.71077 26.5088 4.49725 25.4251 4.49725C24.3413 4.49725 23.2682 4.71077 22.267 5.12562C21.2658 5.54046 20.3562 6.1485 19.5901 6.91499L18.0001 8.50499L16.4101 6.91499C14.8625 5.36745 12.7636 4.49806 10.5751 4.49806C8.38651 4.49806 6.28759 5.36745 4.74006 6.91499C3.19252 8.46253 2.32312 10.5614 2.32312 12.75C2.32312 14.9385 3.19252 17.0375 4.74006 18.585L6.33006 20.175L18.0001 31.845L29.6701 20.175L31.2601 18.585C32.0266 17.8189 32.6346 16.9092 33.0494 15.908C33.4643 14.9068 33.6778 13.8337 33.6778 12.75C33.6778 11.6663 33.4643 10.5931 33.0494 9.59196C32.6346 8.59077 32.0266 7.68113 31.2601 6.91499V6.91499Z"
                                stroke="black"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="row area m-0 mt-3 w-100 justify-content-center flex-column">
                <p>商品説明</p>
                <div class="item-introduction">{{ itemData.item_introductoin }}</div>
            </div>
            <div class="row area m-0 mt-3 w-100 justify-content-center">
                <dl class="d-flex flex-wrap col-12 p-0 m-0 item-state">
                    <dt>ブランド</dt>
                    <dd>{{ itemData.brand }}</dd>
                    <dt>出品者の身長</dt>
                    <dd>{{ sellerHeight }}cm</dd>
                </dl>
            </div>
            <b-modal id="modal-center1" centered title="プランを選択" no-close-on-backdrop="true" no-close-on-esc="true" hide-footer="true">
                <div class="col-8 m-0 p-0 d-flex flex-column modal-body__select_plan">
                    <div class="form-group d-flex flex-column">
                        <label for="selectplan" class="text-center">プラン</label>
                        <select class="custom-select" v-model="rentalData.plan" id="selectplan">
                            <option value="1m">３０日間</option>
                            <option value="1w">７日間</option>
                        </select>
                    </div>
                    <div class=" d-flex flex-column">
                        <label for="rentalPrice" class="text-center">レンタル料金</label>
                        <p type="text" class="text-center" id="rentalPrice">{{ rentalData.price }}</p>
                    </div>
                    <p class="text-danger text-center" v-show="errorMessage">{{ errorMessage }}</p>
                </div>
                <footer id="modal-center___BV_modal_footer_" class="modal-footer pb-0">
                    <button type="button" class="btn btn-success" @click="rental">レンタルする</button>
                    <button type="button" class="btn btn-outline-secondary" @click="modalClose">キャンセル</button>
                </footer>
            </b-modal>
            <div class="row mt-3 m-0 w-100 justify-content-center" id="btn_area">
                <button type="button" class="btn btn-success" id="rentalBtn" v-b-modal.modal-center1>
                    レンタル希望を送る
                </button>
                <!-- <button type="button" class="btn btn-success" id="editBtn">編集する</button> -->
            </div>
            <b-modal id="modal-center2" centered title="商品をレンタルしました" no-close-on-backdrop="true" no-close-on-esc="true" hide-footer="true">
                <div class="col-8 m-0 p-0 d-flex flex-column modal-body__succes_rental">
                    <button type="button" class="btn btn-success mb-3"><router-link to="/Home">ホームへ</router-link></button>
                    <button type="button" class="btn btn-success"><router-link to="/itemIsRental">レンタル中の商品一覧</router-link></button>
                </div>
            </b-modal>
        </main>
        <footerMenu @changePage="changePage"></footerMenu>
    </div>
</template>

<script>
import mainHeaderBack from '../mainHeaderBack';
import footerMenu from '../../components/footerMenu';
import methods from '../../methods';

export default {
    components: {
        mainHeaderBack,
        footerMenu,
    },
    data() {
        return {
            itemId: null,
            token: 'item_ditail',
            itemData: {},
            sellerHeight: null,
            url: '',
            rentalData: {
                plan: null,
                price: null,
            },
            userid: {},
            errorMessage: null,
        };
    },
    methods: {
        changePage: function(request) {
            const router = this.$router;
            methods.changeUserPage(request, router);
        },
        getItem: async function(id) {
            const self = this;
            const baseUrl = methods.apiUrl.url;
            this.url = baseUrl;

            const myHttpClient = this.axios.create({
                xsrfHeaderName: 'X-CSRF-Token',
                withCredentials: true,
            });
            const itemRequest = new URLSearchParams();
            itemRequest.append('item_id', id);
            itemRequest.append('token', this.token);

            await myHttpClient.post(baseUrl + 'get_item.php', itemRequest).then(function(res) {
                self.itemData = res.data;
                //console.log(res.data);
                console.log(this.userid);
            });
        },
        getSeller: function() {
            const self = this;
            const baseUrl = methods.apiUrl.url;
            const myHttpClient = this.axios.create({
                xsrfHeaderName: 'X-CSRF-Token',
                withCredentials: true,
            });
            const itemRequest = new URLSearchParams();
            itemRequest.append('seller_id', this.itemData.seller_id);
            itemRequest.append('token', 'seller');

            myHttpClient.post(baseUrl + 'get_item.php', itemRequest).then(function(res) {
                self.sellerHeight = res.data.height;
                //console.log(res.data);
            });
        },
        getPhoto: function() {
            for (let i = 1; i <= 4; i++) {
                const imgUrl = this.url + document.getElementById('imgContent' + i).dataset.url;
                document.getElementById('imgContent' + i).style.backgroundImage = 'url(' + imgUrl + ')';
                //console.log(imgUrl);
            }
        },
        getAllData: async function(itemId) {
            await this.getItem(itemId);
            this.getSeller();
            this.getPhoto();
        },
        modalClose: function() {
            this.$bvModal.hide('modal-center1');
        },
        rental: function() {
            const self = this;
            const baseUrl = methods.apiUrl.url;
            const myHttpClient = this.axios.create({
                xsrfHeaderName: 'X-CSRF-Token',
                withCredentials: true,
            });
            const rentalData = new URLSearchParams();
            if (this.rentalData.plan != null && this.rentalData.price != null) {
                rentalData.append('item_id', this.itemData.item_id);
                rentalData.append('seller_id', this.itemData.seller_id);
                rentalData.append('user_id', this.$store.state.auth.userid);
                rentalData.append('plan', this.rentalData.plan);
                rentalData.append('transaction_price', this.rentalData.price);
                rentalData.append('token', 'rental');

                myHttpClient.post(baseUrl + 'rental.php', rentalData).then(function(res) {
                    console.log(res.data);
                    self.$bvModal.show('modal-center2');
                });
                this.$bvModal.hide('modal-center1');
            } else {
                this.errorMessage = 'プランを選択してください';
            }
        },
    },
    created: function() {
        const router = this.$route.query;
        this.itemId = router.itemId;
        this.userid = this.$store.state.auth;
    },
    mounted: function() {
        this.getAllData(this.itemId);
    },
    watch: {
        rentalData: {
            deep: true,
            handler: function() {
                if (this.rentalData.plan == '1m') {
                    this.rentalData.price = this.itemData.price_1m;
                } else if (this.rentalData.plan == '1w') {
                    this.rentalData.price = this.itemData.price_1w;
                }
            },
        },
    },
};
</script>

<style scoped>
.item-state dt {
    width: 96px;
    padding: 12px;
    background-color: rgba(243, 243, 243, 0.349);
    border-top: 1px solid #eee;
}
.item-state dd {
    width: 282px;
    overflow-wrap: break-word;
    border-top: 1px solid #eee;
    padding: 0 0 0 1rem;
    margin: 0;
}
.item-state dt,
.item-state dd {
    display: flex;
    justify-content: left;
    align-items: center;
}
.item-state :nth-child(5),
.item-state :nth-child(6) {
    border-bottom: 1px solid #eee;
}
.itemimg-area ul li {
    list-style: none;
    margin: 1rem;
}
.img-content {
    background-position: center center;
    background-repeat: no-repeat;
    background-size: contain;
    height: 80px;
    width: 80px;
    margin: 5px;
}
.modal-body__select_plan {
    margin: 0 auto !important;
}
.form-radio-label {
    font-size: 16px;
}
.modal-body__succes_rental {
    margin: 0 auto !important;
}
.modal-body__succes_rental a {
    color: white;
    text-decoration: none;
}
.modal-body__succes_rental a:hover {
    color: white;
}
</style>
