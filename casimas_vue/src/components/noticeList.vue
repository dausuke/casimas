<template>
    <ul class="row m-0 p-0 notice__containar">
        <li v-for="(content, index) in notice" :key="index" class="col-12">
            <div class="col-12 py-3 notice__containar__content">
                <div v-if="isSeller" class="w-100">
                    <router-link :to="{ path: 'noticeContent', query: { index: index } }">
                        <div class="w-100">
                            <p class="m-0 text-left">{{ content.item_name }}のレンタル希望が届いています</p>
                            <p class="m-0 pr-3 text-left">{{ content.updated_at }}</p>
                        </div>
                        <svg class="show-notice" width="10" height="19" viewBox="0 0 11 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 18.5L9.75 9.75L1 1" stroke="#525151" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </router-link>
                </div>
                <div v-else class="w-100">
                    <router-link :to="{ path: 'requestStateContent', query: { index: index } }">
                        <div v-if="content.request_state == '1'" class="w-100">
                            <p class="m-0 text-left">{{ content.item_name }}のレンタル承認待ちです</p>
                            <p class="m-0 pr-3 text-left">{{ content.updated_at }}</p>
                        </div>
                        <div v-else-if="content.request_state == '2'" class="w-100">
                            <p class="m-0 text-left">{{ content.item_name }}のレンタルが承認されました</p>
                            <p class="m-0 pr-3 text-left">{{ content.updated_at }}</p>
                        </div>
                        <div v-else-if="content.request_state == '0'" class="w-100">
                            <p class="m-0 text-left">{{ content.item_name }}のレンタルが承認されませんでした</p>
                            <p class="m-0 pr-3 text-left">{{ content.updated_at }}</p>
                        </div>
                        <svg class="show-notice" width="10" height="19" viewBox="0 0 11 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 18.5L9.75 9.75L1 1" stroke="#525151" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </router-link>
                </div>
            </div>
        </li>
    </ul>
</template>

<script>
export default {
    props: ['notice'],
    data() {
        return {
            isSeller: this.$store.state.auth.sellerid,
            state: null,
        };
    },
};
</script>

<style scoped>
.notice__containar li {
    list-style: none;
    border-bottom: 1px solid #eee;
}
.notice__containar__content {
    position: relative;
}
.notice__containar__content p {
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
