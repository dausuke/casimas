<?php
ini_set('display_errors', 1);

//関数読み込み
use Illuminate\Database\Capsule\Manager as Capsule;

require './vendor/autoload.php';

$capsule = new Capsule;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//DBの設定
$db_host = $_ENV['DB_HOST'];
$db_name = $_ENV['DB_NAME'];
$db_pass = $_ENV['DB_PASS'];
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => $db_host,
    'database'  => $db_name,
    'username'  => $db_name,
    'password'  => $db_pass,
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
]);
// $capsule->addConnection([
//     'driver'    => 'mysql',
//     'host'      => 'localhost',
//     'database'  => 'casimas',
//     'username'  => 'root',
//     'password'  => '',
//     'charset'   => 'utf8',
//     'collation' => 'utf8_unicode_ci',
// ]);

//関数読み込み
include("functions.php");

$capsule->bootEloquent();

function request_rental_notice($request_data)
{
    $pdo = connect_to_db();

    $sql='SELECT request_id,request_user,request_item,request_plan,request_price,request_state,rental_request.created_at,seller_id,item_name,nickname FROM( (rental_request LEFT OUTER JOIN item ON rental_request.request_item = item.item_id )LEFT OUTER JOIN user_data ON rental_request.request_user = userid) WHERE seller_id=:seller_id AND request_state=1';

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':seller_id', $request_data['seller_id'], PDO::PARAM_INT);

    $status = $stmt->execute();
    if ($status == false) {
        $error = $stmt->errorInfo();
        echo json_encode(["error_msg" => "{$error[2]}"]);
        exit();
    } else {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}
 function check_request_state($userid)
 {
     $pdo = connect_to_db();
     $sql='SELECT request_id,request_user,request_item,request_plan,request_price,request_state,rental_request.updated_at,seller_id,item_name,nickname FROM( (rental_request LEFT OUTER JOIN item ON rental_request.request_item = item.item_id )LEFT OUTER JOIN user_data ON rental_request.request_user = userid) WHERE request_user=:userid';

     $stmt = $pdo->prepare($sql);

     $stmt->bindValue(':userid', $userid, PDO::PARAM_INT);

     $status = $stmt->execute();
     if ($status == false) {
         $error = $stmt->errorInfo();
         echo json_encode(["error_msg" => "{$error[2]}"]);
         exit();
     } else {
         $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
         echo json_encode($result, JSON_UNESCAPED_UNICODE);
     }
 }
//リクエストトークンにより処理実行
if (filter_input(INPUT_POST, 'token')) {
    //プロフィール
    if ($_POST['token']=='seller_check') {
        request_rental_notice($_POST);
    } elseif ($_POST['token']=='user_check') {
        check_request_state($_POST['user_id']);
    }
}
