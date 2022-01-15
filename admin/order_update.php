<!-- 注文ステータス更新 -->

<?php
require_once '../common/functions.php';     // 関数呼出
try {
    /* XSS対策 */
    $order_info = sanitize($_POST);
    $order_id = (int) $order_info["order_id"];
    $order_user_id = (int) $order_info["order_user_id"];
    $ship_status = $order_info["ship_status"];
    $payment_status = $order_info["payment_status"];
    $order_time = $order_info["order_time"];

    /* DBの注文ステータスを変更する */
    $dbh = db_open();   // DB接続
    $stmt = $dbh->prepare("UPDATE orders SET ship_status = :ship_status, payment_status = :payment_status, order_time = :order_time WHERE order_id = :order_id");
    $stmt->bindParam(":ship_status", $ship_status, PDO::PARAM_STR);
    $stmt->bindParam(":payment_status", $payment_status, PDO::PARAM_STR);
    $stmt->bindParam(":order_id", $order_id, PDO::PARAM_INT);
    $stmt->bindParam(":order_time", $order_time, PDO::PARAM_INT);
    $stmt->execute();   // 追加SQL実行
    $dbh = null;    // DB切断
} catch(Exception $e) {     // DB接続が出来なたった時
    echo error_msg_admin();     // 管理者情報接続エラー表示
    exit;
}

/* 画面遷移の条件分岐 */
if ($order_user_id == 0) {  // 会員別で更新した場合
    /* ローカル環境時の画面遷移 */
    header("Location:../admin/order_list.php");
    /* 本番環境時の画面遷移 */
    echo <<<EOF
    <script>
        location.href='https://portfolio22.shop/admin/order_list.php';
    </script>
    EOF;
} else {    // 一覧で更新した場合
    /* ローカル環境時の画面遷移 */
    header("Location:../admin/user_order_list.php?id=$order_user_id");
    /* 本番環境時の画面遷移 */
    echo <<<EOF
    <script>
        location.href='https://portfolio22.shop/admin/user_order_list.php?id=$order_user_id';
    </script>
    EOF;
}