<!-- 管理者削除実行 -->

<?php
require_once '../common/functions.php';     // 関数呼出
try {
    $admin_id = $_POST["admin_id"];    // 削除対象の管理者IDを受取
    $dbh = db_open();   // DB接続
    $stmt = $dbh->prepare("DELETE FROM admins WHERE admin_id = :admin_id");
    $stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
    $stmt->execute();   // 管理者削除実行
    $dbh = null;    // DB切断
} catch (Exception $e) {     // DB接続が出来なたった時
    include("../common/admin_db_error.php");    // 管理者情報接続エラー画面表示
}
/* ローカル環境時の画面遷移 */
header("Location: ../admin/admin_list.php");    // 管理者一覧に画面遷移
/* 本番環境時の画面遷移 */
echo <<<EOF
<script>
    location.href='https://portfolio22.shop//admin/admin_list';
</script>
EOF;
