<template>
    <div class=" col-12 p-0 d-flex justify-content-center align-items-center flex-column item-area__content" @click="itemPage(itemContents.item_id)">
        <div class="m-0 item-img">
            <img :src="url + itemContents.photo1" class="item m-0" />
            <rentaled v-show="itemContents.rental_state_id"></rentaled>
        </div>
        <p class="m-0 p-0 font-weight-bold">{{ itemContents.item_name }}</p>
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
.item-area__content{
    background-color:rgb(247, 247, 248) ;
    border-radius: 10%;
}
.item-img {
    height: 110px;
    width: 100px;
    padding-top: 10px;
    position: relative;
}
.item-img .item {
    height: 100px;
    max-width: 100px;
    /* width: auto; */
    object-fit: cover;
    /* background-position: center center;
    background-repeat: no-repeat;
    background-size: contain; */
}
</style>
