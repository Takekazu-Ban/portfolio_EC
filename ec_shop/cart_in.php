<!-- カート内追加s機能 -->

<!-- ヘッダー表示 -->
<?php include("../common/header.php"); ?>

<div class="main-center">
    <body>
        <?php
        require_once '../common/functions.php';     // 関数呼出

        if (isset($_SESSION["user_login"]) === false) {     // ログインせずカートに商品追加した場合
            $logout_msg = "商品の購入をする場合は、ログインしてください。<br>";
            echo "<font color=\"red\">$logout_msg</font><br>";
            echo "<a href='../user/user_login.php'>ログイン画面へ</a>";
        } else {     // ログイン済みでカートに商品追加した場合
            $product_id = (int) $_GET["id"];  // 追加した商品番号取得
            $user_cart = $_SESSION["user_cart"];
            $product_qty = $_SESSION["product_qty"];
            $user_cart[] = $product_id;
            $product_qty[] = $_POST["product_qty"];
            $_SESSION["user_cart"] = $user_cart;
            $_SESSION["product_qty"] = $product_qty;
            echo "カートに追加しました。<br><br>";
            echo "<a href='../ec_shop/shop_list.php'>商品一覧に戻る</a>";
        }
        ?>
        <br><br>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>