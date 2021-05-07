<template>
    <div>
        <mainHeaderBack></mainHeaderBack>
        <main class="container-fulid user-content">
            <div class="user-content__home area user-content ">
                <h2 class="pt-3">コーディネート一覧</h2>
                <div class="row w-100 m-0">
                    <div class="item-area w-100 m-0 p-0">
                        <ul class="row m-0 p-0 w-100">
                            <li class="col-12 mb-3" v-for="(content, index) in item" :key="index">
                                <itemImg :itemContents="content" @itemPage="itemPage"></itemImg>
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
export default {

}
</script>

<style scoped>

</style>