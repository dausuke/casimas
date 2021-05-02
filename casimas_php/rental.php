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
//cors_config();
function rental_request($rental_data)
{
    $pdo = connect_to_db();

    $sql = 'INSERT INTO rental_request(request_id,request_user,request_item,request_plan,request_price,request_state,check_user,check_seller,created_at,updated_at)VALUES(null,:request_user,:request_item,:request_plan,:request_price,1,0,0,sysdate(),sysdate())';

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':request_user', $rental_data['user_id'], PDO::PARAM_INT);
    $stmt->bindValue(':request_item', $rental_data['item_id'], PDO::PARAM_INT);
    $stmt->bindValue(':request_plan', $rental_data['plan'], PDO::PARAM_STR);
    $stmt->bindValue(':request_price', $rental_data['transaction_price'], PDO::PARAM_STR);

    $status = $stmt->execute();

    if ($status == false) {
        $error = $stmt->errorInfo();
        echo json_encode(["error_msg" => "{$error[2]}"]);
        exit();
    }
}
function request_reject($request_id)
{
    $pdo = connect_to_db();

    $sql = 'UPDATE rental_request SET request_state=0,check_user=0,updated_at=sysdate() WHERE request_id=:request_id';

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':request_id', $request_id, PDO::PARAM_STR);

    $status = $stmt->execute();
    if ($status == false) {
        // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
        $error = $stmt->errorInfo();
        echo json_encode(["error_msg" => "{$error[2]}"]);
        exit();
    }
}
function rental($rental_data)
{
    // var_dump($rental_data);
    // exit();

    $pdo = connect_to_db();

    $sql = 'INSERT INTO transaction(transaction_id ,userid,seller_id,item_id,plan,transaction_price,created_at)VALUES(null,:userid,:seller_id,:item_id,:plan,:transaction_price,sysdate())';

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':userid', $rental_data['user_id'], PDO::PARAM_INT);
    $stmt->bindValue(':seller_id', $rental_data['seller_id'], PDO::PARAM_STR);
    $stmt->bindValue(':item_id', $rental_data['item_id'], PDO::PARAM_STR);
    $stmt->bindValue(':plan', $rental_data['plan'], PDO::PARAM_STR);
    $stmt->bindValue(':transaction_price', $rental_data['transaction_price'], PDO::PARAM_STR);

    $status = $stmt->execute();

    if ($status == false) {
        $error = $stmt->errorInfo();
        // データ登録失敗次にエラーを表示
        exit('sqlError:' . $error[2]);
    } else {
        $transaction_id = $pdo->lastInsertId();

        if ($rental_data['plan']=='1m') {
            $return_date = date("Y/m/d", strtotime("1 month"));
        } elseif ($rental_data['plan']=='1w') {
            $return_date = date("Y/m/d", strtotime("1 week"));
        }

        $sql = 'INSERT INTO rental_state(rental_state_id,rental_user_id,item_id,transaction_id,return_date)VALUES(null,:userid,:item_id,:transaction_id,:return_date)';

        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':userid', $rental_data['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':item_id', $rental_data['item_id'], PDO::PARAM_INT);
        $stmt->bindValue(':transaction_id', $transaction_id, PDO::PARAM_INT);
        $stmt->bindValue(':return_date', $return_date, PDO::PARAM_STR);

        $status = $stmt->execute();
        if ($status == false) {
            $error = $stmt->errorInfo();
            // データ登録失敗次にエラーを表示
            exit('sqlError:' . $error[2]);
        } else {
            $request_id=$rental_data['request_id'];
            $sql = 'UPDATE rental_request SET request_state=2,updated_at=sysdate() WHERE request_id=:request_id';

            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':request_id', $request_id, PDO::PARAM_STR);

            $status = $stmt->execute();
            if ($status == false) {
                // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
                $error = $stmt->errorInfo();
                echo json_encode(["error_msg" => "{$error[2]}"]);
                exit();
            }
        }
    }
}

function return_item($rental_state_id)
{
    $pdo = connect_to_db();
    $sql = 'DELETE FROM rental_state WHERE rental_state_id=:rental_state_id';

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':rental_state_id', $rental_state_id, PDO::PARAM_STR);

    $status = $stmt->execute();

    if ($status == false) {
        $error = $stmt->errorInfo();
        // データ登録失敗次にエラーを表示
        exit('sqlError:' . $error[2]);
    }
}
function check_rental_request_item($request_check_data)
{
    $pdo = connect_to_db();

    $sql='SELECT request_state FROM rental_request WHERE request_user=:userid AND request_item=:item_id AND request_state=1';

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':userid', $request_check_data['user_id'], PDO::PARAM_INT);
    $stmt->bindValue(':item_id', $request_check_data['item_id'], PDO::PARAM_INT);

    $status = $stmt->execute();
    if ($status == false) {
        $error = $stmt->errorInfo();
        echo json_encode(["error_msg" => "{$error[2]}"]);
        exit();
    } else {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}

if (filter_input(INPUT_POST, 'token')) {
    if ($_POST['token']=='rental') {
        rental_request($_POST);
    } elseif ($_POST['token']=='reject') {
        request_reject($_POST['request_id']);
    } elseif ($_POST['token']=='approval') {
        rental($_POST);
    } elseif ($_POST['token']=='return') {
        return_item($_POST['rental_state_id']);
    } elseif ($_POST['token']=='check_rental_request_item') {
        check_rental_request_item($_POST);
    }
}
