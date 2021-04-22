//ログイン・ログアウト
function userState() {
    return {
        userid: '',
        sellerid:false,
        isLogged: false,
    };
}
const state = userState();

const mutations = {
    login(state, userData) {
        state.userid = userData.userid;
        state.isLogged = true;
        if (userData.seller_id != null) {
            state.sellerid = userData.seller_id;
        }
    },
    logout(state) {
        Object.assign(state, userState());
    },
};

const auth = {
    namespaced: true,
    state,
    mutations,
};

export default auth;
