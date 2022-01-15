<!-- 商品詳細画面 -->

<!-- ヘッダー表示 -->
<?php include("../common/header.php"); ?>

<!-- サイドバー表示 -->
<?php include("../common/side_bar.php"); ?>
<div class="goods-main-center">
    <body>
        <?php
        require_once '../common/functions.php';     // 関数呼出
        try {
            $product_id = $_GET["id"];
            $dbh = db_open();   // DB接続
            $stmt = $dbh->prepare("SELECT * FROM products WHERE product_id = :product_id");
            $stmt->bindParam(":product_id", $product_id, PDO::PARAM_INT);
            $stmt->execute();   // 商品選択実行
            $dbh = null;    // DB切断
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            if (empty($rec["product_img"]) === true) {
                $disp_product_img = "";
            } else {
                $disp_product_img = "<img src='../product/img/".$rec['product_img']."' width='100%' height='100%'>";
            }
        } catch (Exception $e) {     // DB接続が出来なたった時
            echo error_msg();     // 接続エラー表示
            exit;
        }
        ?>
        <div class="goods-img">
            <?= $disp_product_img; ?>
        </div>
        <!-- 商品詳細表示 -->
        <div class="goods-summry">
            <p>カテゴリー:<?= $rec['product_cat']; ?></p>
            <h2><strong><?= $rec['product_name']; ?></strong></h2><br>
            価格:<font size="5"><?= $rec['product_price']; ?>円</font><br>

            <form action='cart_in.php?id=<?= $product_id; ?>' method="post">
                <div class="product-qty">
                    数量：
                    <select name='product_qty'>
                        <?php
                        for ($i=1; $i<=10; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="goods-btns">
                    <!-- カートに入れるボタン -->
                    <input type="submit" class="cartin-btn" value="カートに入れる">
                    <!-- 前の画面に戻るボタン条件分岐 -->
                    <?php
                    if ($_SESSION['category'] == "all") {
                        $_SESSION['return_msg'] = "商品一覧に戻る";
                        echo "<form action='../ec_shop/shop_list.php' method='POST'>";
                        if ($_SESSION['keyword'] != null) {
                            $_SESSION['return_msg'] = "検索結果に戻る";
                            $keyword = $_SESSION['keyword'];
                            echo "<input type='hidden' name='keyword' value='$keyword'> ";
                        }
                    } elseif ($_SESSION['category'] == "eart") {
                        $_SESSION['return_msg'] = "食品一覧に戻る";
                        echo "<form action='../ec_shop/shop_list_eart.php' method='POST'>";
                    } elseif ($_SESSION['category'] == "kaden") {
                        $_SESSION['return_msg'] = "家電一覧に戻る";
                        echo "<form action='../ec_shop/shop_list_kaden.php' method='POST'>";
                    } elseif ($_SESSION['category'] == "book") {
                        $_SESSION['return_msg'] = "書籍一覧に戻る";
                        echo "<form action='../ec_shop/shop_list_book.php' method='POST'>";
                    } elseif ($_SESSION['category'] == "niti") {
                        $_SESSION['return_msg'] = "日用品一覧に戻る";
                        echo "<form action='../ec_shop/shop_list_niti.php' method='POST'>";
                    } else {
                        $_SESSION['return_msg'] = "その他一覧に戻る";
                        echo "<form action='../ec_shop/shop_list_sonota.php' method='POST'>";
                    }
                    echo "<input type='hidden' name='page' value='".$_SESSION['page']."'>";
                    $return_msg = $_SESSION['return_msg'];
                    echo "<input type='submit' value='$return_msg'>";
                    echo "</form>";
                    ?>
                </div>
            </form>
        </div>
        <!-- 商品説明文表示 -->
        <div class="goods-exp">
            <h4><strong>商品詳細</strong></h4>
            <?= nl2br($rec['product_exp']); ?>
        </div>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>