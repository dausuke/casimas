<template>
    <div class=" col-12 my-2 p-0 d-flex justify-content-center align-items-center area">
        <div class="m-0 p-3 item-area__content__img item-img" @click="showItemName">
            <img :src="url + coordinateData.coordinateImg" class="item m-0" />
            <div v-show="show" class="item-name">
                <div v-for="(content, index) in itemData" :key="index" @click="itemPage(content.item_id)" class="my-4 font-weight-bold name">
                    {{ content.item_name }}
                </div>
            </div>
            <div class="mt-3">コーディネート紹介文</div>
        </div>
    </div>
</template>

<script>
import methods from '../methods';

export default {
    props: ['coordinateData'],
    data() {
        return {
            url: methods.apiUrl.url,
            itemData: {},
            show: false,
        };
    },
    created: function() {
        const self = this;
        const myHttpClient = this.axios.create({
            xsrfHeaderName: 'X-CSRF-Token',
            withCredentials: true,
        });
        const requestToken = new URLSearchParams();
        requestToken.append('token', 'get_coordinate_item');
        requestToken.append('item_id', this.coordinateData['coordinateItemId']);

        myHttpClient.post(methods.apiUrl.url + 'get_coordinate.php', requestToken).then(res => {
            //console.log(res);
            self.itemData = res.data;
        });
    },
    methods: {
        itemPage: function(id) {
            this.$router.push({ name: 'item', query: { itemId: id } });
        },
        showItemName: function() {
            if (this.show) {
                this.show = false;
            } else {
                this.show = true;
            }
        },
    },
};
</script>

<style scoped>
.item-img {
    width: 90%;
}
.item-area__content__img {
    position: relative;
}
.item-name {
    position: absolute;
    top: 15%;
    left: 5%;
    background-color: rgba(0, 0, 0, 0.295);
}
.name {
    font-size: 14px;
    color: white;
}
.item-area__content__img .item {
    height: auto;
    width: 100%;
    object-fit: cover;
}
</style>
