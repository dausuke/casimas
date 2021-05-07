<template>
    <div>
        <mainHeaderBack></mainHeaderBack>
        <main class="container-fulid user-content">
            <div class="user-content__home area user-content ">
                <h2 class="pt-3">購入可能なアイテム</h2>
                <div class="row w-100 m-0">
                    <div class="item-area w-100 m-0 p-0">
                        <ul class="row m-0 p-0 w-100">
                            <li class="col-12 mb-3" v-for="(content, index) in item" :key="index">
                                <itemImg :itemContents="content" :purchase="'purchase'" @itemPage="itemPage"></itemImg>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <button v-if="data.sellerid" class="btn btn-dark p-0 sell-btn" type="button"><router-link to="/sell">出品する</router-link></button>
        </main>
        <footerMenu></footerMenu>
    </div>
</template>

<script>
import mainHeaderBack from '../../components/mainHeaderBack';
import footerMenu from '../../components/footerMenu';
import methods from '../../methods';
import itemImg from '../../components/home_ItemImg';
export default {
    components: {
        mainHeaderBack,
        footerMenu,
        itemImg,
    },

    data() {
        return {
            data: this.$store.state.auth,
            item: null,
            url: methods.apiUrl.url,
            noticeContent: [],
            noticeCnt: this.$store.state.notice.noticeCnt,
        };
    },
    created: async function() {
        await this.getItem();
        await this.checkRentalRequest();
        this.$store.commit('notice/getNotice', this.noticeContent[0]);
    },
    methods: {
        changePage: function(request) {
            const router = this.$router;
            methods.changeUserPage(request, router);
        },
        itemPage: function(id) {
            this.$router.push({ name: 'item', query: { itemId: id } });
        },
        getItem: async function() {
            const self = this;
            await methods
                .getItem({
                    token: 'purchase',
                })
                .then(value => {
                    self.item = value;
                });
        },
        checkRentalRequest: async function() {
            await methods
                .checkNotice({
                    token: 'user_check',
                    userid: this.$store.state.auth.userid,
                })
                .then(value => {
                    console.log(value);
                    if (value != '') {
                        this.noticeContent.push(value);
                    }
                });
            await this.checkRentalRequestSeller();
        },
        checkRentalRequestSeller: async function() {
            if (this.$store.state.auth.sellerid) {
                await methods
                    .checkNotice({
                        token: 'seller_check',
                        sellerid: this.$store.state.auth.sellerid,
                    })
                    .then(value => {
                        console.log(value);
                        if (value) {
                            this.noticeContent.push(value);
                        }
                    });
            }
        },
    },
};
</script>

<style scoped>
.sell-btn {
    height: 70px;
    width: 70px;
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
</style>
