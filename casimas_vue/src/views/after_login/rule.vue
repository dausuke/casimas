<template>
    <div>
        <mainHeader></mainHeader>
        <component :is="showRule" @changeContent="changeShowRule"></component>
        <footerMenu @changePage="changePage"></footerMenu>
    </div>
</template>
<script>
import mainHeader from '../../components/mainHeader';
import footerMenu from '../../components/footerMenu';
import sellingRule from '../../components/sellingRule';
import rentalRule from '../../components/rentalRule';
import methods from '../../methods';

export default {
    components: {
        mainHeader,
        footerMenu,
        sellingRule,
        rentalRule,
    },
    data() {
        return {
            userId: this.$store.state.auth,
            showRule: 'rentalRule',
        };
    },
    created: function() {
        if (this.$store.state.auth.sellerid) {
            this.showRule = 'sellingRule';
        }
    },
    methods: {
        changePage: function(request) {
            const router = this.$router;
            methods.changeUserPage(request, router);
        },
        changeShowRule: function(showContent) {
            this.showRule = showContent;
        },
    },
};
</script>
<style>
</style>
