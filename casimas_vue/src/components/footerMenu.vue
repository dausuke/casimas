<template>
    <div class="footer-container">
        <div class="container-fluid ">
            <footer class="row m-0 fixed-bottom justify-content-center footer-menu">
                <div class="px-3 d-flex align-items-center justify-content-between footer-menu__content">
                    <div class="p-0 px-lg-3 d-flex justify-content-center">
                        <p @click="$emit('changePage', 'home')">ホーム</p>
                    </div>
                    <div class="p-0 px-lg-3 d-flex justify-content-center">
                        <p @click="$emit('changePage', 'rule')">ルール</p>
                    </div>
                    <div class="p-0 px-lg-3 d-flex justify-content-center">
                        <p @click="$emit('changePage', 'favorite')">スタイリスト</p>
                    </div>
                    <div class="p-0 px-lg-3 d-flex justify-content-center">
                        <div v-if="noticeCnt>0" class="notice-cnt">{{ noticeCnt }}</div>
                        <p @click="$emit('changePage', 'notice')">通知</p>
                    </div>
                    <div class="p-0 px-lg-3 d-flex justify-content-center">
                        <p @click="$emit('changePage', 'mypage')">マイページ</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</template>
<script>
export default {
    props: ['noticeCnt'],
};
</script>
<style scoped>
.footer-container {
    padding-top: 65px;
}
.footer-menu {
    background-color: white;
    z-index: 15;
    height:54px;
    box-shadow: rgb(0 0 0 / 18%) 0px -1px 3px;
}
.footer-menu__content p {
    margin-top: 1rem;
}
.notice-cnt{
    width: 20px;
    height: 20px;
    border: solid 1px rgb(248, 52, 52);
    border-radius: 50%;
    color: white;
    font-weight: bold;
    background-color: rgb(248, 52, 52);
}
@media screen and (max-width: 480px) {
    .footer-menu__content p {
        font-size: 12px;
    }
    .footer-container {
        padding-top: 65px;
    }
}
</style>
