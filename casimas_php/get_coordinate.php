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

function get_coordinate()
{
    $pdo = connect_to_db();
    $sql = 'SELECT coordinate_id,coodinate_img FROM coodinate';
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

function item()
{
    $pdo = connect_to_db();

    $sql = 'SELECT coodinate_id,item_id FROM coodinate_item';
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

function get_coordinate_item($item_id_str)
{
    $item_id = explode(",", $item_id_str);


    $pdo = connect_to_db();
    $result=[];
    foreach ($item_id as $value) {
        $sql = 'SELECT item_id,item_name FROM item WHERE item_id=:item_id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':item_id', $value, PDO::PARAM_STR);
        $status = $stmt->execute();

        if ($status == false) {
            $error = $stmt->errorInfo();
            // データ登録失敗次にエラーを表示
            exit('sqlError:' . $error[2]);
        } else {
            $item_data = $stmt->fetch(PDO::FETCH_ASSOC);
            array_push($result, $item_data);
        }
    }
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
}

if (filter_input(INPUT_POST, 'token')) {
    if ($_POST['token']=='get_coordinate') {
        get_coordinate();
    } elseif ($_POST['token']=='item') {
        item();
    } elseif ($_POST['token']=='get_coordinate_item') {
        get_coordinate_item($_POST['item_id']);
    }
}
