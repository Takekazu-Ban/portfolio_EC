<!-- ログアウト実行 -->

<?php
/* ログアウト処理 */
session_start();
$_SESSION = array();    // セッション値を消去
if (isset($_COOKIE[session_name()]) === true) {
    setcookie(session_name(), "", time()-42000, "/");   // cookieを消去
}
session_destroy();  // セッション完全解除
/* ローカル環境時の画面遷移 */
header("Location: ../admin/admin_login.php");   // 管理者ログインに画面遷移
/* 本番環境時の画面遷移 */
echo <<<EOF
<script>
    location.href='https://portfolio22.shop/admin/admin_login.php';
</script>
EOF;