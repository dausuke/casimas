<template>
    <div class="seller-content">
        <div class="seller-contnt__sell">
            <h1>CASIMAS</h1>
            <validation-observer ref="obs" v-slot="ObserverProps">
                <div class="container-fluid area pt-5">
                    <div class="row justify-content-center">
                        <div class="form-group col-12">
                            <div class="label-area d-flex">
                                <label>出品画像</label>
                                <p class="label-attention">必須</p>
                            </div>
                            <p>最大4枚までアップロードできます</p>
                            <div class="upfile-area p-0 d-flex justify-content-center">
                                <div class="pleview-area" v-show="itemData.photo[0] != null">
                                    <div class="pleview-area__content" id="pleview1"></div>
                                    <div class="m-0 d-flex justify-content-center align-items-center delete-pleview-area__content" @click="deleteFile(1)">
                                        削除
                                    </div>
                                </div>
                                <div class="pleview-area" v-show="itemData.photo[1] != null">
                                    <div class="pleview-area__content" id="pleview2"></div>
                                    <div class="m-0 d-flex justify-content-center align-items-center delete-pleview-area__content" @click="deleteFile(2)">
                                        削除
                                    </div>
                                </div>
                                <div class="pleview-area" v-show="itemData.photo[2] != null">
                                    <div class="pleview-area__content" id="pleview3"></div>
                                    <div class="m-0 d-flex justify-content-center align-items-center delete-pleview-area__content" @click="deleteFile(3)">
                                        削除
                                    </div>
                                </div>
                                <div class="pleview-area" v-show="itemData.photo[3] != null">
                                    <div class="pleview-area__content" id="pleview4"></div>
                                    <div class="m-0 d-flex justify-content-center align-items-center delete-pleview-area__content" @click="deleteFile(4)">
                                        削除
                                    </div>
                                </div>
                                <div class="selling-img-upload col-12 p-0 d-flex justify-content-center align-items-center">
                                    <label for="sellingImg" class=" d-flex justify-content-center align-items-center flex-column w-100 h-100 m-0">
                                        <input
                                            type="file"
                                            id="sellingImg"
                                            multiple
                                            accept="image/png,image/jpeg"
                                            ref="preview"
                                            style="display:none;"
                                            @change="uploadFile"
                                        />
                                        <svg width="40" height="36" viewBox="0 0 40 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M24.7 0C26.64 0.0199778 28.22 1.01887 29.14 2.81687C29.3775 3.29134 29.7088 3.98432 30.0556 4.71535L30.4744 5.59929L30.68 6.0333L30.88 6.47281C30.96 6.61265 31.1 6.71254 31.28 6.71254C36.08 6.71254 40 10.6282 40 15.4229V27.2897C40 32.0844 36.08 36 31.28 36H8.72C3.9 36 0 32.0844 0 27.2897V15.4229C0 10.6282 3.9 6.71254 8.72 6.71254C8.88 6.71254 9.04 6.63263 9.1 6.47281L9.22 6.23307C9.78 5.05438 10.46 3.61598 10.86 2.81687C11.78 1.01887 13.34 0.0199778 15.28 0H24.7ZM20 12.8058C17.9 12.8058 15.92 13.6249 14.42 15.1232C12.94 16.6215 12.12 18.5794 12.14 20.657C12.14 22.7547 12.96 24.7125 14.44 26.2109C15.94 27.6892 17.9 28.5083 20 28.5083C22.16 28.5083 24.12 27.6293 25.54 26.2109C26.96 24.7925 27.84 22.8346 27.86 20.657C27.86 18.5794 27.04 16.6016 25.56 15.1032C24.08 13.6249 22.1 12.8058 20 12.8058ZM20 15.8024C21.3 15.8024 22.52 16.3019 23.44 17.2209C24.36 18.1398 24.86 19.3585 24.86 20.657C24.84 23.3341 22.68 25.5117 20 25.5117C18.7 25.5117 17.48 25.0122 16.56 24.0932C15.64 23.1743 15.14 21.9556 15.14 20.657V20.6371C15.12 19.3785 15.62 18.1598 16.54 17.2408C17.48 16.3019 18.7 15.8024 20 15.8024ZM31.22 12.3263C30.22 12.3263 29.42 13.1454 29.42 14.1443C29.42 15.1432 30.22 15.9423 31.22 15.9423C32.22 15.9423 33.04 15.1432 33.04 14.1443C33.04 13.1454 32.22 12.3263 31.22 12.3263Z"
                                                fill="#200E32"
                                            />
                                        </svg>
                                        <p v-if="show == 'none'" class="mt-4">
                                            クリックしてファイルをアップロード
                                        </p>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                class="btn btn-success form-control"
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
export default {
    data() {
        return {
            userId: {},
            itemData: {
                name: null,
                description: null,
                categoryId: null,
                brand: null,
                purchaseJudg: false,
                price1w: null,
                price1m: null,
                photo: [],
            },
            itemPhoto: {},
            fileCount: 0,
            show: 'none',
        };
    },
    created: function() {
        this.userId = this.$store.state.auth;
    },
    methods: {
        uploadFile() {
            switch (this.fileCount) {
                case 0: {
                    const file = this.$refs.preview.files[0];
                    this.itemData.photo[0] = file;
                    this.itemPhoto.pleview1 = URL.createObjectURL(file);
                    document.getElementById('pleview1').style.backgroundImage = 'url(' + this.itemPhoto.pleview1 + ')';
                    this.fileCount++;
                    this.show = 'photo1';
                    break;
                }
                case 1: {
                    const file = this.$refs.preview.files[0];
                    this.itemData.photo[1] = file;
                    this.itemPhoto.pleview2 = URL.createObjectURL(file);
                    document.getElementById('pleview2').style.backgroundImage = 'url(' + this.itemPhoto.pleview2 + ')';
                    this.fileCount++;
                    this.show = 'photo2';
                    break;
                }
                case 2: {
                    const file = this.$refs.preview.files[0];
                    this.itemData.photo[2] = file;
                    this.itemPhoto.pleview3 = URL.createObjectURL(file);
                    document.getElementById('pleview3').style.backgroundImage = 'url(' + this.itemPhoto.pleview3 + ')';
                    this.fileCount++;
                    this.show = 'photo3';
                    break;
                }
                case 3: {
                    const file = this.$refs.preview.files[0];
                    this.itemData.photo[3] = file;
                    this.itemPhoto.pleview4 = URL.createObjectURL(file);
                    document.getElementById('pleview4').style.backgroundImage = 'url(' + this.itemPhoto.pleview4 + ')';
                    this.fileCount++;
                    this.show = 'photo4';
                    break;
                }
            }
        },
        deleteFile(file) {
            switch (file) {
                case 1:
                    delete this.itemPhoto.pleview1;
                    delete this.itemData.photo[0];
                    this.fileCount = 0;
                    this.show = 'photo4';
                    break;
                case 2:
                    delete this.itemPhoto.pleview2;
                    delete this.itemData.photo[1];

                    this.fileCount = 1;
                    this.show = 'photo3';
                    break;
                case 3:
                    delete this.itemPhoto.pleview3;
                    delete this.itemData.photo[2];

                    this.fileCount = 2;
                    this.show = 'photo2';
                    break;
                case 4:
                    delete this.itemPhoto.pleview4;
                    delete this.itemData.photo[3];

                    this.fileCount = 3;
                    this.show = 'photo1';
                    break;
            }
        },
        submititem: function() {
            const upItemData = new FormData();
            if (this.itemData.photo[0]) {
                upItemData.append('photo1', this.itemData.photo[0]);
            }
            if (this.itemData.photo[1]) {
                upItemData.append('photo2', this.itemData.photo[1]);
            }
            if (this.itemData.photo[2]) {
                upItemData.append('photo3', this.itemData.photo[2]);
            }
            if (this.itemData.photo[3]) {
                upItemData.append('photo4', this.itemData.photo[3]);
            }
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

            this.axios
                .post('http://localhost/casimas/casimas_php/submit_item.php', upItemData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                })
                .then(function(res) {
                    console.log(res);
                });
        },
    },
    watch: {
        show: {
            deep: true,
            handler: function() {
                if (!this.itemPhoto.pleview1 && !this.itemPhoto.pleview2 && !this.itemPhoto.pleview3 && !this.itemPhoto.pleview4) {
                    this.show = 'none';
                }
            },
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
.upfile-area {
    overflow: hidden !important;
}
.selling-img-upload {
    background-color: rgb(245, 245, 245);
    border: 1px dashed rgb(204, 204, 204);
    cursor: pointer;
    height: 120px;
    flex-wrap: wrap;
    position: relative;
    transition: all 0.5s ease-out 0s;
    flex: 1 1 0%;
    overflow: hidden !important;
}
.selling-img-upload label {
    overflow: hidden !important;
}
.selling-img-upload p {
    font-size: 12px;
}
.pleview-area {
    margin-right: 8px;
    width: 80px;
    height: 120px;
    background-color: rgb(245, 245, 245);
}
.pleview-area__content {
    background-position: center center;
    background-repeat: no-repeat;
    background-size: contain;
    height: 80px;
    width: 70px;
    margin: 5px;
}
.delete-pleview-area__content {
    height: 20px;
    width: 80px;
    border-top: solid 1px rgb(204, 204, 204);
    padding: 5px 0 0 0;
}
</style>
