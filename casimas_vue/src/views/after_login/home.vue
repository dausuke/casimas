<template>
    <div>
        <mainHeader></mainHeader>
        <main class="container-fulid ">
            <div class="row w-100 mt-3 py-3 m-0 justify-content-center area">
                <div class="col-11 d-flex justify-content-between">
                    <router-link to="/category" class="my-lg-3 ml-3">
                        <button type="button" class="btn btn-outline-secondary link-btn">カテゴリー</button>
                    </router-link>
                    <router-link to="/purchase" class="my-lg-3 ml-3">
                        <button type="button" class="btn btn-outline-secondary link-btn">コーディネート</button>
                    </router-link>
                    <router-link to="/purchase" class="my-lg-3 ml-3">
                        <button type="button" class="btn btn-outline-secondary link-btn">購入可能</button>
                    </router-link>
                </div>
            </div>
            <div class="user-content__home area user-content ">
                <h2 class="pt-3">全てのカテゴリー</h2>
                <div class="row w-100 m-0">
                    <div class="item-area w-100 m-0 p-0">
                        <ul class="row m-0 p-0 w-100">
                            <li class="col-12 mb-3" v-for="(content, index) in allItem" :key="index">
                                <itemImg :itemContents="content" @itemPage="itemPage"></itemImg>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <button v-if="data.sellerid" class="btn btn-dark p-0 sell-btn" type="button"><router-link to="/sell">出品する</router-link></button>
        </main>
        <footerMenu @changePage="changePage" :noticeCnt="noticeCnt"></footerMenu>
    </div>
</template>
<script>
import mainHeader from '../../components/mainHeader';
import footerMenu from '../../components/footerMenu';
import methods from '../../methods';
import itemImg from '../../components/home_ItemImg';

export default {
    components: {
        mainHeader,
        footerMenu,
        itemImg,
    },
    data() {
        return {
            data: this.$store.state.auth,
            allItem: null,
            url: methods.apiUrl.url,
            noticeContent: [],
            noticeCnt: this.$store.state.notice.noticeCnt,
        };
    },
    created: async function() {
        const self = this;
        await methods
            .getItem({
                token: 'all_item',
            })
            .then(value => {
                self.allItem = value;
            });
        await this.checkRentalRequest();
        this.$store.commit('notice/getNotice', this.noticeContent[0]);
    },
    mounted: async function() {
        const myHttpClient = this.axios.create({
            xsrfHeaderName: 'X-CSRF-Token',
            withCredentials: true,
        });
        const countId = new URLSearchParams();
        const self = this;
        countId.append('token', 'cnt_user_notice');
        countId.append('user_id', this.$store.state.auth.userid);
        myHttpClient.post(methods.apiUrl.url + 'notice_action.php', countId).then(res => {
            console.log(res);
            let cnt = parseInt(res.data.cnt);
            self.$store.commit('notice/noticeCount', cnt);
            if (this.$store.state.auth.sellerid) {
                const myHttpClient = this.axios.create({
                    xsrfHeaderName: 'X-CSRF-Token',
                    withCredentials: true,
                });
                const countId = new URLSearchParams();
                countId.append('token', 'cnt_seller_notice');
                countId.append('seller_id', this.$store.state.auth.sellerid);
                myHttpClient.post(methods.apiUrl.url + 'notice_action.php', countId).then(res => {
                    console.log(res);
                    cnt += parseInt(res.data.cnt);
                    self.$store.commit('notice/noticeCount', cnt);
                });
            }
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
a {
    color: black;
}
a:hover {
    color: black;
    text-decoration: none;
}
.link-btn {
    color: black;
    text-decoration: none;
    border-radius: 1.25rem;
}
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
.item-area ul li {
    list-style: none;
}
</style>
