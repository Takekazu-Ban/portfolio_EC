<!-- 商品編集画面 -->

<!-- ヘッダー表示 -->
<?php include("../common/header.php"); ?>

<div class="producdt-add-main-center">
    <body>
        <?php
        require_once '../common/functions.php';     // 関数呼出
        try {
            $dbh = db_open();   // DB接続
            $product_id = $_GET["id"];  // 商品一覧からID取得
            $stmt = $dbh->prepare('SELECT * FROM products WHERE product_id = :product_id');
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
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
        <!-- 商品編集入力部分 -->
        <h3>商品情報修正</h3>
        <br>
        <form action="product_edit_check.php" method="post" enctype="multipart/form-data">
            <div class="product-img">
                <?= $disp_product_img; ?>
                <div class="edit-img">
                    <br>
                    <input type="file" name="image">
                </div>
            </div>
            <div class="product-summry">
                <label for="product_cat">カテゴリー:</label>&nbsp;
                <!-- 現在のカテゴリーを表示するプルダウン -->
                <select name='product_cat'>
                    <option value="<?= $rec['product_cat']; ?>"><?= $rec['product_cat']; ?></option>
                    <?php
                    $cat_list = ["食品", "家電", "書籍", "日用品", "その他"];   // カテゴリーリスト
                    for ($i=0; $i<5; $i++) {
                        if ($cat_list[$i] == $rec['product_cat']) {
                            continue;   // 現在のカテゴリーの場合飛ばして表示
                        } else {
                            echo "<option value='$cat_list[$i]'>$cat_list[$i]</option>";
                        }
                    }
                    ?>
                </select>
                <br>
                <label for="product_name">商品名　　:</label>
                <input type="text" name="product_name" value="<?= $rec['product_name']; ?>"><br>
                <label for="product_price">価格　　　:</label>
                <input type="text" size="10" name="product_price" value="<?= $rec['product_price']; ?>">&nbsp;円
            </div>
            <div class="product-exp">
                <font size="4"><strong>商品詳細</strong></font><br>
                <textarea name="product_exp" style="width: 500px; height: 100px;"><?= $rec['product_exp']; ?></textarea>
            </div>
            <input type="hidden" name="product_id" value="<?= $rec['product_id']; ?>">
            <input type="hidden" name="old_image" value="<?= $rec['product_img']; ?>">
            <div class="product-edit-btns">
                <input type="button" onclick="history.back()" value="戻る">
                <input type="submit" value="OK">
            </div>
        </form>

    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>