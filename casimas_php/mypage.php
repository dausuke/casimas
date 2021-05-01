<?php
ini_set('display_errors', 1);

//関数読み込み
use Cartalyst\Sentinel\Native\Facades\Sentinel;
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

$capsule->bootEloquent();

//ユーザー情報取得
function getUser($user_id)
{
    $pdo = connect_to_db();

    // データ取得SQL作成
    $sql = 'SELECT user_data.userid,users.email,users.first_name,users.last_name,user_data.nickname,user_data.introduction,user_data.profile_img,user_data.address,user_data.phone,user_data.birthday,seller_info.seller_id,seller_info.height FROM ((users LEFT OUTER JOIN user_data ON users.id = user_data.userid) LEFT OUTER JOIN seller_info ON user_data.userid = seller_info.seller_id ) WHERE userid=:userid';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':userid', $user_id['user_id'], PDO::PARAM_STR);
    $status = $stmt->execute();

    // データ登録処理後
    if ($status == false) {
        // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
        $error = $stmt->errorInfo();
        echo json_encode(["error_msg" => "{$error[2]}"]);
        exit();
    } else {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}
//プロフィール更新
function update_profile($user_data)
{
    $pdo = connect_to_db();

    $sql = 'UPDATE user_data SET nickname=:nickname,introduction=:introduction WHERE userid=:userid';

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':userid', $user_data['user_id'], PDO::PARAM_STR);
    $stmt->bindValue(':nickname', $user_data['nickname'], PDO::PARAM_STR);
    $stmt->bindValue(':introduction', $user_data['introduction'], PDO::PARAM_STR);

    $status = $stmt->execute();
    // データ登録処理後
    if ($status == false) {
        // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
        $error = $stmt->errorInfo();
        echo json_encode(["error_msg" => "{$error[2]}"]);
        exit();
    }
}
//プロフィール画像変更
function update_profile_img($user_data)
{

//ファイル処理
    $file = $_FILES['img_path'];
    // var_dump($_FILES);
    // exit();
    if (!isset($file) && $file['error'] != 0) {
        exit('Error:画像が送信されていません');
    } else {
        $uploaded_file_name = $file['name'];
        $extension = pathinfo($uploaded_file_name, PATHINFO_EXTENSION);
        $temp_path = $file['tmp_name'];
        $directory_path = 'user_img/';  //画像保存ファイル
        $unique_name = date('YmdHis') . random_string(16) . "." . $extension;   //保存した日付とランダム文字列.拡張子
        $filename_to_save = $directory_path . $unique_name;     //保存先のパス

        if (!is_uploaded_file($temp_path)) {
            exit('Error:画像がありません');
        } elseif (!move_uploaded_file($temp_path, $filename_to_save)) {
            exit('Error:アップロードできませんでした');
        } else {
            chmod($filename_to_save, 0644); // 権限の変更
        }
    }

    $pdo = connect_to_db();

    $sql = 'UPDATE user_data SET profile_img=:img_path WHERE userid=:userid';

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':userid', $user_data['user_id'], PDO::PARAM_STR);
    $stmt->bindValue(':img_path', $filename_to_save, PDO::PARAM_STR);

    $status = $stmt->execute();
    // データ登録処理後
    if ($status == false) {
        // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
        $error = $stmt->errorInfo();
        echo json_encode(["error_msg" => "{$error[2]}"]);
        exit();
    }
}
function get_profile_img($user_id)
{
    $pdo = connect_to_db();

    // データ取得SQL作成
    $sql = 'SELECT profile_img FROM user_data  WHERE userid=:userid';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':userid', $user_id['user_id'], PDO::PARAM_STR);
    $status = $stmt->execute();

    // データ登録処理後
    if ($status == false) {
        // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
        $error = $stmt->errorInfo();
        echo json_encode(["error_msg" => "{$error[2]}"]);
        exit();
    } else {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}
function uodate_account($user_data)
{
    $pdo = connect_to_db();

    $sql = 'UPDATE user_data SET address=:address,phone=:phone WHERE userid=:userid';

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':userid', $user_data['user_id'], PDO::PARAM_STR);
    $stmt->bindValue(':address', $user_data['address'], PDO::PARAM_STR);
    $stmt->bindValue(':phone', $user_data['phone'], PDO::PARAM_STR);

    $status = $stmt->execute();
    // データ登録処理後
    if ($status == false) {
        // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
        $error = $stmt->errorInfo();
        echo json_encode(["error_msg" => "{$error[2]}"]);
        exit();
    } else {
        $user = Sentinel::findById($user_data['user_id']);
        $credentials = [
            'email' => $user_data['email'],
        ];
        $user = Sentinel::update($user, $credentials);
    }
}
//リクエストトークンにより処理実行
if (filter_input(INPUT_POST, 'token')) {
    //プロフィール
    if ($_POST['token']=='getuser') {
        getUser($_POST);
    } elseif ($_POST['token']=='updade_profile') {
        update_profile($_POST);
    } elseif ($_POST['token']=='update_profile_img') {
        update_profile_img($_POST);
    } elseif ($_POST['token']=='get_profile_img') {
        get_profile_img($_POST);
    } elseif ($_POST['token']=='update_account') {
        uodate_account($_POST);
    }
}
