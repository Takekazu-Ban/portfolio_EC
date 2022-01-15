<!-- 管理者トップ画面 -->

<!-- ヘッダー表示 -->
<?php include("../common/header.php"); ?>

<div class="main-center">
    <body>
        <h3>管理者トップ</h3>
        <br><br>
        <input class="admin-btn" type="button" onclick="location.href='../admin/order_list.php'" value="注文一覧　">
        <br>
        <input class="admin-btn" type="button" onclick="location.href='../admin/admin_list.php'" value="管理者一覧">
        <br>
        <input class="admin-btn" type="button" onclick="location.href='../admin/user_list.php'" value="会員一覧　">
        <br>
        <input class="admin-btn" type="button" onclick="location.href='../product/product_list.php'" value="商品一覧　">
        <br>
        <input class="admin-btn-red" type="button" onclick="location.href='../admin/admin_logout.php'" value="ログアウト">
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>