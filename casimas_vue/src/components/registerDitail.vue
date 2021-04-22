<template>
    <div>
        <validation-observer ref="obs" v-slot="ObserverProps">
            <div class="container register-ditail-form w-lg-50">
                <div class="row justify-content-center">
                    <div class="form-group col-4 ">
                        <label for="formGroupGenderInput">性別</label>
                        <validation-provider rules="required|oneOf:男性,女性">
                            <div slot-scope="ProviderProps">
                                <select class="custom-select" v-model="userDitailData.gender" id="formGroupGenderInput">
                                    <option selected>性別を選択</option>
                                    <option value="男性">男性</option>
                                    <option value="女性">女性</option>
                                </select>
                                <p class="error-message">
                                    {{ ProviderProps.errors[0] }}
                                </p>
                            </div>
                        </validation-provider>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-12">
                        <label for="formGroupAddressInput">住所</label>
                        <validation-provider rules="required">
                            <div slot-scope="ProviderProps">
                                <input type="text" class="form-control" v-model="userDitailData.address" />
                                <p class="error-message">
                                    {{ ProviderProps.errors[0] }}
                                </p>
                            </div>
                        </validation-provider>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-8">
                        <label for="formGroupPhoneInput">電話番号</label>
                        <validation-provider rules="required|numeric">
                            <div slot-scope="ProviderProps">
                                <input type="phone" class="form-control" id="formGroupPhoneInput" v-model="userDitailData.phone" />
                                <p class="error-message">
                                    {{ ProviderProps.errors[0] }}
                                </p>
                            </div>
                        </validation-provider>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-8">
                        <label>生年月日</label>
                        <validation-provider rules="required">
                            <div slot-scope="ProviderProps">
                                <select class="custom-select col-6" v-model="userDitailData.birthday_y">
                                    <option v-for="i in 70" :key="i" :value="i+1940">{{i+1940}}年</option>
                                </select>
                                <select class="custom-select col-3" v-model="userDitailData.birthday_m">
                                    <option v-for="i in 12" :key="i" :value="i">{{i}}月</option>
                                </select>
                                <select class="custom-select col-3" v-model="userDitailData.birthday_d">
                                    <option v-for="i in 31" :key="i" :value="i">{{i}}日</option>
                                </select>
                                <p class="error-message">
                                    {{ ProviderProps.errors[0] }}
                                </p>
                            </div>
                        </validation-provider>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-8">
                        <label for="formGroupNicknameInput">ニックネーム</label>
                        <validation-provider rules="required">
                            <div slot-scope="ProviderProps">
                                <input type="text" class="form-control" id="formGroupNicknameInput" v-model="userDitailData.nickname" />
                                <p class="error-message">
                                    {{ ProviderProps.errors[0] }}
                                </p>
                            </div>
                        </validation-provider>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-8">
                        <label for="formGroupintroductionInput">自己紹介</label>
                        <validation-provider rules="required">
                            <div slot-scope="ProviderProps">
                                <textarea type="text" class="form-control" id="formGroupintroductionInput" v-model="userDitailData.introduction"></textarea>
                                <p class="error-message">
                                    {{ ProviderProps.errors[0] }}
                                </p>
                            </div>
                        </validation-provider>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-8">
                        <label for="formGroupIsSellerInput">出品者（販売員）として登録する</label>
                        <input type="checkbox" class="form-control" id="formGroupIsSellerInput" v-model="userDitailData.isSeller" />
                    </div>
                </div>
                <div v-if="userDitailData.isSeller">
                    <div class="row justify-content-center">
                        <div class="form-group col-8">
                            <label for="formGroupHeightInput">身長</label>
                            <validation-provider rules="required|numeric">
                                <div slot-scope="ProviderProps">
                                    <input type="text" class="form-control" id="formGroupHeightInput" v-model="userDitailData.sellerData.height" />
                                    <p class="error-message">
                                        {{ ProviderProps.errors[0] }}
                                    </p>
                                </div>
                            </validation-provider>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group col-4">
                            <label for="formGroupHeightInput">金融機関名</label>
                            <validation-provider rules="required">
                                <div slot-scope="ProviderProps">
                                    <input type="text" class="form-control" id="formGroupBankInput" v-model="userDitailData.sellerData.bank" />
                                    <p class="error-message">
                                        {{ ProviderProps.errors[0] }}
                                    </p>
                                </div>
                            </validation-provider>
                        </div>
                        <div class="form-group col-4">
                            <label for="formGroupHeightInput">支店名</label>
                            <validation-provider rules="required">
                                <div slot-scope="ProviderProps">
                                    <input type="text" class="form-control" id="formGroupBranchInput" v-model="userDitailData.sellerData.branch" />
                                    <p class="error-message">
                                        {{ ProviderProps.errors[0] }}
                                    </p>
                                </div>
                            </validation-provider>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group col-4">
                            <label for="formGroupHeightInput">口座種別</label>
                            <validation-provider rules="required|oneOf:普通,当座,定期">
                                <div slot-scope="ProviderProps">
                                    <select class="custom-select" v-model="userDitailData.sellerData.accountType" id="formGroupAccountTypeInput">
                                        <option value="普通">普通</option>
                                        <option value="当座">当座</option>
                                        <option value="定期">定期</option>
                                    </select>
                                    <p class="error-message">
                                        {{ ProviderProps.errors[0] }}
                                    </p>
                                </div>
                            </validation-provider>
                        </div>
                        <div class="form-group col-4">
                            <label for="formGroupHeightInput">口座番号</label>
                            <validation-provider rules="required|numeric">
                                <div slot-scope="ProviderProps">
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="formGroupAccountNumberInput"
                                        v-model="userDitailData.sellerData.accountNumber"
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
                            <label for="formGroupHeightInput">口座名義</label>
                            <validation-provider rules="required">
                                <div slot-scope="ProviderProps">
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="formGroupAccountHolderInput"
                                        v-model="userDitailData.sellerData.accountHolder"
                                    />
                                    <p class="error-message">
                                        {{ ProviderProps.errors[0] }}
                                    </p>
                                </div>
                            </validation-provider>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-5">
                    <div class="form-group col-6">
                        <button type="button" class="btn btn-dark form-control" id="beforeBtn" @click="$emit('beforePage')">
                            前へ
                        </button>
                    </div>
                    <div class="form-group col-6">
                        <button
                            type="button"
                            class="btn btn-dark form-control"
                            id="registerBtn"
                            @click="$emit('creatAccount', userDitailData)"
                            :disabled="ObserverProps.invalid || !ObserverProps.validated"
                        >
                            新規登録
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
            userDitailData: {
                gender: null,
                address: null,
                phone: null,
                birthday_y:null,
                birthday_m:null,
                birthday_d:null,
                birthday: null,
                nickname: null,
                introduction: null,
                height: null,
                isSeller: false,
                sellerData: {
                    height: null,
                    bank: null,
                    branch: null,
                    accountType: null,
                    accountNumber: null,
                    accountHolder: null,
                },
            },
        };
    },
};
</script>
<style scoped>
.error-message {
    color: red;
}
</style>
