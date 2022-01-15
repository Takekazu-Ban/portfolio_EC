<!-- 管理者画面分岐 -->

<?php
if (isset($_POST["add"]) === true) {
    /* ローカル環境時の画面遷移 */
    header("Location:admin_add.php");
    /* 本番環境時の画面遷移 */
    echo <<<EOF
    <script>
        location.href='https://portfolio22.shop/admin/admin_add.php';
    </script>
    EOF;
    exit();
}
?>

