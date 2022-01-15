<!-- 注文確認画面 -->

<!-- ヘッダー表示 -->
<?php include("../common/header.php"); ?>

<div class="main-center-lage">
    <body>
        <?php
        require_once '../common/functions.php';     // 関数呼出
        try {
            // 注文情報の受取
            $user_id = $_SESSION["user_id"];
            $user_cart = $_SESSION["user_cart"];
            $product_qty = $_SESSION["product_qty"];
            $cartin_products = count($user_cart);

            /* 指定の会員情報呼出 */
            $dbh = db_open();   // DB接続
            $stmt = $dbh->prepare("SELECT user_name, user_email, user_address, user_tel FROM users WHERE user_id = :user_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();

            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            /* 購入者情報を各変数に代入 */
            $user_name = $rec['user_name'];
            $user_email = $rec['user_email'];
            $user_address = $rec['user_address'];
            $user_tel = $rec['user_tel'];
            echo "<div class='order-cofirm-top'>";
                echo "<h3>注文内容確認</h3>";
                echo "下記の内容でよろしいでしょうか？";
            echo "</div>";

            /* 注文内容確認表示 */
            echo "<div class='order-cofirm-left'>";
            echo "【ご注文内容】<br>";
                echo "<div class='order-cofirm-list'>";
                    for ($i = 0; $i < $cartin_products; $i++) {
                        $stmt = $dbh->prepare("SELECT product_name, product_price, product_img FROM products WHERE product_id = ?");
                        $data = array();
                        $data[] = $user_cart[$i];
                        $stmt->execute($data);   // カート内商品選択実行
                        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                        if (empty($rec["product_img"]) === true) {
                            $disp_product_img = "";
                        } else {
                            $disp_product_img = "<img src='../product/img/".$rec['product_img']."' width='100%' height='100%'>";
                        }
                        /* カート内商品表示 */
                        echo "<div class='cart-row'>";
                            echo "<div class='cart-img'>";
                                echo $disp_product_img;
                            echo "</div>";
                            echo "<div class='cart-summry'>";
                                echo "商品名:".$rec['product_name']."<br>";
                                echo "価格:".$rec['product_price']."円　<br>";
                                echo "数量:".$product_qty[$i]."<br>";
                                echo "合計価格:".$rec['product_price'] * $product_qty[$i]."円<br><br>";
                                $payment[] = $rec['product_price'] * $product_qty[$i];
                            echo "</div>";
                        echo "</div>";
                    }
                echo "</div>";
            echo "</div>";

            /* 購入者情報確認表示 */
            echo "<div class='order-cofirm-up'>";
                echo "【宛先】<br>";
                echo "お名前:". $user_name. "様<br>";
                echo "メールアドレス:". $user_email. "<br>";
                echo "ご住所:". $user_address. "<br>";
                echo "ご連絡先:". $user_tel. "<br><br>";
            echo "</div>";

            /* 請求情報確認表示 */
            echo "<div class='order-cofirm-down'>";
                echo "【ご請求金額】";
                echo "<br>";
                echo "<strong>". "<font size='5'>". array_sum($payment). "円". "</font>". "</strong>";
            echo "</div>";

            /* ボタン表示・値渡し */
            echo "<div class='order-cofirm-down'>";
                echo "<br><br>";
                echo "<form action='buy_done.php' method='post'>";
                echo "<input type='hidden' name='user_name' value='".$user_name."'>";
                echo "<input type='hidden' name='user_email' value='".$user_email."'>";
                echo "<input type='hidden' name='user_address' value='".$user_address."'>";
                echo "<input type='hidden' name='user_tel' value='".$user_tel."'>";
                echo "<input type='button' onclick='history.back()' value='戻る'>";
                echo "<input type='submit' value='OK'>";
                echo "</form>";
            echo "</div>";
        } catch (Exception $e) {     // DB接続が出来なたった時
            echo error_msg();     // 会員情報接続エラー表示
            exit;
        }
        $_SESSION["user_cart"] = $user_cart;
        $_SESSION["product_qty"] = $product_qty;
        ?>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>