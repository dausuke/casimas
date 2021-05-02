<template>
    <div>
        <mainHeaderBack></mainHeaderBack>
        <main class="container-fulid user-content area">
            <div class="row justify-content-center">
                <h3 class="font-weight-bold container-title my-3">レンタル希望</h3>
            </div>
            <div class="request-content">
                <router-link :to="{ path: 'item', query: { itemId: rentalRequest.request_item, type: 'rentalRequest' } }">
                    <div class="row w-100 m-0 justify-content-center">
                        <dl class="col-6">
                            <dt class="m-0">商品名</dt>
                            <dd class="m-0">{{ rentalRequest.item_name }}</dd>
                        </dl>
                    </div>
                    <div class="row w-100 m-0 justify-content-center">
                        <dl class="col-6 d-flex justify-content-center flex-column align-items-center">
                            <dt class="m-0">希望プラン</dt>
                            <div class="col-9 m-0 d-flex justify-content-between">
                                <dd class="m-0" v-if="rentalRequest.request_plan == '1m'">30日間</dd>
                                <dd class="m-0" v-else-if="rentalRequest.request_plan == '1w'">7日間</dd>
                                <dd class="m-0">¥{{ rentalRequest.request_price }}</dd>
                            </div>
                        </dl>
                    </div>
                    <div class="row w-100 m-0 justify-content-center">
                        <dl class="col-6">
                            <dt class="m-0">状態</dt>
                            <dd class="m-0">{{ stateMessage }}</dd>
                        </dl>
                    </div>
                </router-link>
            </div>
        </main>
        <footerMenu @changePage="changePage"></footerMenu>
    </div>
</template>

<script>
import mainHeaderBack from './mainHeaderBack';
import footerMenu from './footerMenu';
import methods from '../methods';
export default {
    components: {
        mainHeaderBack,
        footerMenu,
    },
    data() {
        return {
            rentalRequest: null,
            stateMessage: '',
        };
    },
    created: function() {
        const index = this.$route.query.key;
        this.rentalRequest = this.$store.state.notice.content[index];
        this.requestState();
    },
    mounted: function() {
        const myHttpClient = this.axios.create({
            xsrfHeaderName: 'X-CSRF-Token',
            withCredentials: true,
        });
        const requestId = new URLSearchParams();
        const self = this;
        requestId.append('token', 'checked_user');
        requestId.append('request_id', this.rentalRequest.request_id);
        requestId.append('user_id', this.$store.state.auth.userid);
        myHttpClient.post(methods.apiUrl.url + 'notice_action.php',requestId).then(res => {
            console.log(res)
            self.$store.commit('notice/noticeCount',parseInt(res.data.cnt));
        });
    },
    methods: {
        changePage: function(request) {
            const router = this.$router;
            methods.changeUserPage(request, router);
        },
        requestState: function() {
            switch (this.notice[0].request_state) {
                case '1':
                    this.state = '承認待ち';
                    break;
                case '2':
                    this.state = '承認済み';
                    break;
                case '0':
                    this.state = '承認されませんでした';
                    break;
            }
        },
    },
};
</script>

<style scoped>
.request-content dl dt,
.request-content dl dd {
    color: #2c3e50;
    text-decoration: none;
}
</style>
