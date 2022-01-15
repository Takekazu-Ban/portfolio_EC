<!-- 商品追加画面 -->

<!-- ヘッダー呼出 -->
<?php include("../common/header.php"); ?>
<!-- 関数呼出 -->
<?php require_once '../common/functions.php';?>

<!-- 追加商品入力 -->
<div class="main-center">
    <body>
        <form action="product_add_check.php" method="post" enctype="multipart/form-data">
            <h3>商品追加</h3>
            <br><br>
            <label for="product_cat">カテゴリー</label><br>
            <?= pulldown_category(); ?>
            <br><br>
            <label for="product_name">商品名</label><br>
            <input type="text" name="product_name">
            <br><br>
            <label for="product_price">価格</label><br>
            <input type="text" name="product_price">円
            <br><br>
            <label for="product_img">画像</label><br>
            <input type="file" name="image">
            <br><br>
            <label for="product_exp">説明</label><br>
            <textarea name="product_exp" style="width: 500px; height: 100px;"></textarea>
            <br><br>
            <input type="button" onclick="history.back()" value="戻る">
            <input type="submit" value="OK">
        </form>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>