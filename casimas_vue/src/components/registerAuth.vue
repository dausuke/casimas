<template>
    <div>
        <validation-observer ref="obs" v-slot="ObserverProps">
            <div class="container register-form w-lg-50">
                <div class="row justify-content-center">
                    <div class="form-group col-4">
                        <label for="formGroupFirstNameInput">姓</label>
                        <validation-provider rules="required">
                            <div slot-scope="ProviderProps">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="formGroupFirstNameInput"
                                    v-model="userData.firstName"
                                />
                                <p class="error-message">
                                    {{ ProviderProps.errors[0] }}
                                </p>
                            </div>
                        </validation-provider>
                    </div>
                    <div class="form-group col-4">
                        <label for="formGroupLastNamelInput">名</label>
                        <validation-provider rules="required">
                            <div slot-scope="ProviderProps">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="formGroupLastNamelInput"
                                    v-model="userData.lastName"
                                />
                                <p class="error-message">
                                    {{ ProviderProps.errors[0] }}
                                </p>
                            </div>
                        </validation-provider>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-8">
                        <label for="formGroupEmailInput">メールアドレス</label>
                        <validation-provider rules="email|required">
                            <div slot-scope="ProviderProps">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="formGroupEmailInput"
                                    name="email"
                                    v-model="userData.mail"
                                />
                                <p class="error-message">
                                    {{ ProviderProps.errors[0] }}
                                </p>
                            </div>
                        </validation-provider>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-8">
                        <label for="formGroupPasswordInput">パスワード</label>
                        <validation-provider rules="required|min:6|max:12|regex:^[a-zA-Z0-9!-/:-@¥[-`{-~]+$">
                            <div slot-scope="ProviderProps">
                                <input
                                    type="password"
                                    class="form-control"
                                    id="formGroupPasswordInput"
                                    vid="password"
                                    v-model="userData.pass"
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
                    <div class="form-group col-8">
                        <label for="formGroupPasswordInput">
                            パスワード確認用
                        </label>
                        <validation-provider rules="required|min:6|max:12|regex:^[a-zA-Z0-9!-/:-@¥[-`{-~]+$">
                            <div slot-scope="ProviderProps">
                                <input
                                    type="password"
                                    class="form-control"
                                    id="formGroupConfirmedPasswordInput"
                                    v-model="userData.confirmPass"
                                />
                                <p class="error-message">
                                    {{ ProviderProps.errors[0] }}
                                </p>
                                <p class="error-message" v-if="confirm">
                                    パスワードが一致しません
                                </p>
                            </div>
                        </validation-provider>
                    </div>
                </div>
                <div class="row justify-content-center mt-5">
                    <div class="form-group col-6">
                        <button
                            type="button"
                            class="btn btn-dark form-control"
                            id="registerBtn"
                            @click="$emit('nextPage', userData)"
                            :disabled="
                                ObserverProps.invalid ||
                                    !ObserverProps.validated ||
                                    isDisabled
                            "
                        >
                            次へ
                        </button>
                    </div>
                </div>
            </div>
        </validation-observer>
    </div>
</template>
<script>
export default {
    data() {
        return {
            userData: {
                firstName: null,
                lastName: null,
                mail: null,
                pass: null,
                confirmPass: null,
            },
            isDisabled: false,
            confirm: false,
        };
    },
    props: {
        data: Object,
    },
    created: function() {
        this.userData.firstName = this.data.firstName;
        this.userData.lastName = this.data.lastName;
        this.userData.mail = this.data.mail;
        this.userData.pass = this.data.pass;
    },
    watch: {
        userData: {
            deep: true,
            handler: function() {
                if (this.userData.confirmPass != null) {
                    if (this.userData.confirmPass != this.userData.pass) {
                        this.confirm = true;
                        this.isDisabled = true;
                    } else {
                        this.confirm = false;
                        this.isDisabled = false;
                    }
                }
            },
        },
    },
};
</script>
<style scoped>
.attention {
    color: rgb(80, 79, 79);
    font-size: 14px;
}
.error-message {
    color: red;
}
</style>
