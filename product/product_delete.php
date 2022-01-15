<!-- 商品削除確認画面 -->

<!-- ヘッダー呼出 -->
<?php include("../common/header.php"); ?>

<div class="main-center">
    <body>
        <?php
        require_once '../common/functions.php';
        /* 削除する商品を選択 */
        try {
            $product_id = $_GET["id"];
            $dbh = db_open();   // DB接続
            $stmt = $dbh->prepare("SELECT * FROM products WHERE product_id = :product_id");
            $stmt->bindParam(":product_id", $product_id, PDO::PARAM_INT);
            $stmt->execute();   // 商品選択実行
            $dbh = null;    // DB切断
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            $product_img = $rec["product_img"];
            if (empty($product_img) === true) {
                $disp_product_img = "";
            } else {
                $disp_product_img = "<img src='../product/img/".$product_img."' width='100%' height='100%'>";
            }
        } catch (Excption $e) {     // DB接続が出来なたった時
            echo error_msg_admin();     // 管理者情報接続エラー表示
            exit;
        }
        ?>

        <!-- 商品削除確認コメント表示 -->
        <h3>商品詳細</h3>
        <br><br>
        <div class="dele-product-img">
            <?= $disp_product_img; ?>
        </div>
        <div class="dele-product">
            <label for="product_name">商品名</label><br>
            <?= $rec["product_name"]; ?>
            <br>
            <label for="product_price">価格</label><br>
            <?= $rec["product_price"]; ?>円
        </div>
        <h4>本当に、上記の商品を削除しますか？</h4>
        <form action="product_delete_done.php" method="post">
            <input type="hidden" name="product_id" value="<?= $rec['product_id']; ?>">
            <input type="hidden" name="product_img" value="<?= $product_img; ?>">
            <input type="button" onclick="history.back()" value="戻る">
            <input type="submit" value="OK">
        </form>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>