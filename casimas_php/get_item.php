<?php
ini_set('display_errors', 1);

use Illuminate\Database\Capsule\Manager as Capsule;

require './vendor/autoload.php';

$capsule = new Capsule;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//DBの設定
// $db_host = $_ENV['DB_HOST'];
// $db_name = $_ENV['DB_NAME'];
// $db_pass = $_ENV['DB_PASS'];
// $capsule->addConnection([
//     'driver'    => 'mysql',
//     'host'      => $db_host,
//     'database'  => $db_name,
//     'username'  => $db_name,
//     'password'  => $db_pass,
//     'charset'   => 'utf8',
//     'collation' => 'utf8_unicode_ci',
// ]);
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'casimas',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
]);

//関数読み込み
include("functions.php");
cors_config();

$capsule->bootEloquent();

// var_dump($_POST);
// exit();
function get_all_item()
{
    $pdo = connect_to_db();

    //商品情報
    $sql = 'SELECT item.item_id ,seller_id,item_name,item_introductoin,brand,purchase_judg, price_1m,price_1w,price_purchase,category_content,photo1,photo2,photo3,photo4 FROM (((item LEFT OUTER JOIN price ON item.item_id = price.item_id) LEFT OUTER JOIN category ON item.category_id = category.category_id ) LEFT OUTER JOIN photo ON item.item_id = photo.item_id)';
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
function get_selling_item($seller_id)
{
    $pdo = connect_to_db();
    //商品情報
    $sql = 'SELECT item.item_id ,seller_id,item_name,item_introductoin,brand,purchase_judg, price_1m,price_1w,price_purchase,category_content,photo1,photo2,photo3,photo4 FROM (((item LEFT OUTER JOIN price ON item.item_id = price.item_id) LEFT OUTER JOIN category ON item.category_id = category.category_id ) LEFT OUTER JOIN photo ON item.item_id = photo.item_id) WHERE seller_id = :seller_id';

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

//     var_dump($item_id);
    // exit();
    $pdo = connect_to_db();
    //商品情報
    $sql = 'SELECT item.item_id ,seller_id,item_name,item_introductoin,brand,purchase_judg, price_1m,price_1w,price_purchase,category_content,photo1,photo2,photo3,photo4 FROM (((item LEFT OUTER JOIN price ON item.item_id = price.item_id) LEFT OUTER JOIN category ON item.category_id = category.category_id ) LEFT OUTER JOIN photo ON item.item_id = photo.item_id) WHERE item.item_id = :item_id';

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':item_id', $item_id, PDO::PARAM_STR);
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

//リクエストトークンにより処理実行
    if (filter_input(INPUT_POST, 'token')) {
        if ($_POST['token']=='selling_allitem') {
            get_selling_item($_POST['seller_id']);
        } elseif ($_POST['token']=='item_ditail') {
            get_item_ditail($_POST['item_id']);
        } elseif ($_POST['token']=='seller') {
            get_seller($_POST['seller_id']);
        } elseif($_POST['token']=='all_item'){
            get_all_item();
        }
    }
