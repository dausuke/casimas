<?php
ini_set('display_errors', 1);

use Illuminate\Database\Capsule\Manager as Capsule;

require './vendor/autoload.php';

$capsule = new Capsule;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//関数読み込み
include("functions.php");

//DBの設定
$add_connection = connect_to_db_sentinel();
$capsule->addConnection($add_connection);


$capsule->bootEloquent();

// var_dump($_POST);
// exit();
function get_all_item()
{
    $pdo = connect_to_db();

    //商品情報
    $sql = 'SELECT item.item_id,rental_state.rental_state_id,seller_id,item_name,item_introductoin,brand,purchase_judg, price_1m,price_1w,price_purchase,category_content,photo1,photo2,photo3,photo4 FROM ((((item LEFT OUTER JOIN price ON item.item_id = price.item_id) LEFT OUTER JOIN category ON item.category_id = category.category_id ) LEFT OUTER JOIN photo ON item.item_id = photo.item_id) LEFT OUTER JOIN rental_state ON item.item_id = rental_state.item_id) WHERE item.is_deleted=0';
    $stmt = $pdo->prepare($sql);
    $status = $stmt->execute();

    if ($status == false) {
        $error = $stmt->errorInfo();
        // データ登録失敗次にエラーを表示
        exit('sqlError:' . $error[2]);
    } else {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}
function get_purchase_item(){
     $pdo = connect_to_db();

    //商品情報
    $sql = "SELECT item.item_id,rental_state.rental_state_id,seller_id,item_name,item_introductoin,brand, price_1m,price_1w,price_purchase,category_content,photo1,photo2,photo3,photo4 FROM ((((item LEFT OUTER JOIN price ON item.item_id = price.item_id) LEFT OUTER JOIN category ON item.category_id = category.category_id ) LEFT OUTER JOIN photo ON item.item_id = photo.item_id) LEFT OUTER JOIN rental_state ON item.item_id = rental_state.item_id) WHERE item.is_deleted=0 AND item.purchase_judg='true'";
    $stmt = $pdo->prepare($sql);
    $status = $stmt->execute();

    if ($status == false) {
        $error = $stmt->errorInfo();
        // データ登録失敗次にエラーを表示
        exit('sqlError:' . $error[2]);
    } else {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
};

function get_selling_item($seller_id)
{
    $pdo = connect_to_db();
    //商品情報
    $sql = 'SELECT item.item_id,rental_state.rental_state_id,seller_id,seller_id,item_name,item_introductoin,brand,purchase_judg, price_1m,price_1w,price_purchase,category_content,photo1,photo2,photo3,photo4 FROM ((((item LEFT OUTER JOIN price ON item.item_id = price.item_id) LEFT OUTER JOIN category ON item.category_id = category.category_id ) LEFT OUTER JOIN photo ON item.item_id = photo.item_id) LEFT OUTER JOIN rental_state ON item.item_id = rental_state.item_id) WHERE seller_id = :seller_id AND item.is_deleted=0';

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':seller_id', $seller_id, PDO::PARAM_STR);
    $status = $stmt->execute();

    if ($status == false) {
        $error = $stmt->errorInfo();
        // データ登録失敗次にエラーを表示
        exit('sqlError:' . $error[2]);
    } else {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}
function get_item_ditail($item_id)
{
    $pdo = connect_to_db();
    //商品情報
    $sql = 'SELECT item.item_id, rental_state.rental_state_id, rental_state.rental_user_id, seller_id,item_name,item_introductoin,brand,purchase_judg, price_1m,price_1w,price_purchase,category_content FROM (((item LEFT OUTER JOIN price ON item.item_id = price.item_id) LEFT OUTER JOIN category ON item.category_id = category.category_id ) LEFT OUTER JOIN rental_state ON item.item_id = rental_state.item_id)  WHERE item.item_id = :item_id AND item.is_deleted=0';

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':item_id', $item_id, PDO::PARAM_STR);
    $status = $stmt->execute();

    if ($status == false) {
        $error = $stmt->errorInfo();
        // データ登録失敗次にエラーを表示
        exit('sqlError:' . $error[2]);
    } else {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = 'SELECT photo1,photo2,photo3,photo4 FROM photo WHERE item_id=:item_id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':item_id', $item_id, PDO::PARAM_STR);
        $status = $stmt->execute();

        if ($status == false) {
            $error = $stmt->errorInfo();
            // データ登録失敗次にエラーを表示
            exit('sqlError:' . $error[2]);
        } else {
            $result_photo = $stmt->fetch(PDO::FETCH_ASSOC);
            $result['photo'] =  $result_photo;
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }
}
function get_seller($seller_id)
{
    $pdo = connect_to_db();
    //出品者情報
    $sql = 'SELECT height FROM seller_info WHERE seller_id = :seller_id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':seller_id', $seller_id, PDO::PARAM_STR);
    $status = $stmt->execute();

    if ($status == false) {
        $error = $stmt->errorInfo();
        // データ登録失敗次にエラーを表示
        exit('sqlError:' . $error[2]);
    } else {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}
function is_rentaled($user_id)
{
    $pdo = connect_to_db();
    //商品情報
    $sql = 'SELECT rental_state.rental_user_id,rental_state.item_id,return_date,item_name,photo1 FROM ((rental_state LEFT OUTER JOIN item ON rental_state.item_id = item.item_id) LEFT OUTER JOIN photo ON rental_state.item_id=photo.item_id) WHERE rental_state.rental_user_id=:userid';

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':userid', $user_id, PDO::PARAM_STR);

    $status = $stmt->execute();

    if ($status == false) {
        $error = $stmt->errorInfo();
        // データ登録失敗次にエラーを表示
        exit('sqlError:' . $error[2]);
    } else {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}

//リクエストトークンにより処理実行
    if (filter_input(INPUT_POST, 'token')) {
        if ($_POST['token']=='selling_allitem') {
            get_selling_item($_POST['seller_id']);
        } elseif ($_POST['token']=='item_ditail') {
            get_item_ditail($_POST['item_id']);
        } elseif ($_POST['token']=='seller') {
            get_seller($_POST['seller_id']);
        } elseif ($_POST['token']=='all_item') {
            get_all_item();
        } elseif ($_POST['token']=='rentaled') {
            is_rentaled($_POST['user_id']);
        }elseif ($_POST['token']=='purchase') {
            get_purchase_item();
        }
    }
