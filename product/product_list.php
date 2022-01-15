<!-- 商品一覧画面 -->

<!-- ヘッダー呼出 -->
<?php include("../common/header.php"); ?>

<div class="main-center-lage">
    <body>
    <?php
    require_once '../common/functions.php';     // 関数呼出
    try {
        $dbh = db_open();   // DB接続
        $stmt = $dbh->prepare("SELECT product_id, product_name, product_cat, product_price FROM products");
        $stmt->execute();    // SQL実行
        $dbh = null;    // DB切断

        echo "<h3>商品一覧</h3><br>";

        /* 商品一覧表の表示 */
        echo "<form action='product_branch.php' method='post'>";
        echo "<table class='table-header' border='2' width='100%'>";
        echo "<tr>";
        echo "<th width='10%'>カテゴリー</th>";
        echo "<th width='55%' align='center'>商品名</th>";
        echo "<th width='15%'>値段</th>";
        echo "<th>操作</th>";
        echo "</tr>";
        echo "</table>";
        echo "<div class='list-frame'>";
        echo "<table class='table-col' border='1' width='100%'>";

        /* DBから取得した商品を一覧表示するループ */
        while (true) {
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($rec === false) {
                break;
            }
            echo "<tr height='40'>";
            echo "<td width='10%'>";
            echo "&nbsp;";
            echo $rec['product_cat'];
            echo "</td>";
            echo "<td width='55%'>";
            $product_id = $rec['product_id'];
            echo "<a href='product_show.php?id=".$product_id."'>";
            echo "&nbsp;";
            echo $rec['product_name'];
            echo "</a>";
            echo "</td>";
            echo "<td width='15%'>";
            echo "&nbsp;";
            echo $rec['product_price']. "円";
            echo "</td>";
            echo "<td align='center'>";
            $product_edit = <<<EOD
            <input type='button' onclick="location.href='../product/product_edit.php?id=$product_id'" value='編集'>
            EOD;
            echo $product_edit;
            echo "</td>";
            echo "<td align='center'>";
            $product_delete = <<<EOD
            <input type='button' onclick="location.href='../product/product_delete.php?id=$product_id'" value='削除'>
            EOD;
            echo $product_delete;
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";

        /* 操作ボタン表示 */
        echo "<div class='product-main-center'>";
            echo "<input class='add-btn' type='submit' name='add' value='追加'>";
        echo "</div>";
    } catch(Exception $e) {     // DB接続が出来なたった時
        error_msg_admin();     // 接続エラー表示
        exit;
    }
    ?>
    <div class="product-main-center">
        <br>
        <a href="../admin/admin_top.php">管理者TOPページへ</a>
    </div>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>