<template>
    <div>
        <mainHeaderBack></mainHeaderBack>
        <main class="container-fulid user-content">
            <h2 class="py-3 area">コーディネート一覧</h2>
            <div class="user-content__home user-content ">
                <div class="row w-100 m-0">
                    <div class="item-area w-100 m-0 p-0">
                        <ul class="row m-0 p-0 w-100">
                            <li class="col-12 mb-3" v-for="(content, index) in coordinateData" :key="index">
                                <coodinateImg :coordinateData="content"></coodinateImg>
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
import coodinateImg from '../../components/coodinateImg';
export default {
    components: {
        mainHeaderBack,
        footerMenu,
        coodinateImg,
    },
    data() {
        return {
            data: this.$store.state.auth,
            coordinate: {},
            coordinateData: [],
            itemId: null,
            noticeContent: [],
            noticeCnt: this.$store.state.notice.noticeCnt,
        };
    },
    created: async function() {
        await this.get_coordinate();
        await this.get_item_id();
        await this.mergeCoordinate();
    },
    methods: {
        get_coordinate: async function() {
            const self = this;
            const myHttpClient = this.axios.create({
                xsrfHeaderName: 'X-CSRF-Token',
                withCredentials: true,
            });
            const requestToken = new URLSearchParams();
            requestToken.append('token', 'get_coordinate');
            await myHttpClient.post(methods.apiUrl.url + 'get_coordinate.php', requestToken).then(res => {
                console.log(res);
                self.coordinate = res.data;
            });
        },
        get_item_id: async function() {
            const self = this;
            const myHttpClient = this.axios.create({
                xsrfHeaderName: 'X-CSRF-Token',
                withCredentials: true,
            });
            const requestToken = new URLSearchParams();
            requestToken.append('token', 'item');
            await myHttpClient.post(methods.apiUrl.url + 'get_coordinate.php', requestToken).then(res => {
                //console.log(res);
                self.itemId = res.data;
            });
        },
        mergeCoordinate: function() {
            this.coordinate.forEach(cooidinate_v => {
                const tag = {
                    coordinateImg: cooidinate_v.coodinate_img,
                    coordinateItemId: [],
                };
                this.itemId.forEach(item_v => {
                    if (cooidinate_v.coordinate_id == item_v.coodinate_id) {
                        tag.coordinateItemId.push(item_v.item_id);
                    }
                });
                this.coordinateData.push(tag);
            });
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
