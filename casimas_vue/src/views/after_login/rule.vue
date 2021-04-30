<template>
    <div>
        <mainHeader></mainHeader>
        <component :is="showRule" @change="changeShowRule"></component>
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
            userId:this.$store.state.auth,
            showRule: 'rentalRule',
        };
    },
    created:function(){
        if(this.userId.sellerid){
            this.showRule = 'sellingRule'
        }
    },
    methods: {
        changePage: function(request) {
            const router = this.$router;
            methods.changeUserPage(request, router);
        },
        changeShowRule:function(showContent){
            this.showRule=showContent
        }
    },
};
</script>
<style scoped>
.user-content {
    font-size: 12px;
}
.rule-container p,
.rule-container span {
    text-align: left;
    overflow-wrap: break-word;
    margin: 0;
}
.rule-container span {
    margin-bottom: 1rem;
}
.rule-container p.rule-heading {
    font-size: 14px;
    font-weight: bold;
}
.indent {
    padding-left: 2em;
}
.table {
    border: 1px solid #eee;
}
.table td {
    font-size: 10px;
}
.rentalRule{
    color: rgb(35, 35, 243);
}
</style>
