<!-- 検索機能 -->

<?php
if (!empty($_POST['keyword'])) {    // 検索キーワードが入力されている場合
    $_SESSION['keyword'] = $_POST['keyword'];
    $stmt = $dbh->prepare("SELECT * FROM products WHERE product_name LIKE '%" . $_SESSION['keyword'] . "%' ");
} else {    // 検索キーワードが入力されていない場合
    $_SESSION['keyword'] = null;
    $stmt = $dbh->prepare("SELECT * FROM products");
}
