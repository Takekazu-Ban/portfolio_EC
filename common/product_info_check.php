<!-- 追加する商品情報チェック -->

<?php
if($product_img["size"] > 0) {     // 商品画像サイズが0B以上の場合
    if($product_img["size"] > 10000000) {     // 商品画像が10MB以上の場合
        $error_msg = "・ファイルのサイズが大きすぎます。<br>";
        $judge = false;
    }
}
if (empty($product_name) === true) {    // 商品名が未入力の時
    $error_msg .= "・商品名が入力されていません。<br>";
    $judge = false;
} else {
    if (mb_strlen($product_name) > 20) {
        $error_msg .= "・商品名は、20文字以内で入力してください。<br>";
        $judge = false;
    }
}
if (empty($product_price)) {    // 価格が未入力の場合
    $error_msg .= "・価格を入力してください。<br>";
    $judge = false;
}
if (preg_match("/\A[0-9]+\z/", $product_price) === 0) {     // 半角英数字以外が入力された場合
    $error_msg .= "・価格に正しい値を入力してください。<br>";
    $judge = false;
}
if (empty($product_exp) === true) {     // 説明文が入力されていない場合
    $error_msg .= "・説明文が入力されていません。<br>";
    $judge = false;
}
if (mb_strlen($comments) > 1000) {   // 説明文が1001文字以上の場合
    $error_msg .= "・文字数は1000文字が上限です。<br>";
    $judge = false;
}

if ($judge == true) {   // 入力エラーがない場合
    $url = $_SERVER['REQUEST_URI'];     // 現在のURLを取得
    session_start();
    session_regenerate_id(true);
    if ($product_img["size"] == 0) {
        if (strstr($url, 'product_edit')) {
            echo "<div class='check-img'>";
                echo "<img src='../product/img/".$old_image."' width='100%' height='100%'><br>";
            echo "</div>";
        } else {
            echo "<div class='check-img'>";
                echo "<img src='../product/img/no_image.png' width='100%' height='100%'><br>";
                $product_img['name'] = "no_image.png";
            echo "</div>";
        }
    } else {
        move_uploaded_file($product_img["tmp_name"],"../product/img/".$product_img["name"]);
        echo "<div class='check-img'>";
            echo "<img src='../product/img/".$product_img['name']."' width='100%' height='100%'><br>";
        echo "</div>";
    }
    echo "<div class='check-summry'>";
        echo "<strong>カテゴリー:</strong>". $product_cat. "<br>";
    echo "</div>";
    echo "<div class='check-summry'>";
        echo "<strong>商品名　　:</strong>". $product_name. "<br>";
    echo "</div>";
    echo "<div class='check-summry'>";
        echo "<strong>価格　　　:</strong>". $product_price. "円". "<br>";
    echo "</div>";
    echo "<div class='check-summry-null'>";
    echo "</div>";
    echo "<div class='check-exp'>";
        echo "<br><strong>商品説明</strong><br>";
        echo nl2br($product_exp);
    echo "</div>";
}