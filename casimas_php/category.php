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
//cors_config();

$capsule->bootEloquent();
// $uid = $_SESSION['uid'];
// $name = $_SESSION['name'];

$pdo = connect_to_db();

// データ取得SQL作成
$sql = 'SELECT * FROM category_item_ditail';    //販売員の全データ取得

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
}