<?php
ini_set('display_errors', 1);

// sentinel必要情報の読み込み
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Illuminate\Database\Capsule\Manager as Capsule;

require './vendor/autoload.php';

$capsule = new Capsule;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//関数読み込み
include("functions.php");
cors_config();

//DBの設定(認証用)
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

$capsule->bootEloquent();

//ログイン認証
function login($user_data)
{
    //データ受信
    $mail = $user_data['mail'];
    $pass = $user_data['pass'];

    $credentials = [
    'email'    => $mail,
    'password' => $pass,
    ];

    //認証
    $login_user = Sentinel::authenticate($credentials);
    if ($login_user) {
        //ユーザー情報取得
        $pdo = connect_to_db();

        // データ取得SQL作成
        $sql = 'SELECT userid,seller_id FROM user_data LEFT OUTER JOIN (SELECT * FROM seller_info GROUP BY seller_id ) AS seller_data ON user_data.userid = seller_data.seller_id WHERE userid=:userid AND is_deleted=0';


        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':userid', $login_user['id'], PDO::PARAM_STR);
        $status = $stmt->execute();

        if ($status == false) {
            $error = $stmt->errorInfo();
            echo json_encode(["error_msg" => "{$error[2]}"]);
            exit();
        } else {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    } else {
        echo $login_user;
    }
};

//新規登録
function register($user_data)
{
    //ユーザー情報設定(認証用)
    $registeruser = [
    'first_name' => $user_data['first_name'],
    'last_name' => $user_data['last_name'],
    'email' => $user_data['mail'],
    'password' => $user_data['pass'],
    ];
    //新規登録実行
    Sentinel::registerAndActivate($registeruser);   //認証用

    $pdo = connect_to_db();

    //ユーザー情報
    $sql = 'INSERT INTO user_data(userid,gender,address,phone,birthday,nickname,introduction,created_at,updated_at,is_deleted) VALUES (null,:gender,:address,:phone,:birthday,:nickname,:introduction,sysdate(),sysdate(),0)';

    $stmt = $pdo->prepare($sql);

    //バインド変数設定
    $stmt->bindValue(':gender', $user_data['gender'], PDO::PARAM_STR);
    $stmt->bindValue(':address', $user_data['address'], PDO::PARAM_STR);
    $stmt->bindValue(':phone', $user_data['phone'], PDO::PARAM_STR);
    $stmt->bindValue(':birthday', $user_data['birthday'], PDO::PARAM_STR);
    $stmt->bindValue(':nickname', $user_data['nickname'], PDO::PARAM_STR);
    $stmt->bindValue(':introduction', $user_data['introduction'], PDO::PARAM_STR);

    $status = $stmt->execute();

    if ($status == false) {
        $error = $stmt->errorInfo();
        // データ登録失敗次にエラーを表示
        exit('sqlError:' . $error[2]);
    }

    //販売員かどうかのチェック
    if ($user_data['isSeller']==='true') {

        //ユーザーID取得
        $seller_id = $pdo->lastInsertId();
        // var_dump($seller_id);
        // exit();

        //出品者情報登録
        $seller_sql = 'INSERT INTO seller_info(seller_id,bank,bank_branch,account_type,account_number,account_holder,sales,height,created_at,updated_at)VALUES(:seller_id,:bank,:bank_branch,:account_type,:account_number,:account_holder,null,:height,sysdate(),sysdate())';

        $seller_stmt = $pdo->prepare($seller_sql);

        $seller_stmt->bindValue(':seller_id', $seller_id, PDO::PARAM_INT);
        $seller_stmt->bindValue(':height', $user_data['height'], PDO::PARAM_STR);
        $seller_stmt->bindValue(':bank', $user_data['bank'], PDO::PARAM_STR);
        $seller_stmt->bindValue(':bank_branch', $user_data['bank_branch'], PDO::PARAM_STR);
        $seller_stmt->bindValue(':account_type', $user_data['account_type'], PDO::PARAM_STR);
        $seller_stmt->bindValue(':account_number', $user_data['account_number'], PDO::PARAM_STR);
        $seller_stmt->bindValue(':account_holder', $user_data['account_holder'], PDO::PARAM_STR);

        $seller_status = $seller_stmt->execute();

        if ($seller_status == false) {
            $error = $seller_stmt->errorInfo();
            // データ登録失敗次にエラーを表示
            exit('sqlError:' . $error[2]);
        }
    }
};



//ログアウト
function logout($user_data)
{
    $user_id = $user_data['id'];
    $user = Sentinel::findUserById($user_id);
    Sentinel::logout($user, true);
};

//リクエストトークンにより処理実行
if (filter_input(INPUT_POST, 'token')) {
    //ログイン
    if ($_POST['token']=='login') {
        login($_POST);
    //新規登録
    } elseif ($_POST['token']=='register') {
        register($_POST);
    //ログアウト
    }elseif ($_POST['token']=='logout') {
        logout($_POST);
    };
}
