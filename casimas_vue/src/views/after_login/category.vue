<template>
    <div>
        <mainHeaderBack></mainHeaderBack>
        <main class="container-fulid user-content">
            <div class="row w-100 m-0 mt-3 py-3 category area" id="hiefht150">
                <p>[出品者身長]150cm~159cm</p>
                <ul class=" row d-flex justify-content-around m-0 p-0 w-100 category__contents">
                    <li class="col-3 m-1 p-0" v-for="(content, index) in categoryFilItem.h150" :key="index">
                        <div class=" col-12 p-0 item-area__content" @click="itemPage(content.item_id)">
                            <div class="item-img">
                                <img :src="url + content.photo1" />
                            </div>
                            <p class="m-0 p-0">{{ content.item_name }}</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="row w-100 m-0 mt-3 py-3 category area" id="heifht160">
                <p>[出品者身長]160cm~169cm</p>
                <ul class=" row d-flex justify-content-around m-0 p-0 w-100 category__contents">
                    <li class="col-3 m-1 p-0" v-for="(content, index) in categoryFilItem.h160" :key="index">
                        <div class=" col-12 p-0 item-area__content" @click="itemPage(content.item_id)">
                            <div class="item-img">
                                <img :src="url + content.photo1" />
                            </div>
                            <p class="m-0 p-0">{{ content.item_name }}</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="row w-100 m-0 mt-3 py-3 category area" id="height170">
                <p>[出品者身長]170cm~179cm</p>
                <ul class=" row d-flex justify-content-around m-0 p-0 w-100 category__contents">
                    <li class="col-3 m-1 p-0" v-for="(content, index) in categoryFilItem.h170" :key="index">
                        <div class=" col-12 p-0 item-area__content" @click="itemPage(content.item_id)">
                            <div class="item-img">
                                <img :src="url + content.photo1" />
                            </div>
                            <p class="m-0 p-0">{{ content.item_name }}</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="row w-100 m-0 mt-3 py-3 category area" id="otherItem">
                <p>other item</p>
                <ul class=" row d-flex justify-content-around m-0 p-0 w-100 category__contents">
                    <li class="col-3 m-1 p-0" v-for="(content, index) in categoryFilItem.other" :key="index">
                        <div class=" col-12 p-0 item-area__content" @click="itemPage(content.item_id)">
                            <div class="item-img">
                                <img :src="url + content.photo1" />
                                <rentaled v-show="content.rental_state_id"></rentaled>
                            </div>
                            <p class="m-0 p-0">{{ content.item_name }}</p>
                        </div>
                    </li>
                </ul>
            </div>
            <button v-if="userId.sellerid" class="btn btn-dark p-0 sell-btn" type="button"><router-link to="/sell">出品する</router-link></button>
        </main>
        <footerMenu @changePage="changePage"></footerMenu>
    </div>
</template>

<script>
import mainHeaderBack from '../../components/mainHeaderBack';
import footerMenu from '../../components/footerMenu';
import methods from '../../methods';
import Rentaled from '../../components/rentaled.vue';

export default {
    components: {
        mainHeaderBack,
        footerMenu,
        Rentaled,
    },
    data() {
        return {
            item: {},
            categoryFilItem: {
                h150: [],
                h160: [],
                h170: [],
                other: [],
            },
            userId: this.$store.state.auth,
            url: methods.apiUrl.url,
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
                        self.categoryFilItem.h150.push(v);
                        break;
                    case '[出品者身長]160cm~169cm':
                        self.categoryFilItem.h160.push(v);
                        break;
                    case '[出品者身長]170cm~179cm':
                        self.categoryFilItem.h170.push(v);
                        break;
                    case 'other item':
                        self.categoryFilItem.other.push(v);
                        break;
                }
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
