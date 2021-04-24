const changeUserPage = (resData, router) => {
    switch (resData) {
        case 'home':
            router.push({ name: 'Home' });
            break;
        case 'sell':
            router.push({ name: 'sell' });
            break;
        case 'rule':
            router.push({ name: 'rule' });
            break;
        case 'notice':
            router.push({ name: 'notice' });
            break;
        case 'mypage':
            router.push({ name: 'MyPage' });
            break;
        default:
            alert('エラーが発生しました');
    }
};
const apiUrl = {
    url:'http://localhost/casimas/casimas_php/',
    // url:'../../casimas_php/'
}

export default { changeUserPage,apiUrl};
