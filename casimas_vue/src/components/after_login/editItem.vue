<template>
    <div>
        <mainHeaderBack></mainHeaderBack>
        <main class="container-fulid user-content">
            <!-- <div class="row area m-0 w-100 justify-content-center">
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
            </div> -->
            <div class="row area m-0 mt-3 px-3 px-lg-5 w-100 justify-content-center">
                <div class="row w-100 justify-content-center item-name">
                    <div class="form-group col-12">
                        <label for="itemName">商品名</label>
                        <input type="text" class="form-control" id="itemName" autocomplete="off" v-model="itemData.item_name" />
                    </div>
                </div>
                <div class="row w-100 flex-column rental-price">
                    <div class="form-group col-12">
                        <label>レンタル価格</label>
                        <span class="d-flex align-items-center"
                            ><p class="col-5 col-lg-3 m-0 ">７日間：</p>
                            <input type="number" class="form-control col-7 col-lg-9" id="price1w" autocomplete="off" v-model="itemData.price_1w"
                        /></span>
                        <span class="d-flex align-items-center"
                            ><p class="col-5 col-lg-3 mt-3 mb-0 ">３０日間：</p>
                            <input type="number" class="form-control col-7 col-lg-9 mt-3" id="price1m" autocomplete="off" v-model="itemData.price_1m"
                        /></span>
                    </div>
                </div>
                <div class="row w-100 justify-content-between">
                    <div class="form-group col-12">
                        <label for="purchaseJudg">購入可能にする</label>
                        <div class="checkbox d-flex justify-content-start">
                            <input type="checkbox" class="form-control col-1 " id="purchaseJudg" v-model="purchaseJudg" />
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center" v-if="purchaseJudg">
                    <div class="form-group col-12">
                        <label for="pricePurchase">販売金額</label>
                        <input type="number" class="form-control" id="pricePurchase" autocomplete="off" v-model="itemData.price_purchase" />
                    </div>
                </div>
            </div>
            <div class="row area m-0 mt-3 w-100 justify-content-center flex-column">
                <div class="form-group col-12">
                    <label for="description">商品の説明</label>
                    <textarea class="form-control" id="description" rows="7" v-model="itemData.item_introductoin"></textarea>
                </div>
            </div>
            <div class="row area m-0 mt-3 w-100 justify-content-center">
                <div class="form-group col-12">
                    <label for="itemBrand">ブランド</label>
                    <validation-provider rules="required">
                        <div slot-scope="ProviderProps">
                            <input type="text" class="form-control" id="itemBrand" autocomplete="off" v-model="itemData.brand" />

                            <p class="error-message">
                                {{ ProviderProps.errors[0] }}
                            </p>
                        </div>
                    </validation-provider>
                </div>
            </div>
            <b-modal id="modal-center1" centered title="プランを選択" no-close-on-backdrop="true" no-close-on-esc="true" hide-footer="true">
                <div class="col-8 m-0 p-0 d-flex flex-column modal-body__select_plan">
                    <p>商品を削除してよろしいですか？</p>
                </div>
                <footer id="modal-center___BV_modal_footer_" class="modal-footer pb-0">
                    <button type="button" class="btn btn-success" @click="deletItem">削除する</button>
                    <button type="button" class="btn btn-outline-secondary" @click="modalClose">キャンセル</button>
                </footer>
            </b-modal>
            <div class="row mt-3 m-0 w-100 justify-content-center align-items-center flex-column" id="btn_area">
                <button type="button" class="btn btn-success col-6" @click="editItem">
                    更新
                </button>
                <button type="button" class="btn btn-success col-6 mt-3" v-b-modal.modal-center1>
                    商品を削除する
                </button>
            </div>
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
            itemData: {},
            sellerHeight: null,
            url: '',
            userid: {},
            purchaseJudg: false,
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
            itemRequest.append('token', 'item_ditail');

            await myHttpClient.post(baseUrl + 'get_item.php', itemRequest).then(function(res) {
                self.itemData = res.data;
                if (res.data.purchase_judg == 'true') {
                    self.purchaseJudg = true;
                }
            });
        },
        // getSeller: function() {
        //     const self = this;
        //     const baseUrl = methods.apiUrl.url;
        //     const myHttpClient = this.axios.create({
        //         xsrfHeaderName: 'X-CSRF-Token',
        //         withCredentials: true,
        //     });
        //     const itemRequest = new URLSearchParams();
        //     itemRequest.append('seller_id', this.itemData.seller_id);
        //     itemRequest.append('token', 'seller');

        //     myHttpClient.post(baseUrl + 'get_item.php', itemRequest).then(function(res) {
        //         self.sellerHeight = res.data.height;
        //         //console.log(res.data);
        //     });
        // },
        // getPhoto: function() {
        //     for (let i = 1; i <= 4; i++) {
        //         const imgUrl = this.url + document.getElementById('imgContent' + i).dataset.url;
        //         document.getElementById('imgContent' + i).style.backgroundImage = 'url(' + imgUrl + ')';
        //         //console.log(imgUrl);
        //     }
        // },
        getAllData: async function(itemId) {
            await this.getItem(itemId);
            //this.getSeller();
            // this.getPhoto();
        },
        modalClose: function() {
            this.$bvModal.hide('modal-center1');
        },
        deletItem: function() {
            const self = this
            const baseUrl = methods.apiUrl.url;
            const myHttpClient = this.axios.create({
                xsrfHeaderName: 'X-CSRF-Token',
                withCredentials: true,
            });
            const itemData = new URLSearchParams();
            itemData.append('item_id', this.itemId);
            itemData.append('token', 'delete');
            myHttpClient.post(baseUrl + 'edit_item.php', itemData).then(function() {
                self.$router.push({ name: 'Home' });
            });
            this.$bvModal.hide('modal-center1');
        },
        editItem: function() {
            const self = this
            const baseUrl = methods.apiUrl.url;
            console.log(baseUrl);
            const myHttpClient = this.axios.create({
                xsrfHeaderName: 'X-CSRF-Token',
                withCredentials: true,
            });
            const itemData = new URLSearchParams();
            itemData.append('item_id', this.itemId);
            itemData.append('item_introductoin', this.itemData.item_introductoin);
            itemData.append('item_name', this.itemData.item_name);
            itemData.append('price_1m', this.itemData.price_1m);
            itemData.append('price_1w', this.itemData.price_1w);
            itemData.append('price_purchase', this.itemData.price_purchase);
            itemData.append('purchase_judg', this.purchaseJudg);
            itemData.append('token', 'edit');
            myHttpClient.post(baseUrl + 'edit_item.php', itemData).then(function() {
                alert('商品を編集しました');
                self.$router.push({ name: 'Home' });
            });
        },
    },
    created: function() {
        const router = this.$route.query;
        this.itemId = router.itemId;
        this.userid = this.$store.state.auth;
    },
    beforeMount: function() {
        this.getAllData(this.itemId);
    },
};
</script>

<style scoped></style>
