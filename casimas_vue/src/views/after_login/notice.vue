<template>
    <div>
        <mainHeader></mainHeader>
        <main class="container-fluid user-content">
            <ul class="nav nav-tabs d-flex justify-content-center">
                <li class="nav-item">
                    <p class="nav-link active" id="info" @click="changeTab">お知らせ</p>
                </li>
                <li class="nav-item">
                    <p class="nav-link" id="notice" @click="changeTab">レンタル希望</p>
                </li>
            </ul>
            <div class="user-content__todo area">
                <div v-if="this.showContent == 'info'" class="row justify-content-center" id="infoArea">
                    <div class="col-12 info-contents">
                        <span v-if="!info">お知らせはありません</span>
                        <div v-else></div>
                    </div>
                </div>
                <div v-else-if="this.showContent == 'notice'" class="row justify-content-center" id="noticeArea">
                    <div class="col-12 info-contents">
                        <span v-if="!notice">レンタル希望はありません</span>
                        <div v-else class="notice__containar w-100">
                            <ul class="row m-0 p-0">
                                <li v-for="(content, index) in notice" :key="index" class="col-12">
                                <router-link :to="{path:'noticeContent',query: { index: index } }">
                                    <div class="col-12 py-3 notice__containar__content">
                                        <div class="w-100">
                                            <p class="m-0 text-left">{{ content.item_name }}のレンタル希望が届いています</p>
                                            <p class="m-0 pr-3 text-left">{{ content.created_at }}</p>
                                        </div>
                                        <svg class="show-notice" width="10" height="19" viewBox="0 0 11 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 18.5L9.75 9.75L1 1" stroke="#525151" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footerMenu @changePage="changePage"></footerMenu>
    </div>
</template>
<script>
import mainHeader from '../../components/mainHeader';
import footerMenu from '../../components/footerMenu';
import methods from '../../methods';

export default {
    components: {
        mainHeader,
        footerMenu,
    },
    data() {
        return {
            showContent: 'info',
            notice: this.$store.state.notice.content,
            info: this.$store.state.info,
        };
    },
    methods: {
        changePage: function(request) {
            const router = this.$router;
            methods.changeUserPage(request, router);
        },
        changeTab: function() {
            const e_info = document.getElementById('info');
            const e_notice = document.getElementById('notice');
            if (e_info.classList.contains('active')) {
                this.showContent = 'notice';
                e_info.classList.remove('active');
                e_notice.classList.add('active');
            } else {
                this.showContent = 'info';
                e_info.classList.add('active');
                e_notice.classList.remove('active');
            }
        },
    },
};
</script>
<style scoped>
.notice__containar ul li {
    list-style: none;
    border-bottom: 1px solid #eee;
}
.notice__containar__content {
    position: relative;
}
.notice__containar__content p{
    color: #2c3e50;
    text-decoration: none;
}
.notice__containar__content svg {
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
}
.notice__containar__content p:nth-child(2) {
    color: #2c3e50bd;
}
</style>
