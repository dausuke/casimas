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

$pdo = connect_to_db();

//ファイル処理
// $file = $_FILES;
// $item_img = array();
// foreach ($file as $file_data) {
//     if (!isset($file_data) && $file_data['error'] != 0) {
//         exit('Error:画像が送信されていません');
//     } else {
//         $uploaded_file_name = $file_data['name'];
//         $extension = pathinfo($uploaded_file_name, PATHINFO_EXTENSION);
//         $temp_path = $file_data['tmp_name'];
//         $directory_path = 'item_img/';  //画像保存ファイル
//         $unique_name = date('YmdHis') . random_string(16) . "." . $extension;   //保存した日付とランダム文字列.拡張子
//         $filename_to_save = $directory_path . $unique_name;     //保存先のパス

//         if (!is_uploaded_file($temp_path)) {
//             exit('Error:画像がありません');
//         } elseif (!move_uploaded_file($temp_path, $filename_to_save)) {
//             exit('Error:アップロードできませんでした');
//         } else {
//             chmod($filename_to_save, 0644); // 権限の変更
//             $item_img[]=$filename_to_save;
//         }
//     }
// }
// var_dump($item_img);
//     exit();

if (isset($_POST)) {
    $item_data=$_POST;

    $sql = 'INSERT INTO item(item_id,seller_id,category_id,item_name,item_introductoin,brand,purchase_judg,created_at,updated_at,is_deleted) VALUES (null,:seller_id,:category_id,:item_name,:item_introduction,:brand,:purchase_judg,sysdate(),sysdate(),0)';
    $stmt = $pdo->prepare($sql);
    //バインド変数設定
    $stmt->bindValue(':seller_id', $item_data['seller_id'], PDO::PARAM_STR);
    $stmt->bindValue(':category_id', $item_data['category_id'], PDO::PARAM_STR);
    $stmt->bindValue(':item_name', $item_data['item_name'], PDO::PARAM_STR);
    $stmt->bindValue(':item_introduction', $item_data['item_introduction'], PDO::PARAM_STR);
    $stmt->bindValue(':brand', $item_data['brand'], PDO::PARAM_STR);
    $stmt->bindValue(':purchase_judg', $item_data['purchase_judg'], PDO::PARAM_STR);

    $status = $stmt->execute();

    if ($status == false) {
        $error = $stmt->errorInfo();
        // データ登録失敗次にエラーを表示
        exit('sqlError:' . $error[2]);
    } else {
        $item_id = $pdo->lastInsertId();

        if ($item_data['purchase_judg']=='true') {
            $sql = 'INSERT INTO price(price_id,item_id,price_1m,price_1w,price_purchase	) VALUES (null,:item_id,:price_1m,:price_1w,:price_purchase	)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':item_id', $item_id, PDO::PARAM_STR);
            $stmt->bindValue(':price_1m', $item_data['price_1m'], PDO::PARAM_STR);
            $stmt->bindValue(':price_1w', $item_data['price_1w'], PDO::PARAM_STR);
            $stmt->bindValue(':price_purchase', $item_data['price_purchase'], PDO::PARAM_STR);

            $status = $stmt->execute();
        } else {
            $sql = 'INSERT INTO price(price_id,item_id,price_1m,price_1w,price_purchase	) VALUES (null,:item_id,:price_1m,:price_1w,null)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':item_id', $item_id, PDO::PARAM_INT);
            $stmt->bindValue(':price_1m', $item_data['price_1m'], PDO::PARAM_STR);
            $stmt->bindValue(':price_1w', $item_data['price_1w'], PDO::PARAM_STR);

            $status = $stmt->execute();
        }
        if ($status == false) {
            $error = $stmt->errorInfo();
            // データ登録失敗次にエラーを表示
            exit('sqlError:' . $error[2]);
        // } else {
        //     switch (count($item_img)) {
        //         case 1:
        //             $sql = 'INSERT INTO photo(photo_id,item_id,photo1) VALUES (null,:item_id,:photo1)';
        //             $stmt = $pdo->prepare($sql);
        //             $stmt->bindValue(':item_id', $item_id, PDO::PARAM_STR);
        //             $stmt->bindValue(':photo1', $item_img[0], PDO::PARAM_STR);
        //             break;
        //         case 2:
        //             $sql = 'INSERT INTO photo(photo_id,item_id,photo1,photo2) VALUES (null,:item_id,:photo1,:photo2)';
        //             $stmt = $pdo->prepare($sql);
        //             $stmt->bindValue(':item_id', $item_id, PDO::PARAM_STR);
        //             $stmt->bindValue(':photo1', $item_img[0], PDO::PARAM_STR);
        //             $stmt->bindValue(':photo2', $item_img[1], PDO::PARAM_STR);
        //             break;
        //         case 3:
        //             $sql = 'INSERT INTO photo(photo_id,item_id,photo1,photo2,photo3) VALUES (null,:item_id,:photo1,:photo2,:photo3)';
        //             $stmt = $pdo->prepare($sql);
        //             $stmt->bindValue(':item_id', $item_id, PDO::PARAM_STR);
        //             $stmt->bindValue(':photo1', $item_img[0], PDO::PARAM_STR);
        //             $stmt->bindValue(':photo2', $item_img[1], PDO::PARAM_STR);
        //             $stmt->bindValue(':photo3', $item_img[2], PDO::PARAM_STR);
        //         break;
        //         case 4:
        //             $sql = 'INSERT INTO photo(photo_id,item_id,photo1,photo2,photo3,photo4) VALUES (null,:item_id,:photo1,:photo2,:photo3,:photo4)';
        //             $stmt = $pdo->prepare($sql);
        //             $stmt->bindValue(':item_id', $item_id, PDO::PARAM_STR);
        //             $stmt->bindValue(':photo1', $item_img[0], PDO::PARAM_STR);
        //             $stmt->bindValue(':photo2', $item_img[1], PDO::PARAM_STR);
        //             $stmt->bindValue(':photo3', $item_img[2], PDO::PARAM_STR);
        //             $stmt->bindValue(':photo4', $item_img[3], PDO::PARAM_STR);
        //             break;
        //     }
        //     $status = $stmt->execute();

        //     if ($status == false) {
        //         $error = $stmt->errorInfo();
        //         // データ登録失敗次にエラーを表示
        //         exit('sqlError:' . $error[2]);
        //     }
         }
    }
}
