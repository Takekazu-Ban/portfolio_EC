<!-- 書籍一覧画面 -->

<!-- ヘッダー呼出 -->
<?php include("../common/header.php"); ?>

<div class="main-center">
    <body>
        <?php
        require_once '../common/functions.php';     // 関数呼出
        try {
            /* XSS対策 */
            $product_info = sanitize($_POST);
            $product_id = $product_info["product_id"];
            $product_img = $product_info["product_img"];

            if (!empty($product_img)) {
                unlink("../product/img/".$product_img);
            }
            $dbh = db_open();   // DB接続
            $stmt = $dbh->prepare("DELETE FROM products WHERE product_id = :product_id");
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            $dbh = null;    // DB切断
        } catch (Exception $e) {     // DB接続が出来なたった時
            echo error_msg_admin();     // 管理者情報接続エラー表示
            exit;
        }
        ?>
    <p>商品削除が完了しました。</p>
    <a href="product_list.php">商品一覧へ</a>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>