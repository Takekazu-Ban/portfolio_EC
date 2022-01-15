<!-- 商品編集実行 -->

<!-- ヘッダー表示 -->
<?php include("../common/header.php"); ?>

<div class="main-center">
    <body>
        <?php
        require_once '../common/functions.php';    // 関数呼出
        try {
            /* XSS対策 */
            $product_info = sanitize($_POST);
            $product_id = $product_info["product_id"];
            $product_name = $product_info["product_name"];
            $product_price = $product_info["product_price"];
            $product_img = $_FILES["image"];
            $old_image = $product_info["old_image"];
            $product_exp = $product_info["product_exp"];
            $product_cat = $product_info["product_cat"];

            /* 画像を変更しない場合、元の画像を使用する */
            if (empty($product_img) && isset($old_image) === true) {
                $product_img = $old_image;
            }

            /* 画像を入れ替える場合、元の画像を新しい画像に差替える */
            if ($old_image != "") {
                if ($product_img != $old_image) {
                    unlink("../product/img/".$old_image);   // 古い画像消去
                }
            }

            /* DBに商品情報を追加する */
            $dbh = db_open();   // DB接続
            $stmt = $dbh->prepare("UPDATE products SET product_cat = :product_cat, product_name = :product_name, product_price = :product_price, product_img = :product_img, product_exp = :product_exp WHERE product_id = :product_id");
            $stmt->bindParam(":product_cat", $product_cat, PDO::PARAM_STR);
            $stmt->bindParam(":product_name", $product_name, PDO::PARAM_STR);
            $stmt->bindParam(":product_price", $product_price, PDO::PARAM_INT);
            $stmt->bindParam(":product_img", $product_img, PDO::PARAM_STR);
            $stmt->bindParam(":product_exp", $product_exp, PDO::PARAM_STR);
            $stmt->bindParam(":product_id", $product_id, PDO::PARAM_INT);
            $stmt->execute();   // 追加SQL実行
            $dbh = null;    // DB切断
        } catch(Exception $e) {     // DB接続が出来なたった時
            error_msg_admin();     // 接続エラー表示
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