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
                        <div v-else class=" w-100">
                            <noticeList :notice="notice"></noticeList>
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
import noticeList from '../../components/noticeList';

export default {
    components: {
        mainHeader,
        footerMenu,
        noticeList,
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

</style>
