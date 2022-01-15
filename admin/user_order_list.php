<!-- 会員別の注文一覧画面 -->

<!-- ヘッダー呼出 -->
<?php include("../common/header.php"); ?>

<div class="order-top-center">
    <?php
    require_once '../common/functions.php';    // 関数呼出
    /* DBから会員を取得 */
    $user_id = $_GET["id"];
    $dbh = db_open();   // DB接続
    $stmt = $dbh->prepare("SELECT user_id, user_name FROM users WHERE user_id = :user_id");   // SQLでadminsテーブルからIDと名前を選択
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();    // SQL実行
    $dbh = null;    // DB切断
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <font size="5"><strong>ID：<?= $rec['user_id']; ?>&emsp;</strong></font>
    <font size="5"><strong><?= $rec['user_name']; ?></strong></font>
    <font size="4">さんの注文履歴一覧</font>
</div>
<div class="order-middle-center">
    <body>
        <?php
        try {
            /* 会員のDBから注文履歴を取得 */
            $dbh = db_open();
            $order_user_id = $_GET["id"];
            $stmt = $dbh->prepare("SELECT * FROM orders WHERE order_user_id = :order_user_id ORDER BY order_time DESC");
            $stmt->bindParam(':order_user_id', $order_user_id, PDO::PARAM_INT);
            $stmt->execute();
            $dbh = null;

            /* 注文履歴一覧 */
            $order_count = 0;   // 注文履歴数カウント変数
            while (true) {
                $rec_order = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($rec_order === false) {
                    break;
                }
                $total_fee = $rec_order['order_qty'] * $rec_order['order_price'];
                /* 個別の注文履歴表示 */
                    /* 注文履歴ヘッダー表示 */
                    // 注文した日時が同じ場合、注文をまとめる
                    if ($rec_order['order_time'] == $_SESSION['order_time']) {
                        echo "<div class='order-box-low'>";
                            echo "<div class='order-null-head'>";
                            echo "</div>";
                        } else {
                        echo "<div class='order-box'>";
                            echo "<div class='order-head'>";
                                echo "<strong>". "注文日時：". $rec_order['order_time']."</strong>". "&emsp;&emsp;";
                            echo "</div>";
                        }
                        $_SESSION['order_time'] = $rec_order['order_time'];

                    $product_id = $rec_order['order_product_id'];
                    /* DBから注文した商品情報呼出 */
                    $dbh = db_open();
                    $stmt_pro = $dbh->prepare("SELECT * FROM products WHERE product_id = :product_id");
                    $stmt_pro->bindParam(":product_id", $product_id, PDO::PARAM_INT);
                    $stmt_pro->execute();
                    $dbh = null;
                    $rec_pro = $stmt_pro->fetch(PDO::FETCH_ASSOC);

                    /* 注文商品内容表示 */
                    echo "<div class='order-sub'>";
                        echo "<strong>". $rec_pro['product_name']. "</strong>". "&emsp;". "×". "&emsp;". $rec_order['order_qty']. "個". "<br>";
                        echo "合計：". $total_fee. "円". "&emsp;". "(単価：". $rec_order['order_price']. "円)". "<br>";
                    echo "</div>";

                    /* 注文ステータス表示 */
                    $payment_status = $rec_order['payment_status'];
                    $ship_status = $rec_order['ship_status'];
                    $ship_status = $rec_order['ship_status'];
                    if ($payment_status == '入金待ち') {
                        if ($ship_status != '準備中') {
                            $ship_status = '準備中';
                            echo "<input type='hidden' name='ship_status' value='$ship_status'>";
                        }
                    } else {
                        if ($ship_status != '発送済み') {
                            $ship_status = '発送準備中';
                            echo "<input type='hidden' name='ship_status' value='$ship_status'>";
                        } else {
                            $ship_status = '発送済み';
                            echo "<input type='hidden' name='ship_status' value='$ship_status'>";
                        }
                    }
                    echo "<div class='order-status-box'>";
                        echo "<form action='order_update.php' method='post'>";
                            /* ステータス更新ボタン */
                            echo "<div class='status-update-btn'>";
                                if ($ship_status == '発送済み') {
                                    echo "<strong><font color='red'>処理<br>完了</font></strong>";
                                } else {
                                    echo "<button class='update-btn' type='submit'><strong>更新</strong></button>";
                                }
                            echo "</div>";
                            echo "<div class='order-status-select'>";
                                /* 入金状況の表示 */
                                echo "<strong>". "代金入金状況：". "</strong>";
                                if ($payment_status == '入金済み') {
                                    echo "<select name='payment_status' disabled>";
                                        echo "<option value='入金済み'>入金済み</option>";
                                    echo "</select>";
                                    $payment_status == '入金済み';
                                    echo "<input type='hidden' name='payment_status' value='$payment_status'>";
                                } else {
                                    echo "<select name='payment_status'>";
                                        echo "<option value='入金待ち'>入金待ち</option>";
                                        echo "<option value='入金済み'>入金済み</option>";
                                    echo "</select>";
                                }
                                echo "<br>";
                            echo "</div>";
                            echo "<div class='order-status-select'>";
                                /* 発送状況の表示 */
                                echo "<strong>". "商品発送状況：". "</strong>";
                                if ($ship_status == '発送準備中') {
                                    echo "<select name='ship_status'>";
                                        echo "<option value='発送準備中'>発送準備中</option>";
                                        echo "<option value='発送済み'>発送済み</option>";
                                    echo "</select>";
                                } elseif ($ship_status == '発送済み') {
                                    echo "<select name='ship_status' disabled>";
                                        echo "<option value='発送済み'>発送済み</option>";
                                    echo "</select>";
                                } else {
                                    echo "<select name='ship_status'>";
                                        echo "<option value='準備中'>準備中</option>";
                                        echo "<option value='発送準備中'>発送準備中</option>";
                                        echo "<option value='発送済み'>発送済み</option>";
                                    echo "</select>";
                                }
                                echo "<br>";
                            echo "</div>";
                            $order_user_id = $rec_order['order_user_id'];
                            $order_id = $rec_order['order_id'];
                            $order_time = $rec_order['order_time'];
                            echo "<input type='hidden' name='order_id' value='$order_id'>";
                            echo "<input type='hidden' name='order_user_id' value='$order_user_id'>";
                            echo "<input type='hidden' name='order_time' value='$order_time'>";
                        echo "</form>";
                    echo "</div>";
                echo "</div>";
                $order_count .= 1;
            }

            /* 注文履歴が無い場合のメッセージ表示 */
            if ($order_count == 0) {
                echo "<center>";
                    echo "<br><br>";
                    echo "<h4><strong>まだ、注文した商品がありません。</strong></h4>";
                echo "</center>";
            }
        } catch (Exception $e) {     // DB接続が出来なたった時
            echo error_msg_admin();     // 管理者情報接続エラー表示
            exit;
        }
        ?>
    </body>
</div>
<div class="order-buttom-center">
    <a href="../admin/user_list.php">会員一覧に戻る</a>
    &emsp;&emsp;&emsp;&emsp;
    <a href="../admin/order_list.php">注文一覧ページへ</a>
</div>

<!-- フッター呼出 -->
<?php include("../common/footer.php"); ?>