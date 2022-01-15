<!-- ヘッダー部分 -->

<!-- Bootstrap CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Javascript(jQuery含む) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">
    <title>ECサイト</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<?php ini_set("display_errors", "Off"); ?>

<!-- ヘッダー表示 -->
<header>
<?php
$url = $_SERVER['REQUEST_URI'];     // 現在のURLを取得
session_start();
session_regenerate_id(true);
?>

<!-- ホームボタン -->
<?php
    if ((strstr($url, 'admin') || strstr($url, 'product'))) {    // 管理者画面の場合
    if(isset($_SESSION["login"]) === false) {
        echo "<a href='../admin/admin_login.php'>";
        echo "<div class='home-btn'>";
        echo "<span class='glyphicon glyphicon-home' aria-hidden='true'></span>";
        echo "</div>";
        echo "</a>";
    } else {
        echo "<a href='../admin/admin_top.php'>";
        echo "<div class='home-btn'>";
        echo "<span class='glyphicon glyphicon-home' aria-hidden='true'></span>";
        echo "</div>";
        echo "</a>";
    }
} else {    // ユーザ画面の場合
        echo "<a href='../ec_shop/shop_list.php'>";
        echo "<div class='home-btn'>";
        echo "<span class='glyphicon glyphicon-home' aria-hidden='true'></span>";
        echo "</div>";
        echo "</a>";
}
?>

<?php echo "ログインセッション：". $_SESSION["user_login"]; ?>
<?php echo "名前セッション：". $_SESSION["user_name"]; ?>
<?php echo "idセッション：". $_SESSION["user_id"]; ?>

<!-- ログイン表示 -->
<div class="login-juge">
    <?php
    /* ログインセッション判定(ヘッダー表示) */
    if ((strstr($url, 'admin') || strstr($url, 'product'))) {    // 管理者画面の場合
        if (!strstr($url, 'login')) {
            if ((isset($_SESSION["login"]) === false) && (isset($_SESSION["user_login"]) === false)) {
                $logout_msg = "ログインしていません。<br>";
                echo "<font color=\"red\">$logout_msg</font>";
                echo "<a href='../admin/admin_login.php'>ログイン画面へ</a>";
            } else {
                $login_msg = "<span class='glyphicon glyphicon-user' aria-hidden='true'></span>". " ";
                $login_msg .= $_SESSION['admin_name'].'さんログイン中';
                echo "<font color=\"white\">$login_msg</font>";
            }
        }
    } else {    // ユーザ画面の場合
        if (!((strstr($url, 'login')) || (strstr($url, 'sign_up')))) {
            if ((isset($_SESSION["login"]) === false) && (isset($_SESSION["user_login"]) === false)) {
                $logout_msg = "ログインしていません。<br>";
                echo "<font color=\"red\">$logout_msg</font>";
            } else {
                $login_msg = "<span class='glyphicon glyphicon-user' aria-hidden='true'></span>". " ";
                $login_msg .= $_SESSION['user_name'].'さんログイン中'. '<br>';
                echo "<font color=\"white\">$login_msg</font>";
            }
        }
    }
    ?>
</div>

<!-- ログアウトボタン -->
<div class="login-out">
    <?php
    if (!(strstr($url, 'admin') || strstr($url, 'product'))) {    // ユーザ画面の場合
        if (!((strstr($url, 'login')) || (strstr($url, 'sign_up')))) {
            if ((isset($_SESSION["login"]) === true) || (isset($_SESSION["user_login"]) === true)) {
                $logout_check = <<<EOD
                <input class='login-out-btn' type='button' onclick="location.href='../user/user_logout_msg.php'" value='ログアウト'>
                EOD;
                echo $logout_check;
            } else {
                $login_btn = <<<EOD
                <input class='login-out-btn' type='button' onclick="location.href='../user/user_login.php'" value='ログイン'>
                EOD;
                echo $login_btn;
            }
        }
    }
    ?>
</div>

<!-- カート表示ボタン -->
<div class="cart-look">
    <?php
    if (!(strstr($url, 'admin') || strstr($url, 'product'))) {
        if (!((strstr($url, 'login')) || (strstr($url, 'sign_up')))) {
            if ((isset($_SESSION["login"]) === true) || (isset($_SESSION["user_login"]) === true)) {
                $cart_btn = <<<EOD
                <input class='cart-btn' type='button' onclick="location.href='../ec_shop/cart_look.php'" value='カート'>
                EOD;
                echo $cart_btn;
            }
        }
    }
    ?>
</div>

<!-- マイページ -->
<div class="my-page">
    <?php
    if (!(strstr($url, 'admin') || strstr($url, 'product'))) {
        if (!((strstr($url, 'login')) || (strstr($url, 'sign_up')))) {
            if ((isset($_SESSION["login"]) === true) || (isset($_SESSION["user_login"]) === true)) {
                $mypage_btn = <<<EOD
                <input class='my-page-btn' type='button' onclick="location.href='../user/my_page.php'" value='マイページ'>
                EOD;
                echo $mypage_btn;
            }
        }
    }
    ?>
</div>
</header>

<div class="main">
<?php
/* ログインセッション判定(フッター表示) */
if (strstr($url, 'admin') || strstr($url, 'product')) {
    if (!strstr($url, 'login')) {
        if(isset($_SESSION["login"]) === false) {
                echo "<div class='main-center'></div>";
                include("../common/footer.php");
                exit();
        }
    }
}
?>
