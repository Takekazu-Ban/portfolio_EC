<!-- 管理者情報編集実行 -->

<?php
require_once '../common/functions.php';     // 関数呼出
try {
    /* XSS対策 */
    $admin_info = sanitize($_POST);
    $admin_id = $admin_info["admin_id"];
    $admin_name = $admin_info["admin_name"];
    $admin_pass = $admin_info["admin_pass"];
    $admin_pass = password_hash($admin_pass, PASSWORD_DEFAULT);   // パスワードハッシュ化

    /* DBから管理者情報を取得する */
    $dbh = db_open();   // DB接続
    $stmt = $dbh->prepare("UPDATE admins SET admin_name = :admin_name, admin_pass = :admin_pass WHERE admin_id = :admin_id");
    $stmt->bindParam(":admin_name", $admin_name, PDO::PARAM_STR);
    $stmt->bindParam(":admin_pass", $admin_pass, PDO::PARAM_STR);
    $stmt->bindParam(":admin_id", $admin_id, PDO::PARAM_INT);
    $stmt->execute();   // 管理者編集実行
    $dbh = null;    // DB切断
} catch(Exception $e) {     // DB接続が出来なたった時
    include("../common/admin_db_error.php");    // 管理者情報接続エラー画面表示
}
/* ローカル環境時の画面遷移 */
header("Location: ../admin/admin_list.php");    // 会員一覧に遷移
/* 本番環境時の画面遷移 */
echo <<<EOF
<script>
    location.href='https://portfolio22.shop/admin/admin_list.php';
</script>
EOF;