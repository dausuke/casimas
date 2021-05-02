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
                            <dt class="m-0">レンタル希望者</dt>
                            <dd class="m-0">{{ rentalRequest.nickname }}</dd>
                        </dl>
                    </div>
                </router-link>
                <div class="row pb-4 flex-column justify-content-center align-items-center btn-area">
                    <button type="button" class="btn btn-dark col-5 mb-4" @click="approvalRequest">承認する</button>
                    <button type="button" class="btn btn-outline-dark col-5" @click="rejectRequest">拒否する</button>
                </div>
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
        };
    },
    created: function() {
        const index = this.$route.query.index;
        this.rentalRequest = this.$store.state.notice.content[index];
    },
    methods: {
        changePage: function(request) {
            const router = this.$router;
            methods.changeUserPage(request, router);
        },
        approvalRequest: function() {
            methods
                .rentalAction({
                    token: 'approval',
                    userId: this.rentalRequest.request_user,
                    itemId: this.rentalRequest.request_item,
                    sellerId: this.rentalRequest.seller_id,
                    plan: this.rentalRequest.request_plan,
                    transactionPlace: this.rentalRequest.request_price,
                    requestId:this.rentalRequest.request_id,
                })
                .then(() => {});
        },
        rejectRequest: function() {
            methods
                .rentalAction({
                    token: 'reject',
                    id: this.rentalRequest.request_id,
                })
                .then(() => {});
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
