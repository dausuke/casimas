<?php
ini_set('display_errors', 1);

//CORSの設定
header('Access-Control-Allow-Origin: http://192.168.10.113:8080');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, X-CSRF-Token, Content-Type, Accept');
header('Access-Control-Allow-Credentials: true');

include("functions.php");

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