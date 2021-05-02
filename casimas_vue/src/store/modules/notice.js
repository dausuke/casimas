//レンタル通知
function rentalRequestNotice() {
    return {
        content:{},
    };
}
const state = rentalRequestNotice();

const mutations = {
    getNotice(state, request) {
        state.content = request
    },
    logout(state) {
        Object.assign(state, rentalRequestNotice());
    },
};

const notice = {
    namespaced: true,
    state,
    mutations,
};

export default notice;
