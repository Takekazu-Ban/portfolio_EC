<!-- 商品詳細画面 -->

<!-- ヘッダー呼出 -->
<?php include("../common/header.php"); ?>

<div class="producdt-add-main-center">
    <body>
        <?php
        require_once '../common/functions.php';     // 関数呼出
        /* DBから商品情報取得 */
        try {
            $product_id = $_GET["id"];
            $dbh = db_open();   // DB接続
            $stmt = $dbh->prepare("SELECT * FROM products WHERE product_id = :product_id");
            $stmt->bindParam(":product_id", $product_id, PDO::PARAM_INT);
            $stmt->execute();   // SQL実行
            $dbh = null;    // DB切断
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            if (empty($rec["product_img"]) === true) {
                $disp_product_img = "";
            } else {
                $disp_product_img = "<img src='../product/img/".$rec['product_img']."' width='100%' height='100%'>";
            }
        } catch (Exception $e) {     // DB接続が出来なたった時
            error_msg_admin();     // 接続エラー表示
            exit;
        }
        ?>
        <!-- 商品詳細表示 -->
        <h3>商品詳細</h3>
        <br>
            <div class="product-img">
                <?= $disp_product_img; ?>
            </div>
            <div class="product-summry">
                <p>カテゴリー:<?= $rec['product_cat']; ?></p>
                <h2><strong><?= $rec['product_name']; ?></strong></h2><br>
                価格:<font size="5"><?= $rec['product_price']; ?>円</font><br>
            </div>
            <div class="product-exp-box">
                <font size="4"><strong>商品詳細</strong></font><br>
                <?= nl2br($rec['product_exp']); ?>
            </div>
            <div class="product-show-btn">
                <input type='button' onclick="location.href='../product/product_edit.php?id=<?=$product_id?>'" value='編集'>
                &thinsp;
                <input type='button' onclick="location.href='../product/product_delete.php?id=<?=$product_id?>'" value='削除'>
                &thinsp;
                <input type="button" onclick="history.back()" value="戻る">
            </div>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>