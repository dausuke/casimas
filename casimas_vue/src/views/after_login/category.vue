<template>
    <div>
        <mainHeaderBack></mainHeaderBack>
        <main class="container-fulid user-content">
            <div
                v-for="(filterItem, index) in categoryFilItem"
                :key="index"
                class="row flex-nowrap flex-column w-100 m-0 mt-3 py-3 category area swipe-content"
                id="hiefht150"
            >
                <p class="text-left font-weight-bold">{{index}}</p>
                <ul class="d-flex m-0 p-0 w-100 category__contents" id="swipeArea">
                    <li
                        class="col-12"
                        v-for="(content, index) in filterItem"
                        :key="index"
                        @touchstart="touchStart"
                        @touchmove="touchMove"
                        @touchend="touchEnd(filterItem.length)"
                    >
                        <itemImg :itemContents="content"></itemImg>
                    </li>
                </ul>
            </div>
            <!-- <div class="row flex-nowrap flex-column w-100 m-0 mt-3 py-3 category area" id="heifht160">
                <p class="text-left font-weight-bold">[出品者身長]160cm~169cm</p>
                <ul class="d-flex  m-0 p-0 w-100 category__contents">
                    <li class="col-12" v-for="(content, index) in categoryFilItem.h160" :key="index">
                        <itemImg :itemContents="content"></itemImg>
                    </li>
                </ul>
            </div>
            <div class="row flex-nowrap flex-column w-100 m-0 mt-3 py-3 category area" id="height170">
                <p class="text-left font-weight-bold">[出品者身長]170cm~179cm</p>
                <ul class="d-flex  m-0 p-0 w-100 category__contents">
                    <li class="col-12" v-for="(content, index) in categoryFilItem.h170" :key="index">
                        <itemImg :itemContents="content"></itemImg>
                    </li>
                </ul>
            </div>
            <div class="row flex-nowrap flex-column w-100 m-0 mt-3 py-3 category area" id="otherItem">
                <p class="text-left font-weight-bold">other item</p>
                <ul class="d-flex  m-0 p-0 w-100 category__contents">
                    <li class="col-12" v-for="(content, index) in categoryFilItem.other" :key="index">
                        <itemImg :itemContents="content"></itemImg>
                    </li>
                </ul>
            </div> -->
            <button v-if="userId.sellerid" class="btn btn-dark p-0 sell-btn" type="button"><router-link to="/sell">出品する</router-link></button>
        </main>
        <footerMenu @changePage="changePage" :noticeCnt="noticeCnt"></footerMenu>
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
            item: {},
            categoryFilItem: {
                '[出品者身長]150cm~159cm': [],
                '[出品者身長]160cm~169cm': [],
                '[出品者身長]170cm~179cm': [],
                'OTHER ITEM': [],
            },
            userId: this.$store.state.auth,
            url: methods.apiUrl.url,
            noticeCnt: this.$store.state.notice.noticeCnt,
            position: 0,
            startX: 0,
            moveX: 0,
            width: 0,
            id: 1,
        };
    },
    created: function() {
        this.categoryFilter();
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
                    token: 'all_item',
                })
                .then(value => {
                    self.item = value;
                });
        },
        categoryFilter: async function() {
            await this.getItem();
            const self = this;
            this.item.forEach(v => {
                switch (v.category_content) {
                    case '[出品者身長]150cm~159cm':
                        self.categoryFilItem['[出品者身長]150cm~159cm'].push(v);
                        break;
                    case '[出品者身長]160cm~169cm':
                        self.categoryFilItem['[出品者身長]160cm~169cm'].push(v);
                        break;
                    case '[出品者身長]170cm~179cm':
                        self.categoryFilItem['[出品者身長]170cm~179cm'].push(v);
                        break;
                    case 'other item':
                        self.categoryFilItem['OTHER ITEM'].push(v);
                        break;
                }
            });
        },
        touchStart(e) {
            this.width = document.getElementById('swipeArea').offsetWidth;
            this.startX = e.touches[0].pageX;
        },
        touchMove(e) {
            this.moveX = e.touches[0].pageX - this.startX;
            document.getElementById('swipeArea').style.transitionDuration = '0ms';
            document.getElementById('swipeArea').style.transform = `translate3d(${this.moveX + this.position}px,0,0)`;
        },
        touchEnd(length) {
            if (this.moveX > 10 && this.id !== 1) {
                const swipeArea = document.getElementById('swipeArea');
                this.position = this.position + this.width;
                document.getElementById('swipeArea').style.transitionDuration = '300ms';
                swipeArea.style.transform = `translate3d(${this.position}px,0,0)`;
                console.log('右スワイプ');
                this.id--;
            } else if (this.moveX < -10 && this.id !== length) {
                this.position = this.position - this.width;
                document.getElementById('swipeArea').style.transitionDuration = '300ms';
                document.getElementById('swipeArea').style.transform = `translate3d(${this.position}px,0,0)`;
                console.log('左スワイプ');
                this.id++;
            } else {
                document.getElementById('swipeArea').style.transitionDuration = '300ms';
                document.getElementById('swipeArea').style.transform = `translate3d(${this.position}px,0,0)`;
            }
        },
    },
};
</script>

<style scoped>
.swipe-content {
    overflow-x: hidden;
}
ul {
    transform: translate3d(0px, 0, 0);
    transition-duration: 300ms;
}
ul li {
    flex-shrink: 0;
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
.category p {
    margin-left: 1rem;
}
.category__contents__item {
    height: 80px;
    width: 80px;
    background-color: black;
}
.category__contents li {
    list-style: none;
}
.item-img {
    height: 87px;
    width: 87px;
    position: relative;
}
.item-img img {
    height: 87px;
    width: 87px;
    object-fit: cover;
}
</style>
