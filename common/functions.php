<!-- 関数 -->

<?php
/* 受取った情報にそれぞれXSS対策を行う関数 */
function sanitize($before) {
    foreach($before as $key => $value) {
        $after[$key] = htmlspecialchars($value, ENT_QUOTES, "UTF-8");
    }
    return $after;
}

/* DB接続を行う関数 */
function db_open() {
    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
    ];
    /* ローカル環境設定 */
    $user = "AdminUser00";
    $password = "TEST100y";
    $dbh = new PDO('mysql:host=localhost;dbname=EC_Portfolio', $user, $password, $opt);

    /* 本番環境設定 */
    // $user = "portfolio22";
    // $password = "pass745";
    // $dbh = new PDO('mysql:host=localhost;dbname=portfolio22', $user, $password, $opt);

    return $dbh;
}

/* エラーメッセージ表示 */
function error_msg() {
    $error_msg = "只今システム障害発生中。<br><br><a href='../user/user_login.php'>ログイン画面へ</a>";
    return $error_msg;
}
function error_msg_admin() {
    $error_msg = "只今システム障害発生中。<br><br><a href='../admin/admin_login.php'>ログイン画面へ</a>";
    return $error_msg;
}

/* 商品追加カテゴリー選択表示 */
function pulldown_category() {
    echo "<select name='product_cat'>";
        echo "<option value='食品'>食品</option>";
        echo "<option value='家電'>家電</option>";
        echo "<option value='書籍'>書籍</option>";
        echo "<option value='日用品'>日用品</option>";
        echo "<option value='その他'>その他</option>";
    echo "</select>";
}

/* カテゴリーごとの商品合計計算 */
function product_count() {
    $product_count = 0;
    $dbh = db_open();   // DB接続
    $url = $_SERVER['REQUEST_URI'];     // 現在のURLを取得
    session_regenerate_id(true);
    if (strstr($url, 'eart')) {
        $stmt = $dbh->prepare("SELECT * FROM products WHERE product_cat = ?");
        $data[] = "食品";
        $stmt->execute($data);
    } else if (strstr($url, 'kaden')) {
        $stmt = $dbh->prepare("SELECT * FROM products WHERE product_cat = ?");
        $data[] = "家電";
        $stmt->execute($data);
    } else if (strstr($url, 'book')) {
        $stmt = $dbh->prepare("SELECT * FROM products WHERE product_cat = ?");
        $data[] = "書籍";
        $stmt->execute($data);
    } else if (strstr($url, 'niti')) {
        $stmt = $dbh->prepare("SELECT * FROM products WHERE product_cat = ?");
        $data[] = "日用品";
        $stmt->execute($data);
    } else if (strstr($url, 'sonota')) {
        $stmt = $dbh->prepare("SELECT * FROM products WHERE product_cat = ?");
        $data[] = "その他";
        $stmt->execute($data);
    } else {
        if (!empty($_POST['keyword'])) {
            $stmt = $dbh->prepare("SELECT * FROM products WHERE product_name LIKE '%" . $_POST['keyword'] . "%' ");
        } else {
            $stmt = $dbh->prepare("SELECT * FROM products");
        }
        $stmt->execute();
    }
    $dbh = null;
    while (true) {
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($rec === false) {   // DBの商品を全て表示している場合
            break;  // ループ終了
        }
        $product_count = $product_count + 1;
    }
    return $product_count;
}

