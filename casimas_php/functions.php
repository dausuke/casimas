<?php
// DB接続の設定
function connect_to_db()
{
    $db_host = $_ENV['DB_HOST'];
    $db_name = $_ENV['DB_NAME'];
    $db_pass = $_ENV['DB_PASS'];
    //$dbn='mysql:dbname='.$db_name.';charset=utf8;port=37206;host='.$db_host;
    $dbn = 'mysql:host='.$db_host.'; dbname='.$db_name.'; charset=utf8;port=3306; unix_socket=/tmp/mysql.sock';

    $user=$db_name;
    $pwd=$db_pass;
    // $dbn = 'mysql:dbname=casimas;charset=utf8;port=3306;host=localhost';
    // $user = 'root';
    // $pwd = '';

    try {
        return new PDO($dbn, $user, $pwd);
    } catch (PDOException $e) {
        // DB接続に失敗した場合はここでエラーを出力し，以降の処理を中止する
        echo json_encode(["db error" => "{$e->getMessage()}"]);
        exit();
    }
}
//BDの設定（sentinel用)
function connect_to_db_sentinel()
{
    $db_host = $_ENV['DB_HOST'];
    $db_name = $_ENV['DB_NAME'];
    $db_pass = $_ENV['DB_PASS'];

//     $add_connection=[
//     'driver'    => 'mysql',
//     'host'      => $db_host,
//     'database'  => $db_name,
//     'username'  => $db_name,
//     'password'  => $db_pass,
//     'charset'   => 'utf8',
//     'collation' => 'utf8_unicode_ci',
// ];
    $add_connection=[
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'casimas',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
];
return $add_connection;
}

//ランダム文字列の生成
function random_string($length)
{
    $randam_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle($randam_chars), 0, $length);
}
