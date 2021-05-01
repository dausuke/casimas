<?php
// DB接続の設定
function connect_to_db()
{
    // $db_host = $_ENV['DB_HOST'];
    // $db_name = $_ENV['DB_NAME'];
    // $db_pass = $_ENV['DB_PASS'];
    // //$dbn='mysql:dbname='.$db_name.';charset=utf8;port=37206;host='.$db_host;
    // $dbn = 'mysql:host='.$db_host.'; dbname='.$db_name.'; charset=utf8;port=3306; unix_socket=/tmp/mysql.sock';

    // $user=$db_name;
    // $pwd=$db_pass;
    $dbn = 'mysql:dbname=casimas;charset=utf8;port=3306;host=localhost';
    $user = 'root';
    $pwd = '';

    try {
        return new PDO($dbn, $user, $pwd);
    } catch (PDOException $e) {
        // DB接続に失敗した場合はここでエラーを出力し，以降の処理を中止する
        echo json_encode(["db error" => "{$e->getMessage()}"]);
        exit();
    }
}

//CORSの設定
function cors_config()
{
    header('Access-Control-Allow-Origin: http://192.168.10.113:8080');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, X-CSRF-Token, Content-Type, Accept');
    header('Access-Control-Allow-Credentials: true');
}

//ランダム文字列の生成
function random_string($length) {
$randam_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  return substr(str_shuffle($randam_chars), 0, $length);
}