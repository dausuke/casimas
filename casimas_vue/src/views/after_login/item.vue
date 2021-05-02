<template>
    <div>
        <mainHeaderBack></mainHeaderBack>
        <main class="container-fulid user-content">
            <div class="row area m-0 w-100 justify-content-center">
                <div class="col-12 itemimg-area">
                    <!-- <itemPhoto :itemData="itemData"></itemPhoto> -->
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
                    <span class="d-flex">
                        <p class="mr-3 font-weight-bold" v-show="itemData.rental_state_id">【レンタル中】</p>
                        <p class="font-weight-bold">{{ itemData.item_name }}</p>
                    </span>
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
                <p class="font-weight-bold">商品説明</p>
                <div class="item-introduction">{{ itemData.item_introductoin }}</div>
            </div>
            <div class="row area m-0 mt-3 w-100 justify-content-center">
                <dl class="d-flex flex-wrap col-12 p-0 m-0 item-state">
                    <dt>ブランド</dt>
                    <dd class="p-0 col-6">{{ itemData.brand }}</dd>
                    <dt>出品者の身長</dt>
                    <dd class="p-0 col-6">{{ sellerHeight.height }}cm</dd>
                </dl>
            </div>
            <div class="row mt-3 m-0 w-100 justify-content-center" id="btn_area" v-if="!type && !itemData.rental_state_id">
                <p v-if="requestState=='1'">出品者のレンタル希望承認を待っています</p>
                <button v-else-if="itemData.seller_id != userid.sellerid" type="button" class="btn btn-dark" id="rentalBtn" v-b-modal.modal-center1>
                    レンタル希望を送る
                </button>
                <button v-else type="button" class="btn btn-dark" @click="editItem">編集する</button>
            </div>
            <div class="row mt-3 m-0 w-100 justify-content-center" id="btn_area" v-else-if="itemData.rental_user_id == userid.userid">
                <button type="button" class="btn btn-dark" id="rentalBtn" v-b-modal.modal-center3>
                    返却通知を送る
                </button>
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
                    <button type="button" class="btn btn-dark" @click="rental">レンタル希望を送る</button>
                    <button type="button" class="btn btn-outline-secondary" @click="modalClose1">キャンセル</button>
                </footer>
            </b-modal>
            <b-modal id="modal-center2" centered title="レンタル希望を送信しました" no-close-on-backdrop="true" no-close-on-esc="true" hide-footer="true">
                <div class="col-8 m-0 p-0 d-flex flex-column modal-body__succes_rental">
                    <button type="button" class="btn btn-dark mb-3"><router-link to="/Home">ホームへ</router-link></button>
                </div>
            </b-modal>
            <b-modal id="modal-center3" centered title="返却通知の送信" no-close-on-backdrop="true" no-close-on-esc="true" hide-footer="true">
                <div class="col-8 m-0 p-0 d-flex flex-column modal-body__succes_return">
                    <p>商品の返送は完了していますか？</p>
                </div>
                <footer class="modal-footer pb-0">
                    <button type="button" class="btn btn-dark" @click="returnItem">はい</button>
                    <button type="button" class="btn btn-outline-secondary" @click="modalClose3">キャンセル</button>
                </footer>
            </b-modal>
        </main>
        <footerMenu @changePage="changePage" :noticeCnt="noticeCnt"></footerMenu>
    </div>
</template>

<script>
import mainHeaderBack from '../../components/mainHeaderBack';
import footerMenu from '../../components/footerMenu';
//import itemPhoto from '../../components/itemphoto'
import methods from '../../methods';

export default {
    components: {
        mainHeaderBack,
        footerMenu,
        // itemPhoto
    },
    data() {
        return {
            itemId: this.$route.query.itemId,
            type: this.$route.query.type,
            itemData: null,
            sellerHeight: null,
            url: methods.apiUrl.url,
            rentalData: {
                plan: null,
                price: null,
            },
            userid: this.$store.state.auth,
            errorMessage: null,
            noticeCnt: this.$store.state.notice.noticeCnt,
            requestState: null,
        };
    },
    created: async function() {
        const self = this;
        await methods
            .getItem({
                token: 'item_ditail',
                itemId: this.itemId,
            })
            .then(value => {
                self.itemData = value;
            });
        await methods
            .getSeller({
                token: 'seller',
                sellerId: this.itemData.seller_id,
            })
            .then(value => {
                console.log(value);
                self.sellerHeight = value;
            });
        await this.getPhoto();
        this.checkRrequestState();
    },
    methods: {
        changePage: function(request) {
            const router = this.$router;
            methods.changeUserPage(request, router);
        },
        getPhoto: function() {
            for (let i = 1; i <= 4; i++) {
                const imgUrl = this.url + document.getElementById('imgContent' + i).dataset.url;
                document.getElementById('imgContent' + i).style.backgroundImage = 'url(' + imgUrl + ')';
            }
        },
        modalClose1: function() {
            this.$bvModal.hide('modal-center1');
        },
        modalClose3: function() {
            this.$bvModal.hide('modal-center3');
        },
        submitRentalRequest: function() {},
        rental: async function() {
            const self = this;
            if (this.rentalData.plan != null && this.rentalData.price != null) {
                await methods
                    .rentalAction({
                        token: 'rental',
                        itemId: this.itemData.item_id,
                        itemName: this.itemData.item_name,
                        sellerId: this.itemData.seller_id,
                        userId: this.$store.state.auth.userid,
                        plan: this.rentalData.plan,
                        transactionPlace: this.rentalData.price,
                    })
                    .then(function() {
                        self.$bvModal.hide('modal-center1');
                    });
                this.$bvModal.show('modal-center2');
            } else {
                this.errorMessage = 'プランを選択してください';
            }
        },
        editItem: function() {
            this.$router.push({ name: 'editItem', query: { itemId: this.itemId } });
        },
        returnItem: async function() {
            const self = this;
            await methods
                .rentalAction({
                    token: 'return',
                    rentalStateId: this.itemData.rental_state_id,
                })
                .then(function() {
                    alert('返却が完了しました');
                    self.$router.push({ name: 'Home' });
                });
        },
        dataSet: function() {
            this.itemData = this.$store.state.itemDitail;
            this.sellerHeight = this.$store.state.sellerInfo.height;
        },
        checkRrequestState: function() {
            const myHttpClient = this.axios.create({
                xsrfHeaderName: 'X-CSRF-Token',
                withCredentials: true,
            });
            const requestCheckData = new URLSearchParams();
            const self = this;
            requestCheckData.append('token', 'check_rental_request_item');
            requestCheckData.append('item_id', this.$route.query.itemId);
            requestCheckData.append('user_id', this.$store.state.auth.userid);
            myHttpClient.post(methods.apiUrl.url + 'rental.php', requestCheckData).then(res => {
                console.log(res);
                self.requestState = res.data.request_state;
            });
        },
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
