<template>
    <div class="swipe-content">
        <ul class="d-flex p-0 m-0 w-100" id="swipeArea">
            <li class="m-0 col-12" v-for="(img, key) in images" :key="key" ref="swipe" @touchstart="touchStart" @touchmove="touchMove" @touchend="touchEnd">
                <div class="m-0 item-img">
                    <div class="m-0 img-content" :id="'imgContent' + key" :data-url="img"></div>
                    <p>{{ key + 1 }}/{{ images.length }}</p>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
import methods from '../methods';
export default {
    props: ['photo'],
    data() {
        return {
            images: [],
            url: methods.apiUrl.url,
            position: 0,
            startX: 0,
            moveX: 0,
            width: 0,
            id: 1,
        };
    },
    created: function() {
        Object.keys(this.photo).forEach(key => {
            if (this.photo[key]) {
                this.images.push(this.photo[key]);
            }
        });
    },
    mounted: function() {
        this.getPhoto();
    },
    methods: {
        getPhoto: function() {
            for (let i = 0; i <= 3; i++) {
                const imgUrl = this.url + document.getElementById('imgContent' + i).dataset.url;
                document.getElementById('imgContent' + i).style.backgroundImage = 'url(' + imgUrl + ')';
            }
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
        touchEnd() {
            console.log(this.elapsedTime);
            if (this.moveX > 10 && this.id !== 1) {
                this.position = this.position + this.width;
                const swipeArea = document.getElementById('swipeArea');
                document.getElementById('swipeArea').style.transitionDuration = '300ms';
                swipeArea.style.transform = `translate3d(${this.position}px,0,0)`;
                console.log('右スワイプ');
                this.id--;
            } else if (this.moveX < -10 && this.id !== this.images.length) {
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
    list-style: none;
    flex-shrink: 0;
}
.item-img {
    height: 220px;
    width: 100%;
}
.img-content {
    background-position: center center;
    background-repeat: no-repeat;
    background-size: contain;
    height: 200px;
    width: auto;
    margin: 5px;
}
</style>
