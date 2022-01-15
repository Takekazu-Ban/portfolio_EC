<!-- 注文確定画面 -->

<!-- ヘッダー表示 -->
<?php include("../common/header.php"); ?>

<div class="main-center">
    <body>
        <?php
        require_once '../common/functions.php';     // 関数呼出
        try {
            /* XSS対策 */
            $user_info = sanitize($_POST);
            $user_name = $user_info["user_name"];
            $user_address = $user_info["user_address"];
            $user_tel = $user_info["user_tel"];
            $user_cart = $_SESSION["user_cart"];
            $order_qty = $_SESSION["product_qty"];
            $cartin_products = count($user_cart);

            /* 注文完了メッセージ表示 */
            echo "<div class='buy-top'>";
                echo "<strong>". $user_name. "</strong>". "様<br>";
                echo "この度は、ご注文ありがとうございました!<br>";
                echo "商品は入金を確認次第、下記の住所に発送致します。<br>";
                echo "住所: ". $user_address. "<br>";
            echo "</div>";

            /* 確認文1/3 */
            $order_text1 = "<strong>". "<font size='3'>". "ご注文商品一覧". "</font>". "</strong><br>";

            /* DBから注文商品情報の選択呼出 */
            $dbh = db_open();   // DB接続
            for ($i = 0; $i < $cartin_products; $i++) {     // カート内の商品分ループ処理
                $stmt = $dbh->prepare("SELECT product_name, product_price FROM products WHERE product_id=?");
                $data[0] = $user_cart[$i];
                $stmt->execute($data);
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);

                /* 小計の計算 */
                $product_name = $rec["product_name"];
                $product_price = $rec["product_price"];
                $order_price[] = $product_price;
                $qty = $order_qty[$i];
                $subtotal = $product_price * $qty;
                $total_price = $total_price + $subtotal;

                /* 確認文2/3 */
                $order_text1 .= $product_name. ":";
                $order_text1 .= $product_price. "円x";
                $order_text1 .= $qty. "個=";
                $order_text1 .= $subtotal. "円\n";
            }
            // 注文ステータス初期値定義
            $payment_status = '入金待ち';
            $ship_status = '準備中';

            /* DBに注文情報追加 */
            for ($i = 0; $i < $cartin_products; $i++) {     // カート内の商品分ループ処理
                $stmt = $dbh->prepare("INSERT INTO orders(order_id, order_user_id, order_product_id, order_price, order_qty, payment_status, ship_status, order_time) VALUES(NULL, :order_user_id, :order_product_id, :order_price, :order_qty, :payment_status, :ship_status, now())");
                $stmt->bindParam(":order_user_id", $_SESSION["user_id"], PDO::PARAM_STR);
                $stmt->bindParam(":order_product_id", $user_cart[$i], PDO::PARAM_INT);
                $stmt->bindParam(":order_price", $order_price[$i], PDO::PARAM_INT);
                $stmt->bindParam(":order_qty", $order_qty[$i], PDO::PARAM_INT);
                $stmt->bindParam(":payment_status", $payment_status, PDO::PARAM_STR);
                $stmt->bindParam(":ship_status", $ship_status, PDO::PARAM_STR);
                $stmt->execute();
            }
            $dbh = null;    // DB切断

            /* 確認文3/3 */
            $order_text1 .= "\n";
            $order_text1 .= "--------------------------------------\n";
            $order_text1 .= "<strong>". "請求合計金額". $total_price. "</strong>". "円\n";
            $order_text1 .= "送料は無料です。\n";
            $order_text1 .= "--------------------------------------\n";
            $order_text1 .= "\n";
            $order_text2 = "代金は、以下の口座にお振り込み下さい。\n";
            $order_text2 .= "XXX銀行 XXX支店 普通口座 XXXXXXX\n";
            $order_text2 .= "入金確認が取れ次第、商品を発送致します。\n";
            $order_text2 .= "\n";
            $order_text2 .= "◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆\n";
            $order_text2 .= "~フェイクショップ~\n";
            $order_text2 .= "\n";
            $order_text2 .= "所在地: 東京都 XXX区 XXXビル XXX階\n";
            $order_text2 .= "TEL: 090-XXXX-XXXX\n";
            $order_text2 .= "メール: XXXXXXXX@fake.com\n";
            $order_text2 .= "◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆\n";

            echo "<div class='buy-middle'>";
                echo nl2br($order_text1);     // 改行
            echo "</div>";

            echo "<div class='buy-buttom'>";
                echo "<br>";
                echo nl2br($order_text2);     // 改行
                echo "<a href='../ec_shop/shop_list.php'>トップ画面へ</a>";
            echo "</div>";

        } catch (Exception $e) {     // DB接続が出来なたった時
            echo error_msg();     // 会員情報接続エラー表示
            exit;
        }

        $_SESSION["user_cart"] = array();
        $_SESSION["product_qty"] = array();
        ?>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>