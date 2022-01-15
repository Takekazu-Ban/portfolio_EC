<!-- 注文商品キャンセル実行 -->

<!-- ヘッダー表示 -->
<?php include("../common/header.php"); ?>

<div class="main-center">
    <body>
        <?php
        require_once '../common/functions.php';     // 関数呼出
        try {
            /* XSS対策 */
            $order_info = sanitize($_POST);
            $order_id = $order_info["order_id"];

            /* 注文商品削除 */
            $dbh = db_open();   // DB接続
            $stmt = $dbh->prepare("DELETE FROM orders WHERE order_id = :order_id");
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->execute();   // DBから商品削除実行
            $dbh = null;    // DB切断
        } catch (Exception $e) {     // DB接続が出来なたった時
            echo error_msg();     // 管理者情報接続エラー表示
            exit;
        }
        /* ローカル環境時の画面遷移 */
        header("Location:../user/buying_history.php");
        /* 本番環境時の画面遷移 */
        echo <<<EOF
        <script>
            location.href='https://portfolio22.shop/user/buying_history.php';
        </script>
        EOF;
        ?>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>