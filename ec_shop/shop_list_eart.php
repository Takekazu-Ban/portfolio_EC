<!-- 食品一覧画面 -->

<!-- ヘッダー呼出 -->
<?php include("../common/header.php"); ?>
<!-- サイドバー呼出 -->
<?php include("../common/side_bar.php"); ?>
<!-- 関数呼出 -->
<?php require_once '../common/functions.php'; ?>
<!-- タイトルバー呼出 -->
<?php include("../common/shop_title_bar.php"); ?>

<!-- 食品一覧表示 -->
<div class="shop-main-center">
    <body>
        <?php
        try {
            /* 食品一覧表示 */
            for ($i=$num; $i<$product_elem; $i++) {     // 商品数分ループして表示
                $dbh = db_open();   // DB接続
                $stmt = $dbh->prepare("SELECT * FROM products WHERE product_cat = '食品'");
                $stmt->execute();   // カテゴリーが食品の商品選択実行
                $dbh = null;    // DB切断
                $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $rec = $rec[$i];

                if ($i == product_count()) {
                    break;
                }
                $product_id = $rec["product_id"];
                echo "<a href='shop_goods.php?id=".$product_id."'>";
                    /* 商品画像定義 */
                    if (empty($rec["product_img"]) === true) {
                        $disp_product_img = "";
                    } else {
                        $disp_product_img = "<img src='../product/img/".$rec['product_img']."' width='100%' height='100%'>";
                    }
                    /* 商品表示 */
                    echo "<div class='shop-goods'>";
                        echo "<div class='shop-goods-img'>";
                            echo $disp_product_img;
                            echo "<br>";
                        echo "</div>";
                        echo "<strong>". $rec['product_name']. "</strong>";
                        echo "<br>";
                        echo $rec["product_price"]."円";
                        echo "<br><br>";
                    echo "</div>";
                    $_SESSION['category'] = "eart";
                echo "</a>";
            }
        } catch (Exception $e) {     // DB接続が出来なたった時
            echo error_msg();     // 接続エラー表示
            exit;
        }
        ?>

        <!-- ページング呼出 -->
        <?php include("../common/pageing.php"); ?>
    </body>
</div>

<?php include("../common/footer.php"); ?>