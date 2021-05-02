//レンタル通知
function rentalRequestNotice() {
    return {
        content: {},
        noticeCnt: null,
    };
}
const state = rentalRequestNotice();

const mutations = {
    getNotice(state, request) {
        state.content = request;
    },
    noticeCount(state,cnt) {
        state.noticeCnt=cnt
    },
    // logout(state) {
    //     Object.assign(state, rentalRequestNotice());
    // },
    // checkedNotice(state) {
    //     state.noticeCnt--;
    // },
    // updateNoticeState(state, key) {
    //     state.content[key].checkState = 1;
    // },
};
// const getters = {
//     noticeContent: state => state.content,
//     noticeCount: (state, getters) => {
//         return getters.noticeContent.length;
//     },
// };
// const actions = {
//     checkNotice: (commit,state) => {
//         //commit('notice/getNotice', this.noticeContent[0]);
//         state.content.forEach(e => {
//             if(e.checkState){
//                 commit('checkedNotice')
//             }
//         });
//     },
// };

const notice = {
    namespaced: true,
    state,
    mutations,
    // getters,
    // actions
};

export default notice;
