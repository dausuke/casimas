<template>
    <div class="area user-content">
        <h2 class="pt-3">CASIMAS</h2>
        <span class="sub-title my-5 d-block" id="subTitle">
            <p class="mb-0 font-italic font-weight-bold">アパレル販売員が持っている</p>
            <p class="mt-0 font-italic font-weight-bold">「ちょっといい服」</p>
        </span>
        <div class="row w-100 m-0">
            <p class="w-100 text-center">おすすめアイテム</p>
            <div class="item-area w-100 m-0 p-0">
                <ul class="row m-0 p-0 w-100">
                    <li class="col-12" v-for="(content, index) in allItem" :key="index">
                        <itemImg :itemContents="content"></itemImg>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
import methods from '../methods';
import itemImg from './home_ItemImg';

export default {
    components: {
        itemImg,
    },
    data() {
        return {
            allItem: null,
            url: methods.apiUrl.url,
        };
    },
    created: function() {
        const self = this;
        methods
            .getItem({
                token: 'all_item',
            })
            .then(value => {
                self.allItem = value;
            });
    },
};
</script>
<style scoped>
.item-area ul li {
    list-style: none;
}
.item-img {
    height: 87px;
    width: 87px;
    position: relative;
}
.item-img .item {
    height: 87px;
    width: 87px;
    object-fit: cover;
}
</style>
