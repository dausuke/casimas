//レンタル通知
function rentalRequestNotice() {
    return {
        contents:{}
    };
}
const state = rentalRequestNotice();

const mutations = {
    getNotice(state, request) {
        state.contents = request
    },
};

const notice = {
    namespaced: true,
    state,
    mutations,
};

export default notice;
