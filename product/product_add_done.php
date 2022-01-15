<!-- 商品追加実行 -->

<!-- ヘッダー表示 -->
<?php include("../common/header.php"); ?>

<div class="main-center">
    <body>
        <?php
        require_once '../common/functions.php';
        try {
            /* XSS対策 */
            $product_info = sanitize($_POST);
            $product_name = $product_info["product_name"];
            $product_price = $product_info["product_price"];
            $product_img = $product_info["product_img"];
            $product_exp = $product_info["product_exp"];
            $product_cat = $product_info["product_cat"];

            /* DBに商品情報を追加する */
            $dbh = db_open();   // DB接続
            $stmt = $dbh->prepare("INSERT INTO products (product_cat, product_name, product_price, product_img, product_exp) VALUES(:product_cat, :product_name, :product_price, :product_img, :product_exp)");
            $stmt->bindParam(":product_cat", $product_cat, PDO::PARAM_STR);
            $stmt->bindParam(":product_name", $product_name, PDO::PARAM_STR);
            $stmt->bindParam(":product_price", $product_price, PDO::PARAM_STR);
            $stmt->bindParam(":product_img", $product_img, PDO::PARAM_STR);
            $stmt->bindParam(":product_exp", $product_exp, PDO::PARAM_STR);
            $stmt->execute();   // 商品追加実行
            $dbh = null;    // DB切断
        } catch(Exception $e) {     // DB接続が出来なたった時
            echo error_msg_admin();     // 管理者情報接続エラー表示
            exit;
        }
        ?>
        <?php
        /* ローカル環境時の画面遷移 */
        header("Location:../product/product_list.php");
        /* 本番環境時の画面遷移 */
        echo <<<EOF
        <script>
            location.href='https://portfolio22.shop/product/product_list.php';
        </script>
        EOF;
        ?>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>