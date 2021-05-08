<template>
    <div class="container-fulid">
        <div class="row mt-5 w-75 d-flex admin">
            <div class="col-12">
                <ul class="nav nav-tabs d-flex justify-content-center">
                    <li class="nav-item">
                        <p class="nav-link active" id="itemImg" @click="changeTab">商品写真</p>
                    </li>
                    <li class="nav-item">
                        <p class="nav-link" id="coodinateImg" @click="changeTab">コーディネート写真</p>
                    </li>
                </ul>
                <div class="area">
                    <div v-if="this.showContent == 'item'" class="row justify-content-center" id="itemArea">
                        <div class="col-12 info-contents">
                            <upItemImg :allItem="allItem"></upItemImg>
                        </div>
                    </div>
                    <div v-else-if="this.showContent == 'coodinate'" class="row justify-content-center" id="coodinateArea">
                        <div class="col-12 info-contents">
                            <upCoodinate :allItem="allItem"></upCoodinate>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import upItemImg from '../components/admin/upItemImg.vue';
import upCoodinate from '../components/admin/upCoodinate';
import methods from '../methods';
export default {
    components: { upItemImg, upCoodinate },
    data() {
        return {
            showContent: 'item',
            allItem: null,
            itemId: null,
        };
    },
    created: async function() {
        const self = this;
        const myHttpClient = this.axios.create({
            xsrfHeaderName: 'X-CSRF-Token',
            withCredentials: true,
        });
        const requestItem = new URLSearchParams();
        requestItem.append('token', 'get_item');
        await myHttpClient.post(methods.apiUrl.url + 'admin.php', requestItem).then(res => {
            self.allItem = res.data;
        });
    },
    methods: {
        changeTab: function() {
            const e_itemImg = document.getElementById('itemImg');
            const e_coodinateImg = document.getElementById('coodinateImg');
            if (e_itemImg.classList.contains('active')) {
                this.showContent = 'coodinate';
                e_itemImg.classList.remove('active');
                e_coodinateImg.classList.add('active');
            } else {
                this.showContent = 'item';
                e_itemImg.classList.add('active');
                e_coodinateImg.classList.remove('active');
            }
        },
    },
};
</script>

<style scoped>
.admin {
    margin: 0 auto;
}
</style>
