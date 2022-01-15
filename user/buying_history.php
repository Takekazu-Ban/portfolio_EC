<!-- 注文履歴画面 -->

<!-- ヘッダー呼出 -->
<?php include("../common/header.php"); ?>
<!-- 関数呼出 -->
<?php require_once '../common/functions.php'; ?>

<!-- 振込先表示 -->
<div class="order-history-side">
    <div class="history-side-top">
        <h3><strong>商品代金お振り込み先</strong></h3>
        <br>
        <font size='3'>XXX銀行</font><br>
        <font size='3'>XXX支店</font><br>
        <font size='3'>普通口座 XXXXXXX</font><br><br>
        <p>入金確認が取れ次第、商品を発送致します。</p>
    </div>
    <div class="history-side-bottom">
        <input type="button" onclick="history.back()" value="戻る">
    </div>
</div>

<div class="order-main-center">
    <body>
        <?php
        try {
            /* DBから注文履歴呼出 */
            $dbh = db_open();
            $order_user_id = $_SESSION["user_id"];
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
                } else {
                    $total_fee = $rec_order['order_qty'] * $rec_order['order_price'];
                    /* 個別の注文履歴表示 */
                    // 注文した日時が同じ場合、注文をまとめる
                    if ($rec_order['order_time'] == $_SESSION['order_time']) {
                    echo "<div class='order-history-box-low'>";
                        echo "<div class='order-history-null-head'>";
                        echo "</div>";
                    } else {
                    echo "<div class='order-history-box'>";
                        echo "<div class='order-history-head'>";
                            echo "<strong>". "注文日時：". $rec_order['order_time']."</strong>". "&emsp;&emsp;";
                        echo "</div>";
                    }
                    $_SESSION['order_time'] = $rec_order['order_time'];

                        $product_id = $rec_order['order_product_id'];
                        $dbh = db_open();   // DB接続
                        $stmt_pro = $dbh->prepare("SELECT * FROM products WHERE product_id = :product_id");
                        $stmt_pro->bindParam(":product_id", $product_id, PDO::PARAM_INT);
                        $stmt_pro->execute();   // SQL実行
                        $dbh = null;    // DB切断
                        $rec_pro = $stmt_pro->fetch(PDO::FETCH_ASSOC);
                        if (empty($rec_pro["product_img"]) === true) {
                            $disp_product_img = "";
                        } else {
                            $disp_product_img = "<img src='../product/img/".$rec_pro['product_img']."' width='100%' height='100%'>";
                        }
                        /* 注文画像表示 */
                        echo "<div class='order-img'>";
                            echo $disp_product_img;
                        echo "</div>";
                        /* 注文内容表示 */
                        echo "<div class='order-history-sub'>";
                            echo $rec_pro['product_name']. "<br>";
                            echo "個数：". $rec_order['order_qty']. "&emsp;". "(単価：". $rec_order['order_price']. "円)". "<br>";
                            echo "合計：". $total_fee. "円". "<br>";
                        echo "</div>";
                        /* 注文ステータス表示 */
                        echo "<div class='order-status'>";
                            /* 入金状況の表示 */
                            echo "入金状況：";
                            if (empty($rec_order['payment_status'])) {
                                echo "<strong>". "入金待ち". "</strong>". "<br>";
                            } else {
                                echo "<strong>". $rec_order['payment_status']. "</strong>". "<br>";
                            }
                            /* 発送状況の表示 */
                            echo "発送状況：";
                            if (empty($rec_order['ship_status'])) {
                                echo "<strong>". "準備中". "</strong>". "<br>";
                            } else {
                                echo "<strong>". $rec_order['ship_status']. "</strong>". "<br>";
                            }
                            /* 注文キャンセルボタンの表示 */
                            if (($rec_order['ship_status']) == "発送済み") {
                                echo "<div class= 'no-cancel'>". "<strong>";
                                echo "商品が既に発送された為、". "<br>". "キャンセル出来ません。";
                                echo "</strong>". "</div>";
                            } else {
                                $order_id = $rec_order['order_id'];
                                $order_delete = <<<EOD
                                <input type='button' onclick="location.href='../ec_shop/order_delete.php?id=$order_id'" value='注文キャンセル'>
                                EOD;
                                echo $order_delete;
                            }
                        echo "</div>";
                    echo "</div>";
                    $order_count .= 1;
                }
            }
            /* 注文履歴が無い場合のメッセージ表示 */
            if ($order_count == 0) {
                echo "<center>";
                    echo "<br><br>";
                    echo "<h4><strong>現在、注文した商品はありません。</strong></h4>";
                echo "</center>";
                echo "<div class='btn-w40'>";
                echo "<input type='button' onclick='history.back()' value='戻る' class='return-btn'>";
                echo "</div>";
            }
        } catch (Exception $e) {     // DB接続が出来なたった時
            echo error_msg();     // 接続エラー表示
            exit;
        }
        ?>
    </body>
</div>

<!-- フッター呼出 -->
<?php include("../common/footer.php"); ?>