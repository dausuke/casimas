import Vue from 'vue';

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
    url: 'https://casimas.lolipop.io/casimas_php/',
    // url: '../../casimas_php/',
};
let resposData = {};

const getItem = async requestData => {
    const myHttpClient = Vue.axios.create({
        xsrfHeaderName: 'X-CSRF-Token',
        withCredentials: true,
    });
    const requestItem = new URLSearchParams();
    switch (requestData.token) {
        case 'all_item':
            requestItem.append('token', requestData.token);
            await myHttpClient.post(apiUrl.url + 'get_item.php', requestItem).then(res => {
                resposData = res.data;
            });
            return resposData;
        case 'item_ditail':
            requestItem.append('token', requestData.token);
            requestItem.append('item_id', requestData.itemId);
            await myHttpClient.post(apiUrl.url + 'get_item.php', requestItem).then(res => {
                resposData = res.data;
            });
            return resposData;
        case 'rentaled':
            requestItem.append('token', requestData.token);
            requestItem.append('user_id', requestData.userId);
            await myHttpClient.post(apiUrl.url + 'get_item.php', requestItem).then(res => {
                resposData = res.data;
            });
            return resposData;
        case 'selling_allitem':
            console.log(requestData.userId);
            requestItem.append('token', requestData.token);
            requestItem.append('seller_id', requestData.userId);
            await myHttpClient.post(apiUrl.url + 'get_item.php', requestItem).then(res => {
                resposData = res.data;
            });
            return resposData;
    }
};
const getSeller = async requestData => {
    const myHttpClient = Vue.axios.create({
        xsrfHeaderName: 'X-CSRF-Token',
        withCredentials: true,
    });
    let sellerHeight;
    const sellerHeightRequest = new URLSearchParams();
    sellerHeightRequest.append('seller_id', requestData.sellerId);
    sellerHeightRequest.append('token', requestData.token);

    await myHttpClient.post(apiUrl.url + 'get_item.php', sellerHeightRequest).then(res => {
        sellerHeight = res.data;
    });
    return sellerHeight;
};
const rentalAction = async requestData => {
    const myHttpClient = Vue.axios.create({
        xsrfHeaderName: 'X-CSRF-Token',
        withCredentials: true,
    });
    const rentalData = new URLSearchParams();
    switch (requestData.token) {
        case 'rental':
            rentalData.append('token', requestData.token);
            rentalData.append('user_id', requestData.userId);
            rentalData.append('item_id', requestData.itemId);
            rentalData.append('seller_id', requestData.sellerId);
            rentalData.append('plan', requestData.plan);
            rentalData.append('transaction_price', requestData.transactionPlace);
            myHttpClient.post(apiUrl.url + 'rental.php', rentalData).then(() => {});
            break;
        case 'return':
            rentalData.append('rental_state_id', requestData.rentalStateId);
            rentalData.append('token', requestData.token);
            myHttpClient.post(apiUrl.url + 'rental.php', rentalData).then(() => {});
            break;
    }
};
const sellerAction = async requestData => {
    const myHttpClient = Vue.axios.create({
        xsrfHeaderName: 'X-CSRF-Token',
        withCredentials: true,
    });
    const itemData = new URLSearchParams();
    switch (requestData.token) {
        case 'edit':
            itemData.append('item_id', requestData.itemId);
            itemData.append('item_introductoin', requestData.itemIntroductoin);
            itemData.append('item_name', requestData.itemName);
            itemData.append('price_1m', requestData.price1m);
            itemData.append('price_1w', requestData.price1w);
            itemData.append('price_purchase', requestData.pricePurchase);
            itemData.append('purchase_judg', requestData.purchaseJudg);
            itemData.append('token', requestData.token);
            myHttpClient.post(apiUrl.url + 'edit_item.php', itemData).then(() => {});
            break;
        case 'delete':
            itemData.append('item_id', requestData.itemId);
            itemData.append('token', requestData.token);
            myHttpClient.post(apiUrl.url + 'edit_item.php', itemData).then(() => {});
            break;
    }
};
const mypageAction = async requestData => {
    const myHttpClient = Vue.axios.create({
        xsrfHeaderName: 'X-CSRF-Token',
        withCredentials: true,
    });
    const requestUserData = new URLSearchParams();
    switch (requestData.token) {
        case 'getuser':
            requestUserData.append('token', requestData.token);
            requestUserData.append('user_id', requestData.userId);
            await myHttpClient.post(apiUrl.url + 'mypage.php', requestUserData).then(res => {
                resposData = res.data;
            });
            return resposData;
        case 'updade_profile':
            requestUserData.append('token', requestData.token);
            requestUserData.append('user_id', requestData.userId);
            requestUserData.append('nickname', requestData.nickname);
            requestUserData.append('introduction', requestData.introduction);
            myHttpClient.post(apiUrl.url + 'mypage.php', requestUserData).then((res) => {
                console.log(res)
            });
            break;
        case 'update_account':
            requestUserData.append('token', requestData.token);
            requestUserData.append('user_id', requestData.userId);
            requestUserData.append('address', requestData.address);
            requestUserData.append('phone', requestData.phone);
            requestUserData.append('email', requestData.email);
            myHttpClient.post(apiUrl.url + 'mypage.php', requestUserData).then((res) => {
                console.log(res)
            });
            break;
    }
};
export default { changeUserPage, apiUrl, getItem, getSeller, rentalAction, sellerAction, mypageAction };
