<!-- 商品画面分岐 -->

<?php
if (isset($_POST["show"]) === true) {
    if (isset($_POST["product_id"]) === false) {  // 指定IDが存在しない場合
        /* ローカル環境時の画面遷移 */
        header("Location:../product/product_ng.php");
        /* 本番環境時の画面遷移 */
        echo <<<EOF
        <script>
            location.href='https://portfolio22.shop/product/product_ng.php';
        </script>
        EOF;
        exit();
    } else {
        $product_id = $_POST["product_id"];
        /* ローカル環境時の画面遷移 */
        header("Location:../product/product_show.php?id=".$product_id);
        /* 本番環境時の画面遷移 */
        echo <<<EOF
        <script>
            location.href='https://portfolio22.shop/product/product_show.php?id=".$product_id';
        </script>
        EOF;
        exit();
    }
}
if (isset($_POST["add"]) === true) {
    /* ローカル環境時の画面遷移 */
    header("Location:../product/product_add.php");
    /* 本番環境時の画面遷移 */
    echo <<<EOF
    <script>
        location.href='https://portfolio22.shop/product/product_add.php';
    </script>
    EOF;
    exit();
}
?>
