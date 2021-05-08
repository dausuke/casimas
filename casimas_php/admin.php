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


function up_item_img($item_id)
{
    $pdo = connect_to_db();

    //ファイル処理
    $file = $_FILES;
    $item_img = array();
    foreach ($file as $file_data) {
        if (!isset($file_data) && $file_data['error'] != 0) {
            exit('Error:画像が送信されていません');
        } else {
            $uploaded_file_name = $file_data['name'];
            $extension = pathinfo($uploaded_file_name, PATHINFO_EXTENSION);
            $temp_path = $file_data['tmp_name'];
            $directory_path = 'item_img/';  //画像保存ファイル
        $unique_name = date('YmdHis') . random_string(16) . "." . $extension;   //保存した日付とランダム文字列.拡張子
        $filename_to_save = $directory_path . $unique_name;     //保存先のパス

        if (!is_uploaded_file($temp_path)) {
            exit('Error:画像がありません');
        } elseif (!move_uploaded_file($temp_path, $filename_to_save)) {
            exit('Error:アップロードできませんでした');
        } else {
            chmod($filename_to_save, 0644); // 権限の変更
            $item_img[]=$filename_to_save;
        }
        }
    }
    switch (count($item_img)) {
                case 1:
                    $sql = 'INSERT INTO photo(photo_id,item_id,photo1) VALUES (null,:item_id,:photo1)';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':item_id', $item_id, PDO::PARAM_STR);
                    $stmt->bindValue(':photo1', $item_img[0], PDO::PARAM_STR);
                    break;
                case 2:
                    $sql = 'INSERT INTO photo(photo_id,item_id,photo1,photo2) VALUES (null,:item_id,:photo1,:photo2)';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':item_id', $item_id, PDO::PARAM_STR);
                    $stmt->bindValue(':photo1', $item_img[0], PDO::PARAM_STR);
                    $stmt->bindValue(':photo2', $item_img[1], PDO::PARAM_STR);
                    break;
                case 3:
                    $sql = 'INSERT INTO photo(photo_id,item_id,photo1,photo2,photo3) VALUES (null,:item_id,:photo1,:photo2,:photo3)';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':item_id', $item_id, PDO::PARAM_STR);
                    $stmt->bindValue(':photo1', $item_img[0], PDO::PARAM_STR);
                    $stmt->bindValue(':photo2', $item_img[1], PDO::PARAM_STR);
                    $stmt->bindValue(':photo3', $item_img[2], PDO::PARAM_STR);
                break;
                case 4:
                    $sql = 'INSERT INTO photo(photo_id,item_id,photo1,photo2,photo3,photo4) VALUES (null,:item_id,:photo1,:photo2,:photo3,:photo4)';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':item_id', $item_id, PDO::PARAM_STR);
                    $stmt->bindValue(':photo1', $item_img[0], PDO::PARAM_STR);
                    $stmt->bindValue(':photo2', $item_img[1], PDO::PARAM_STR);
                    $stmt->bindValue(':photo3', $item_img[2], PDO::PARAM_STR);
                    $stmt->bindValue(':photo4', $item_img[3], PDO::PARAM_STR);
                    break;
            }
    $status = $stmt->execute();

    if ($status == false) {
        $error = $stmt->errorInfo();
        // データ登録失敗次にエラーを表示
        exit('sqlError:' . $error[2]);
    }
}
function up_coodinate_img($item_id_str)
{
    $item_id = explode(",", $item_id_str);

    $pdo = connect_to_db();

    //ファイル処理
    $file = $_FILES;
    foreach ($file as $file_data) {
        if (!isset($file_data) && $file_data['error'] != 0) {
            exit('Error:画像が送信されていません');
        } else {
            $uploaded_file_name = $file_data['name'];
            $extension = pathinfo($uploaded_file_name, PATHINFO_EXTENSION);
            $temp_path = $file_data['tmp_name'];
            $directory_path = 'coodinate_img/';  //画像保存ファイル
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
    }
    $sql = 'INSERT INTO coodinate(coordinate_id,coodinate_img,created_at,updated_at) VALUES (null,:coodinate_img,sysdate(),sysdate())';
    $stmt = $pdo->prepare($sql);
    //バインド変数設定
    $stmt->bindValue(':coodinate_img', $filename_to_save, PDO::PARAM_STR);

    $status = $stmt->execute();

    if ($status == false) {
        $error = $stmt->errorInfo();
        // データ登録失敗次にエラーを表示
        exit('sqlError:' . $error[2]);
    } else {
        $coodinate_id = $pdo->lastInsertId();
        foreach ($item_id as $value) {
            $sql = 'INSERT INTO coodinate_item(coodinate_img_id,coodinate_id,item_id) VALUES (null,:coodinate_id,:item_id)';
            $stmt = $pdo->prepare($sql);
            //バインド変数設定
            $stmt->bindValue(':coodinate_id', $coodinate_id, PDO::PARAM_STR);
            $stmt->bindValue(':item_id', $value, PDO::PARAM_STR);

            $status = $stmt->execute();

            if ($status == false) {
                $error = $stmt->errorInfo();
                // データ登録失敗次にエラーを表示
                exit('sqlError:' . $error[2]);
            }
        }
    }
}
function get_item()
{
    $pdo = connect_to_db();

    //商品情報
    $sql = "SELECT item_id,item_name FROM item WHERE item.is_deleted=0";

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
if (filter_input(INPUT_POST, 'token')) {
    if ($_POST['token']=='item') {
        up_item_img($_POST['item_id']);
    } elseif ($_POST['token']=='coodinate') {
        up_coodinate_img($_POST['item_id']);
    } elseif ($_POST['token']=='get_item') {
        get_item($_POST['item_id']);
    }
}
