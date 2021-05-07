<template>
    <div class=" col-12 my-2 p-0 d-flex justify-content-center align-items-center item-area__content">
        <div class="m-0 p-3 w-50 item-area__content__img item-img">
            <img :src="url + itemContents.photo1" class="item m-0" />
            <rentaled v-show="itemContents.rental_state_id"></rentaled>
        </div>
        <div class="w-50 item-area__content__introduction">
            <p class="m-0 p-0 font-weight-bold text-left">{{ itemContents.item_name }}</p>
            <p class="m-0 p-0 font-weight-bold text-left item-price">７日：￥{{ itemContents.price_1w }}</p>
            <p class="m-0 p-0 font-weight-bold text-left item-price">３０日：￥{{ itemContents.price_1m }}</p>
            <p v-if="purchase" class="m-0 p-0 font-weight-bold text-left item-price">購入価格：￥{{ itemContents.price_purchase }}</p>
            <p class="m-0 p-0 text-left">{{ itemContents.brand }}</p>
            <p class="m-0 p-0 text-left">{{ itemContents.category_content }}</p>
            <button type="button" class="btn btn-secondary ml-5 my-3 item-page-btn" @click="itemPage(itemContents.item_id)">詳しく見る➡︎</button>
        </div>
    </div>
</template>

<script>
import rentaled from './rentaled';
import methods from '../methods';
export default {
    components: {
        rentaled,
    },
    props: { itemContents: Object, purchase: String },
    data() {
        return {
            url: methods.apiUrl.url,
        };
    },
    methods: {
        itemPage: function(itemId) {
            this.$emit('itemPage', itemId);
        },
    },
};
</script>

<style scoped>
.item-area__content {
    background-color: rgb(247, 247, 248);
    border-radius: 10%;
}
.item-area__content__img {
    height: 90%;
    position: relative;
}
.item-area__content__img .item {
    height: 130px;
    max-width: 100%;
    object-fit: cover;
    /* background-position: center center;
    background-repeat: no-repeat;
    background-size: contain; */
}
.item-price {
    color: red;
}
.item-page-btn {
    border-radius: 1.25rem;
}
</style>
