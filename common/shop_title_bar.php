<!-- 商品一覧画面のタイトルバー表示 -->

<div class="shop-list-title">
    <h3>
        <?php
        if ($_POST['page'] == null) {
            $page = 1;
            $_SESSION['page'] = $page;
        } else {
            $page = $_POST['page'];
            $_SESSION['page'] = $page;
        }
        $num = $page - 1;
        $product_elem = 20;  // 表示する商品数
        $page_remainder = floor(product_count() % $product_elem);
        /* 最大ページ数判定 */
        if (product_count() <= $product_elem) {
            $max_page = 1;
        } elseif ($page_remainder > 0) {
            $max_page = floor(product_count() / $product_elem) + 1;
        } else {
            $max_page = floor(product_count() / $product_elem);
        }
        if ($page > 1) {
            $num = $product_elem * $num;
            $product_elem = $num + $product_elem;
        }
        echo "<div class='title-left'>";
            if (!empty($_POST['keyword'])) {
                echo "&ensp;". "<strong>". "検索結果". "</strong>";
            } else {
                if (strstr($url, 'shop_list.php')) {
                    echo "&ensp;". "<strong>". "商品一覧". "</strong>";
                } elseif (strstr($url, 'shop_list_eart.php')) {
                    echo "&ensp;". "<strong>". "食品一覧". "</strong>";
                } elseif (strstr($url, 'shop_list_kaden.php')) {
                    echo "&ensp;". "<strong>". "家電一覧". "</strong>";
                } elseif (strstr($url, 'shop_list_book.php')) {
                    echo "&ensp;". "<strong>". "書籍一覧". "</strong>";
                } elseif (strstr($url, 'shop_list_niti.php')) {
                    echo "&ensp;". "<strong>". "日用品一覧". "</strong>";
                } else {
                    echo "&ensp;". "<strong>". "その他一覧". "</strong>";
                }
            }
            echo "（全:". product_count(). "件）";
        ?>
            <!-- 現在の表示件数 -->
            <?php if ($max_page > 1): ?>
                <?php if ($page != $max_page): ?>
                    <font size="4">&ensp; <?= $num + 1; ?>〜<?= $product_elem; ?>件目を表示</font>
                <?php else: ?>
                    <font size="4">&ensp; <?= $num + 1; ?>〜<?= product_count(); ?>件目を表示</font>
                <?php endif; ?>
            <?php endif; ?>
        <?php  echo "</div>"; ?>

        <!-- 現在の表示商品数 -->
        <div class='title-right'>
            <form action="shop_list.php" method="post">
                <input type="text" name="keyword">
                <input type="submit" value="検索">
            </form>
        </div>
    </h3>
</div>