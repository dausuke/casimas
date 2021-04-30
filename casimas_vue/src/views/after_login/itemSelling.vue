<template>
    <div>
        <mainHeaderBack></mainHeaderBack>
        <main class="container-fluid user-content mypage-container">
            <mypageContent :userId="userId.sellerid"></mypageContent>
            <div class="area mt-3">
                <div class="row justify-content-center">
                    <h2 class="font-weight-bold container-title my-3">出品中の商品</h2>
                </div>
                <div class="row w-100 m-0">
                    <div class="item-area w-100 m-0 p-0">
                        <ul class=" row d-flex justify-content-around m-0 p-0 w-100">
                            <li class="col-3 m-1 p-0" v-for="(content, index) in sellingItem" :key="index">
                                <div class=" col-12 p-0 item-area__content" @click="itemPage(content.item_id)">
                                    <div class="item-img">
                                        <img :src="url + content.photo1" />
                                    </div>
                                    <p class="m-0 p-0">{{ content.item_name }}</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
        <footerMenu @changePage="changePage"></footerMenu>
    </div>
</template>
<script>
import mainHeaderBack from '../../components/mainHeaderBack';
import footerMenu from '../../components/footerMenu';
import methods from '../../methods';
import mypageContent from '../../components/mypageContent';

export default {
    components: {
        mainHeaderBack,
        footerMenu,
        mypageContent,
    },
    data() {
        return {
            sellingItem: {},
            userId: this.$store.state.auth,
            url: methods.apiUrl.url,
        };
    },
    created: async function() {
        const self = this;
        await methods
            .getItem({
                token: 'selling_allitem',
                userId: this.userId.sellerid,
            })
            .then(value => {
                self.sellingItem = value;
            });
    },
    methods: {
        changePage: function(request) {
            const router = this.$router;
            methods.changeUserPage(request, router);
        },
        itemPage: function(id) {
            this.$router.push({ name: 'item', query: { itemId: id } });
            console.log(id);
        },
    },
};
</script>
<style scoped>
.item-area ul li {
    list-style: none;
}
.item-img img {
    height: 87px;
    width: 87px;
    object-fit: cover;
}
</style>
