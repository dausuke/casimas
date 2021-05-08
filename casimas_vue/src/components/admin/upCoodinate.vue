<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-4 item-list">
                <p>アイテムリスト</p>
                <div class="row m-0 p-0 w-100 ">
                    <div class="col-12 d-flex justify-content-start form-check list" v-for="(content, index) in allItem" :key="index">
                        <input class="form-check-input" type="checkbox" :id="'itemId' + index" :value="content.item_id" v-model="itemId" />
                        <label class="form-check-label ml-3" :for="'itemId' + index"> {{ content.item_name }} </label>
                    </div>
                </div>
            </div>
            <div class="form-group col-8">
                <div class="label-area d-flex">
                    <label>出品画像</label>
                </div>
                <p>コーディネートを投稿</p>
                <div class="upfile-area p-0 d-flex justify-content-center">
                    <div class="pleview-area" v-show="coodinatePhoto != null">
                        <div class="pleview-area__content" id="pleview"></div>
                        <div class="m-0 d-flex justify-content-center align-items-center delete-pleview-area__content" @click="deleteFile()">
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
                            <p v-if="show == 'show'" class="mt-4">
                                クリックしてファイルをアップロード
                            </p>
                        </label>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-6">
                        <button type="button" class="btn btn-dark form-control" @click="submitItemImg">
                            アップロードする
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import methods from '../../methods';
export default {
    props: ['allItem'],
    data() {
        return {
            itemId: [],
            coodinatePhoto: null,
            coodineteImg: null,
            show: 'show',
        };
    },
    methods: {
        uploadFile() {
            const file = this.$refs.preview.files[0];
            this.coodineteImg = file;
            this.coodinatePhoto = URL.createObjectURL(file);
            document.getElementById('pleview').style.backgroundImage = 'url(' + this.coodinatePhoto + ')';
            this.show = 'none';
        },
        deleteFile() {
            delete this.coodinatePhoto;
            delete this.coodineteImg;
        },
        submitItemImg: function() {
            const baseUrl = methods.apiUrl.url;
            const myHttpClient = this.axios.create({
                xsrfHeaderName: 'X-CSRF-Token',
                withCredentials: true,
            });
            const upcoodinatePhoto = new FormData();
            upcoodinatePhoto.append('token', 'coodinate');
            // this.itemId.forEach((v,k) => {
            //     upcoodinatePhoto.append('item_id'+k, v);
            // });
            upcoodinatePhoto.append('item_id', this.itemId);
            upcoodinatePhoto.append('coodinete_img', this.coodineteImg);
            myHttpClient
                .post(baseUrl + 'admin.php', upcoodinatePhoto, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                })
                .then(function(res) {
                    console.log(res);
                    alert('商品画像をアップロードしました');
                });
        },
    },
};
</script>

<style>
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
.item-list {
    border: solid 1px;
    background-color: white;
}
.item-list .list {
    border-top: solid 1px;
}
.item-list .list:last-child {
    border-bottom: solid 1px;
}
</style>
