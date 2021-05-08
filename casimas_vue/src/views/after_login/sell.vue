<template>
    <div class="seller-content">
        <div class="seller-contnt__sell">
            <h1>CASIMAS</h1>
            <validation-observer ref="obs" v-slot="ObserverProps">
                <div class="container-fluid area pt-5">
                    <div class="row justify-content-center">
                        <div class="form-group col-12">
                            <div class="label-area d-flex">
                                <label for="itemName">商品名</label>
                                <p class="label-attention">必須</p>
                            </div>
                            <validation-provider rules="required">
                                <div slot-scope="ProviderProps">
                                    <input type="text" class="form-control" id="itemName" placeholder="40文字まで" autocomplete="off" v-model="itemData.name" />
                                    <p class="error-message">
                                        {{ ProviderProps.errors[0] }}
                                    </p>
                                </div>
                            </validation-provider>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group col-12">
                            <div class="label-area d-flex">
                                <label for="description">商品の説明</label>
                                <p class="label-attention">必須</p>
                            </div>
                            <validation-provider rules="required">
                                <div slot-scope="ProviderProps">
                                    <textarea
                                        class="form-control"
                                        id="description"
                                        rows="7"
                                        placeholder="商品の説明（1,000文字以内 色、素材、定価、注意点など)"
                                        v-model="itemData.description"
                                    ></textarea>
                                    <p class="error-message">
                                        {{ ProviderProps.errors[0] }}
                                    </p>
                                </div>
                            </validation-provider>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group col-12">
                            <div class="label-area d-flex">
                                <label for="categoryGenderId">カテゴリー</label>
                                <p class="label-attention">必須</p>
                            </div>
                            <validation-provider rules="required">
                                <div slot-scope="ProviderProps">
                                    <select class="custom-select" id="categoryGenderId" v-model="itemData.categoryId">
                                        <option selected>選択してください</option>
                                        <option value="1">[出品者身長]150cm~159cm</option>
                                        <option value="2">[出品者身長]160cm~169cm</option>
                                        <option value="3">[出品者身長]170cm~179cm</option>
                                        <option value="4">other item</option>
                                    </select>
                                    <p class="error-message">
                                        {{ ProviderProps.errors[0] }}
                                    </p>
                                </div>
                            </validation-provider>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group col-12">
                            <div class="label-area d-flex">
                                <label for="itemBrand">ブランド</label>
                                <p class="label-attention">必須</p>
                            </div>
                            <validation-provider rules="required">
                                <div slot-scope="ProviderProps">
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="itemBrand"
                                        placeholder="ブランド名"
                                        autocomplete="off"
                                        v-model="itemData.brand"
                                    />

                                    <p class="error-message">
                                        {{ ProviderProps.errors[0] }}
                                    </p>
                                </div>
                            </validation-provider>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group col-12">
                            <div class="label-area d-flex">
                                <label>レンタル価格</label>
                                <p class="label-attention">必須</p>
                            </div>
                            <validation-provider rules="required">
                                <div slot-scope="ProviderProps">
                                    <span class="d-flex align-items-center"
                                        ><p class="col-5 col-lg-3 m-0 ">７日間：</p>
                                        <input type="number" class="form-control col-7 col-lg-9" id="price1w" autocomplete="off" v-model="itemData.price1w"
                                    /></span>
                                    <p class="error-message">
                                        {{ ProviderProps.errors[0] }}
                                    </p>
                                </div>
                            </validation-provider>

                            <validation-provider rules="required">
                                <div slot-scope="ProviderProps">
                                    <span class="d-flex align-items-center"
                                        ><p class="col-5 col-lg-3 mt-3 mb-0 ">３０日間：</p>
                                        <input type="number" class="form-control col-7 col-lg-9 mt-3" id="price1m" autocomplete="off" v-model="itemData.price1m"
                                    /></span>
                                    <p class="error-message">
                                        {{ ProviderProps.errors[0] }}
                                    </p>
                                </div>
                            </validation-provider>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group col-12">
                            <div class="label-area d-flex">
                                <label for="purchaseJudg">購入可能にする</label>
                            </div>
                            <div class="checkbox d-flex justify-content-start">
                                <input type="checkbox" class="form-control col-1 " id="purchaseJudg" v-model="itemData.purchaseJudg" />
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center" v-if="itemData.purchaseJudg">
                        <div class="form-group col-12">
                            <div class="label-area d-flex">
                                <label for="pricePurchase">販売金額</label>
                                <p class="label-attention">必須</p>
                            </div>
                            <validation-provider rules="required">
                                <div slot-scope="ProviderProps">
                                    <input type="number" class="form-control" id="pricePurchase" autocomplete="off" v-model="itemData.pricePurchase" />
                                    <p class="error-message">
                                        {{ ProviderProps.errors[0] }}
                                    </p>
                                </div>
                            </validation-provider>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group col-6">
                            <button
                                type="button"
                                class="btn btn-dark form-control"
                                id="submitSellBtn"
                                :disabled="ObserverProps.invalid || !ObserverProps.validated"
                                @click="submititem"
                            >
                                出品する
                            </button>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <router-link to="/home" class="col-4 d-flex align-items-center justify-content-center"><p class="m-0">ホームへ</p></router-link>
                    </div>
                </div>
            </validation-observer>
        </div>
    </div>
</template>
<script>
import methods from '../../methods';
export default {
    data() {
        return {
            userId: this.$store.state.auth,
            itemData: {
                name: null,
                description: null,
                categoryId: null,
                brand: null,
                purchaseJudg: false,
                price1w: null,
                price1m: null,
            },
        };
    },
    created: function() {},
    methods: {
        submititem: function() {
            const self = this
            const baseUrl = methods.apiUrl.url;
            const myHttpClient = this.axios.create({
                xsrfHeaderName: 'X-CSRF-Token',
                withCredentials: true,
            });
            const upItemData = new URLSearchParams();
            upItemData.append('item_name', this.itemData.name);
            upItemData.append('item_introduction', this.itemData.description);
            upItemData.append('brand', this.itemData.brand);
            upItemData.append('purchase_judg', this.itemData.purchaseJudg);
            upItemData.append('price_1m', this.itemData.price1m);
            upItemData.append('price_1w', this.itemData.price1w);
            upItemData.append('seller_id', this.userId.sellerid);
            upItemData.append('category_id', this.itemData.categoryId);
            if (this.itemData.purchaseJudg) {
                upItemData.append('price_purchase', this.itemData.pricePurchase);
            }
            myHttpClient
                .post(baseUrl + 'submit_item.php', upItemData)
                .then(function(res) {
                    console.log(res)
                    alert('商品を出品しました')
                    self.$router.push({ name: 'Home' })
                });
        },
    },
};
</script>
<style scoped>
h1 {
    text-align: center;
    margin-top: 5%;
    margin-bottom: 5%;
}
.sell {
    width: 70%;
    margin: 0 auto;
}
.label-area {
    margin: 0 auto;
    padding: 0;
}
.label-area label {
    font-weight: bold;
}
.label-attention {
    background-color: red;
    color: white;
    padding: 0 4px;
    font-size: 12px;
    font-weight: bold;
    border: 1px solid red;
    border-radius: 2px;
    margin-left: 8px;
}

</style>
