<?php
ini_set('display_errors', 1);

//関数読み込み
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
cors_config();

$capsule->bootEloquent();
//cors_config();


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

        $sql = 'INSERT INTO rental_state(rental_state_id,userid,item_id,transaction_id,return_date)VALUES(null,:userid,:item_id,:transaction_id,:return_date)';

        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':userid', $rental_data['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':item_id', $rental_data['item_id'], PDO::PARAM_INT);
        $stmt->bindValue(':transaction_id', $transaction_id, PDO::PARAM_INT);
        $stmt->bindValue(':return_date', $return_date, PDO::PARAM_STR);

        $status = $stmt->execute();
    }
}

function is_rentaled($user_id)
{
    $pdo = connect_to_db();
    //商品情報
    $sql = 'SELECT rental_state.userid, return_date,item_name,photo1 FROM ((rental_state LEFT OUTER JOIN item ON rental_state.item_id = item.item_id) LEFT OUTER JOIN photo ON rental_state.item_id=photo.item_id) WHERE rental_state.userid=:userid';

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':userid', $user_id, PDO::PARAM_STR);

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
    if ($_POST['token']=='rental') {
        rental($_POST);
    } elseif ($_POST['token']=='rentaled') {
        is_rentaled($_POST['user_id']);
    }
}
