<!-- 注文キャンセル確認画面 -->

<!-- ヘッダー表示 -->
<?php include("../common/header.php"); ?>

<div class="product-main-center">
    <body>
        <?php
        require_once '../common/functions.php';     // 関数呼出
        $order_id = $_GET["id"];    // 受取ったキャンセル注文ID
        ?>

        <!-- 注文キャンセル確認コメント表示 -->
        <h3 style="text-align:center"><strong>本当に、注文をキャンセルしますか？</strong></h3>
        <form action="order_delete_done.php" method="post">
            <input type="hidden" name="order_id" value="<?= $order_id; ?>">
            <div class="btn-w40">
                <input type="submit" value="注文をキャンセルします。" class="OK-btn"><br>
                <input type="button" onclick="history.back()" value="戻る" class="return-btn">
            </div>
        </form>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>