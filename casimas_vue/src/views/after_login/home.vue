<template>
    <div>
        <mainHeader></mainHeader>
        <main class="container-fulid user-content area">
            <div class="user-content__home">
                <h2 class="pt-3">全てのカテゴリー</h2>
                <div class="row w-100 m-0">
                    <div class="item-area w-100 m-0 p-0">
                        <ul class=" row d-flex justify-content-around m-0 p-0 w-100">
                            <li class="col-3 m-1 p-0" v-for="(content, index) in allItem" :key="index">
                                <div class=" col-12 p-0 item-area__content" @click="itemPage(content.item_id)">
                                    <div class="item-img">
                                        <img :src="url + content.photo1" class="item" />
                                        <rentaled v-show="content.rental_state_id"></rentaled>
                                    </div>
                                    <p class="m-0 p-0">{{ content.item_name }}</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <button v-if="data.sellerid" class="btn btn-success p-0 sell-btn" type="button"><router-link to="/sell">出品する</router-link></button>
        </main>
        <footerMenu @changePage="changePage"></footerMenu>
    </div>
</template>
<script>
import mainHeader from '../../components/mainHeader';
import footerMenu from '../../components/footerMenu';
import methods from '../../methods';
import rentaled from '../../components/rentaled';

export default {
    components: {
        mainHeader,
        footerMenu,
        rentaled,
    },
    data() {
        return {
            data: this.$store.state.auth,
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
            .then((value)=> {
                self.allItem = value;
            });
    },
    methods: {
        changePage: function(request) {
            const router = this.$router;
            methods.changeUserPage(request, router);
        },
        itemPage: function(id) {
            this.$router.push({ name: 'item', query: { itemId: id } });
        },
    },
};
</script>
<style scoped>
.sell-btn {
    height: 65px;
    width: 65px;
    border-radius: 50%;
    font-weight: bold;
    position: fixed;
    bottom: 60px;
    right: 40px;
}
.sell-btn a {
    color: white;
    text-decoration: none;
}
.sell-btn a:hover {
    color: white;
}
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
