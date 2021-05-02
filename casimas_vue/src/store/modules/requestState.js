//レンタル希望の状態
function requeststate() {
    return {
        requeststate: '',
    };
}
const state = requeststate();

const mutations = {
    getNotice(state, payload) {
        state.requeststate = payload;
    },
};
const acrions={
    checkState(commit,userId){

    }
}

const requestState = {
    namespaced: true,
    state,
    mutations,
    acrions
};
export default requestState;
