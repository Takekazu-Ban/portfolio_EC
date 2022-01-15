<!-- カート内商品一覧画面 -->

<!-- ヘッダー表示 -->
<?php include("../common/header.php"); ?>

<div class="main-center">
    <body>
        <?php
        require_once '../common/functions.php';     // 関数呼出
        if (empty($_SESSION["user_cart"]) === true) {
            echo "カートに商品はありません。<br><br>";
            echo "<a href='../ec_shop/shop_list.php'>商品一覧へ戻る</a>";
            echo "</body>";
            echo "</div>";
            include("../common/footer.php");
            exit;
        }

        try {
            $user_cart = $_SESSION["user_cart"];
            $product_qty = $_SESSION["product_qty"];
            $cartin_products = count($user_cart);

            /* カート内商品呼出 */
            $dbh = db_open();   // DB接続
            foreach ($user_cart as $key => $val){
                $stmt = $dbh->prepare("SELECT product_id, product_name, product_price, product_img FROM products WHERE product_id=?");
                $data[0] = $val;
                $stmt->execute($data);

                $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$rec) {
                    echo "指定したデータはありません。" . "<br>";
                    exit;
                }
                $product_name[] = $rec["product_name"];
                $product_price[] = $rec["product_price"];
                $product_img[] = $rec["product_img"];
            }
            $dbh = null;    // DB切断
        } catch (Exception $e) {     // DB接続が出来なたった時
            echo error_msg();     // 会員情報接続エラー表示
            exit;
        }
        ?>

        <!-- 商品一覧表示 -->
        <form action="goods_qty.php" method="post">
            <h3>カート内商品一覧</h3>
            <div class="cart-list">
                <?php
                for ($i = 0; $i < $cartin_products; $i++) {     // カート内の商品数分ループ
                    if (empty($product_img[$i]) === true) {
                        $disp_product_img = "";
                    } else {
                        $disp_product_img = "<img src='../product/img/".$product_img[$i]."'  width='100%' height='100%'>";
                    }
                ?>
                <div class="cart-row">
                    <div class="cart-img">
                        <?= $disp_product_img; ?>
                    </div>
                    <div class="cart-summry">
                        <strong><?= $product_name[$i];?></strong><br>
                        価格:<?= $product_price[$i]."円　";?><br>
                        数量:
                        <select name="product_qty<?= $i;?>">
                            <option value="<?= $product_qty[$i];?>"><?= $product_qty[$i];?></option>
                            <?php
                            for ($j = 1; $j <= 10; $j++) {
                                if ($j == $product_qty[$i]) {
                                    continue;
                                } else {
                                    echo "<option value='$j'>$j</option>";
                                }
                            }
                            ?>
                        </select>
                        削除:<input type="checkbox" name="delete<?= $i;?>"><br>
                        小計:<?= (int)$product_price[$i] * (int)$product_qty[$i]."円";?><br>
                    </div>
                </div>
                <?php
                };  // ループ終了
                ?>
            </div>
            <br>
            <input type="hidden" name="cartin_products" value="<?= $cartin_products; ?>">
            <input type="button" onclick="history.back()" value="戻る">
            <input type="submit" value="数量変更/削除">
            &emsp;&emsp;<a href="buy_check.php">購入手続きへ進む</a>
        </form>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>