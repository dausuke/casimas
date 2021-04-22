<template>
    <div class="login">
        <topHeader />
        <h1>This is an login page</h1>
        <validation-observer ref="obs" v-slot="ObserverProps">
            <div class="container login-form">
                <div class="row justify-content-center">
                    <div class="col-8 col-lg-4 erroArea" v-if="error">
                        <p class="error-message">
                            {{ errorMesseage }}
                        </p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-8 col-lg-4">
                        <label for="formGroupEmailInput">メールアドレス</label>
                        <validation-provider rules="email|required">
                            <div slot-scope="ProviderProps">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="formGroupEmailInput"
                                    placeholder="メールアドレス"
                                    name="email"
                                    v-model="useraData.mail"
                                />
                                <p class="error-message">
                                    {{ ProviderProps.errors[0] }}
                                </p>
                            </div>
                        </validation-provider>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-8 col-lg-4">
                        <label for="formGroupPasswordInput">パスワード</label>
                        <validation-provider rules="min:6|max:12|required">
                            <div slot-scope="ProviderProps">
                                <input
                                    type="password"
                                    class="form-control"
                                    id="formGroupPasswordInput"
                                    placeholder="パスワード"
                                    name="password"
                                    v-model="useraData.pass"
                                />
                                <p class="attention">
                                    6文字以上12文字以内で入力してください
                                </p>
                                <p class="error-message">
                                    {{ ProviderProps.errors[0] }}
                                </p>
                            </div>
                        </validation-provider>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-8 col-lg-4">
                        <button
                            type="button"
                            class="btn btn-dark form-control"
                            id="login_btn"
                            @click="submitForm"
                            :disabled="ObserverProps.invalid || !ObserverProps.validated"
                        >
                            ログイン
                        </button>
                    </div>
                </div>
            </div>
        </validation-observer>
    </div>
</template>
<script>
import topHeader from '../components/topPageHeader';
export default {
    name: 'login',
    components: {
        topHeader,
    },
    data() {
        return {
            useraData: {
                mail: null,
                pass: null,
                token: 'login',
            },
            responsData: null,
            error: false,
            errorMesseage: '',
        };
    },
    methods: {
        submitForm: function() {
            const self = this;
            const myHttpClient = this.axios.create({
                xsrfHeaderName: 'X-CSRF-Token',
                withCredentials: true,
            });
            const user_data = new URLSearchParams();
            user_data.append('mail', this.useraData.mail);
            user_data.append('pass', this.useraData.pass);
            user_data.append('token', this.useraData.token);
            myHttpClient
                .post('http://localhost/casimas/casimas_php/auth.php', user_data)
                .then(function(res) {
                    console.log(res.data);
                    self.responsData = res.data;
                })
                .catch(function() {})
                .finally(function() {});

            //console.log(this.responsData)
        },
    },

    watch: {
        responsData: function() {
            if (this.responsData != false) {
                this.$store.commit('auth/login', this.responsData);
                this.$router.push({ name: 'Home' });
            } else {
                this.errorMesseage = 'メールアドレスまたはパスワードが違います';
                this.error = true;
            }
        },
    },
};
</script>
<style scoped>
.error-message {
    color: red;
}
.attention {
    color: rgb(32, 33, 34);
    font-size: 12px;
}
</style>
