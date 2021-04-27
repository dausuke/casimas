<?php
ini_set('display_errors', 1);

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

function deleteItem($item_id)
{
    $pdo = connect_to_db();

    $sql = 'UPDATE item SET is_deleted=1 WHERE item_id=:item_id';

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':item_id', $item_id['item_id'], PDO::PARAM_STR);

    $status = $stmt->execute();
    // データ登録処理後
    if ($status == false) {
        // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
        $error = $stmt->errorInfo();
        echo json_encode(["error_msg" => "{$error[2]}"]);
        exit();
    }
};

function editItem($item_data)
{
    // var_dump($item_data);
    // exit();
    $pdo = connect_to_db();

    $sql = 'UPDATE item SET item_name=:item_name,item_introductoin=:item_introductoin,purchase_judg=:purchase_judg WHERE item_id=:item_id';

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':item_id', $item_data['item_id'], PDO::PARAM_STR);
    $stmt->bindValue(':item_name', $item_data['item_name'], PDO::PARAM_STR);
    $stmt->bindValue(':item_introductoin', $item_data['item_introductoin'], PDO::PARAM_STR);
    $stmt->bindValue(':purchase_judg', $item_data['purchase_judg'], PDO::PARAM_STR);
    $status = $stmt->execute();
    // データ登録処理後
    if ($status == false) {
        // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
        $error = $stmt->errorInfo();
        echo json_encode(["error_msg" => "{$error[2]}"]);
        exit();
    } else {
        $sql = 'UPDATE price SET price_1m=:price_1m,price_1w=:price_1w,price_purchase=:price_purchase WHERE item_id=:item_id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':item_id', $item_data['item_id'], PDO::PARAM_STR);
        $stmt->bindValue(':price_1m', $item_data['price_1m'], PDO::PARAM_STR);
        $stmt->bindValue(':price_1w', $item_data['price_1w'], PDO::PARAM_STR);
        $stmt->bindValue(':price_purchase', $item_data['price_purchase'], PDO::PARAM_STR);
        $status = $stmt->execute();
        if ($status == false) {
            // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
            $error = $stmt->errorInfo();
            echo json_encode(["error_msg" => "{$error[2]}"]);
            exit();
        }
    }
};

//リクエストトークンにより処理実行
if (filter_input(INPUT_POST, 'token')) {
    if ($_POST['token'] == 'delete') {
        deleteItem($_POST['item_id']);
    } elseif ($_POST['token']=='edit') {
        editItem($_POST);
    }
}
