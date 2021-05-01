<template>
    <div class="item-photo-area">
        <!-- <ul class="d-flex justify-content-center p-0 m-0"> -->
        <!-- <li class="item-img"> -->
        <div class="item-img">
            <svg v-if="cnt != 0" class="back" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M17.5 32.0833C25.5541 32.0833 32.0833 25.5542 32.0833 17.5C32.0833 9.44585 25.5541 2.91667 17.5 2.91667C9.44581 2.91667 2.91663 9.44585 2.91663 17.5C2.91663 25.5542 9.44581 32.0833 17.5 32.0833Z"
                    stroke="black"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
                <path d="M21.875 26.25L13.125 17.5L21.875 8.75" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <div class="h-100 show-area">
                <img :src="url+itemData.photo1" alt="" />
            </div>
            <svg v-if="cnt != 3" class="next" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M17.5 32.0833C25.5541 32.0833 32.0833 25.5541 32.0833 17.5C32.0833 9.44584 25.5541 2.91666 17.5 2.91666C9.44581 2.91666 2.91663 9.44584 2.91663 17.5C2.91663 25.5541 9.44581 32.0833 17.5 32.0833Z"
                    stroke="black"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
                <path d="M13.125 26.25L21.875 17.5L13.125 8.75" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
        <!-- </li>
            <li class="item-img" v-if="itemData.photo2">
                <div class="img-content" id="imgContent2" :data-url="itemData.photo2"></div>
            </li>
            <li class="item-img" v-if="itemData.photo3">
                <div class="img-content" id="imgContent3" :data-url="itemData.photo3"></div>
            </li>
            <li class="item-img" v-if="itemData.photo4">
                <div class="img-content" id="imgContent4" :data-url="itemData.photo4"></div>
            </li>
        </ul> -->
    </div>
</template>

<script>
import methods from '../methods';

export default {
    deta() {
        return {
            url: methods.apiUrl.url,
        };
    },
    props: ['itemData'],
    // created: function() {
    //     this.getPhoto();
    // },
    // methods: {
    //     getPhoto: function() {
    //         for (let i = 1; i <= 4; i++) {
    //             const imgUrl = this.url + document.getElementById('imgContent' + i).dataset.url;
    //             document.getElementById('imgContent' + i).style.backgroundImage = 'url(' + imgUrl + ')';
    //         }
    //     },
    // },
};
</script>

<style scoped>
/* .itemimg-area ul li {
    list-style: none;
    margin: 1rem;
}
.img-content {
    background-position: center center;
    background-repeat: no-repeat;
    background-size: contain;
    height: 80px;
    width: 80px;
    margin: 5px;
} */
.show-area img {
    height: 100%;
    width: auto;
}
.item-img {
    height: 200px;
    width: 100%;
    position: relative;
}
.next {
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
}
.back {
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
}
</style>
