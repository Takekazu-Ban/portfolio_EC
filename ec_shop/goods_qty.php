<!-- カート内商品変更実行 -->

<?php
require_once '../common/functions.php';     // 関数呼出
session_start();
session_regenerate_id(true);

/* XSS対策 */
$user_cart_info = sanitize($_POST);
$cartin_products = $user_cart_info["cartin_products"];
$user_cart = $_SESSION["user_cart"];

/* 個数変更、バリデーションチェック */
for ($i = 0; $i < $cartin_products; $i++) {
    $product_qty[] = $user_cart_info["product_qty". $i];
}

/* カート商品削除 */
for ($i = $cartin_products; $i >= 0; $i--) {
    if (isset($user_cart_info["delete". $i]) === true) {
        array_splice($user_cart, $i, 1);
        array_splice($product_qty, $i, 1);
    }
}
$_SESSION["user_cart"] = $user_cart;
$_SESSION["product_qty"] = $product_qty;
/* ローカル環境時の画面遷移 */
header("Location: ../ec_shop/cart_look.php");
/* 本番環境時の画面遷移 */
echo <<<EOF
<script>
    location.href='https://portfolio22.shop/ec_shop/cart_look.php.php';
</script>
EOF;