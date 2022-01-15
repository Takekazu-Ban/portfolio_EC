<!-- 商品編集チェック・確認 -->

<!-- ヘッダー呼出 -->
<?php include("../common/header.php"); ?>

<div class="check-main-center">
    <boby>
    <?php
    require_once '../common/functions.php';
    /* 追加する商品情報にXSS対策を行い、各変数に代入 */
    $product_info = sanitize($_POST);     // 受取った値にXSS対策を行う
    $product_id = $product_info["product_id"];
    $product_name = $product_info["product_name"];
    $product_price = $product_info["product_price"];
    $product_img = $_FILES["image"];
    $old_image = $product_info["old_image"];
    $product_exp = $product_info["product_exp"];
    $product_cat = $product_info["product_cat"];
    $judge = true;   // 判定を初期化

    /* 商品情報チェック */
    require_once '../common/product_info_check.php';

    /* 判定によるメッセージ条件分岐 */
    if ($judge === false) {
        echo "<form>";
        echo "<h3>商品編集エラー</h3>";
        echo $error_msg;    // エラー項目を表示
        echo "<br>";
        echo "<input type='button' onclick='history.back()' value='戻る'>";
        echo "</form>";
    } else {
        echo "上記の商品を編集しますか？";
        echo "<form action='product_edit_done.php' method='post'>";
        echo "<input type='hidden' name='product_cat' value='".$product_cat."'>";
        echo "<input type='hidden' name='product_id' value='".$product_id."'>";
        echo "<input type='hidden' name='product_name' value='".$product_name."'>";
        echo "<input type='hidden' name='product_price' value='".$product_price."'>";
        echo "<input type='hidden' name='product_img' value='".$product_img['name']."'>";
        echo "<input type='hidden' name='old_image' value='".$old_image."'>";
        echo "<input type='hidden' name='product_exp' value='".$product_exp."'>";
        echo "<input type='button' onclick='history.back()' value='戻る'>";
        echo "<input type='submit' value='OK'>";
        echo "</form>";
    }
    ?>
    </boby>
</div>

<!-- フッター呼出 -->
<?php include("../common/footer.php"); ?>