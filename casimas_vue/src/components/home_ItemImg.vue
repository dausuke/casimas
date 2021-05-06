<template>
    <div class=" col-12 my-2 p-0 d-flex justify-content-center align-items-center item-area__content" @click="itemPage(itemContents.item_id)">
        <div class="m-0 p-3 w-50 item-area__content__img">
            <img :src="url + itemContents.photo1" class="item m-0" />
            <rentaled v-show="itemContents.rental_state_id"></rentaled>
        </div>
        <div class="w-50 pl-3 item-area__content__introduction">
            <p class="m-0 p-0 font-weight-bold text-left">{{ itemContents.item_name }}</p>
            <p class="m-0 p-0 font-weight-bold text-left item-price">７日間￥{{ itemContents.price_1w }}</p>
            <p class="m-0 p-0 font-weight-bold text-left item-price">３０日間￥{{ itemContents.price_1m }}</p>
            <p class="m-0 p-0 text-left">{{ itemContents.brand }}</p>
            <p class="m-0 p-0 text-left">{{ itemContents.category_content }}</p>
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
    props: ['itemContents'],
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
/* .item-area__content{

} */
.item-area__content__img {
    background-color: rgb(247, 247, 248);
    border-radius: 10%;
    height: 90%;
    width: 100px;
    position: relative;
}
.item-area__content__img .item {
    height: 100px;
    max-width: 100px;
    /* width: auto; */
    object-fit: cover;
    /* background-position: center center;
    background-repeat: no-repeat;
    background-size: contain; */
}
.item-price {
    color: red;
}
</style>
