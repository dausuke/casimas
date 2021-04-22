<template>
    <div class="register">
        <topHeader />
        <h1>This is an register page</h1>
        <component :is="currentView" :data="userData" @nextPage="next" @beforePage="before" @creatAccount="submit"></component>
    </div>
</template>
<script>
import topHeader from '../components/topPageHeader';
import registerAuth from '../components/registerAuth';
import registerDitail from '../components/registerDitail';

export default {
    name: 'register',
    components: {
        topHeader,
        registerAuth,
        registerDitail,
    },
    data() {
        return {
            userData: {
                firstName: null,
                lastName: null,
                mail: null,
                pass: null,
                userDitailData: {
                    gender: null,
                    address: null,
                    phone: null,
                    nickname: null,
                    introduction: null,
                    height: null,
                    isSeller: false,
                },
            },
            token: 'register',
            currentView: 'registerAuth',
        };
    },
    methods: {
        submit: function(userDitailData) {
            this.userData.userDitailData = userDitailData;
            const myHttpClient = this.axios.create({
                xsrfHeaderName: 'X-CSRF-Token',
                withCredentials: true,
            });
            const user_data = new URLSearchParams();
            const birthday = String(this.userData.userDitailData.birthday_y)+'年'+String(this.userData.userDitailData.birthday_m)+'月'+String(this.userData.userDitailData.birthday_d)+'日';
            console.log(birthday);
            user_data.append('first_name', this.userData.firstName);
            user_data.append('last_name', this.userData.lastName);
            user_data.append('mail', this.userData.mail);
            user_data.append('pass', this.userData.pass);
            user_data.append('gender', this.userData.userDitailData.gender);
            user_data.append('address', this.userData.userDitailData.address);
            user_data.append('phone', this.userData.userDitailData.phone);
            user_data.append('birthday', birthday);
            user_data.append('nickname', this.userData.userDitailData.nickname);
            user_data.append('introduction', this.userData.userDitailData.introduction);
            user_data.append('isSeller', this.userData.userDitailData.isSeller);
            user_data.append('bank', this.userData.userDitailData.sellerData.bank);
            user_data.append('bank_branch', this.userData.userDitailData.sellerData.branch);
            user_data.append('account_type', this.userData.userDitailData.sellerData.accountType);
            user_data.append('account_number', this.userData.userDitailData.sellerData.accountNumber);
            user_data.append('account_holder', this.userData.userDitailData.sellerData.accountHolder);
            user_data.append('height', this.userData.userDitailData.sellerData.height);
            user_data.append('token', this.token);
            myHttpClient
                .post('http://localhost/casimas/casimas_php/auth.php', user_data)
                .then(function(res) {
                    console.log(res);
                })
                .catch(function() {
                    alert('通信エラーが発生しました');
                })
                .finally(function() {});
            this.$router.push({ name: 'top' });
        },
        next: function(userData) {
            this.userData.firstName = userData.firstName;
            this.userData.lastName = userData.lastName;
            this.userData.mail = userData.mail;
            this.userData.pass = userData.pass;
            this.currentView = 'registerDitail';
        },
        before: function() {
            this.currentView = 'registerAuth';
        },
    },
};
</script>
<style scoped>
.error-message {
    color: red;
}
.register-form {
    margin: 0 auto;
}
</style>
