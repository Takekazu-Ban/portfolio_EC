<!-- ログアウト処理実行 -->

<?php
/* ログアウト処理 */
session_start();
$_SESSION = array();    // セッション値を消去
if(isset($_Cookie[session_name()]) === true) {
    setcookie(session_name(), "", time()-42000, "/");   // cookieを消去
}
session_destroy();  // セッション完全解除
/* ローカル環境時の画面遷移 */
header("Location: ../ec_shop/shop_list.php");
/* 本番環境時の画面遷移 */
echo <<<EOF
<script>
    location.href='https://portfolio22.shop/ec_shop/shop_list.php';
</script>
EOF;
?>
