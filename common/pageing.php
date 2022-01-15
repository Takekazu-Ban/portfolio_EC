<!-- ページング機能 -->

<?php
if ($max_page > 1) {
    if (($page_remainder < 5) && ($page == $max_page)){
    echo "<div class='paging-bottom'>";
    } else {
    echo "<div class='paging'>";
    }

    if (strstr($url, 'shop_list.php')) {
        echo "<form action='../ec_shop/shop_list.php' method='POST'>";
        if ($_POST['keyword'] != null) {
            $keyword = $_SESSION['keyword'];
            echo "<input type='hidden' name='keyword' value='$keyword'> ";
        }
    } elseif (strstr($url, 'shop_list_eart.php')) {
        echo "<form action='../ec_shop/shop_list_eart.php' method='POST'>";
    } elseif (strstr($url, 'shop_list_kaden.php')) {
        echo "<form action='../ec_shop/shop_list_kaden.php' method='POST'>";
    } elseif (strstr($url, 'shop_list_book.php')) {
        echo "<form action='../ec_shop/shop_list_book.php' method='POST'>";
    } elseif (strstr($url, 'shop_list_niti.php')) {
        echo "<form action='../ec_shop/shop_list_niti.php' method='POST'>";
    } else {
        echo "<form action='../ec_shop/shop_list_sonota.php' method='POST'>";
    }

        /* ページボタン表示条件分岐 */
        if ($max_page <= 10) {
            for ($i=1; $i<=$max_page; $i++) {
                if ($page == $i) {
                    $now_page = "now-page";
                }
                echo "<input type='submit' name='page' value='$i' class='$now_page'> ";
                $now_page = null;
            }
        } elseif ($page <= 5) {
            for ($i=1; $i<=7; $i++) {
                if ($page == $i) {
                    $now_page = "now-page";
                }
                echo "<input type='submit' name='page' value='$i' class='$now_page'> ";
                $now_page = null;
            }
            echo "&thinsp;…&nbsp;";
            if ($page == $max_page) {
                $now_page = "now-page";
            }
            echo "<input type='submit' name='page' value='$max_page' class='$now_page'> ";
            $now_page = null;
        } elseif ($page > 5) {
            if ($page >= ($max_page - 3)) {
                if ($page == 1) {
                    $now_page = "now-page";
                }
                echo "<input type='submit' name='page' value='1' class='$now_page'>";
                $now_page = null;
                echo "&thinsp;…&nbsp;";
                for ($i=$max_page-6; $i<=$max_page; $i++) {
                    if ($page == $i) {
                        $now_page = "now-page";
                    }
                    echo "<input type='submit' name='page' value='$i' class='$now_page'> ";
                    $now_page = null;
                }
            } else {
                echo "<input type='submit' name='page' value='1'> ";
                echo "&thinsp;…&nbsp;";
                for ($i=$page-2; $i<=$page+2; $i++) {
                    if ($page == $i) {
                        $now_page = "now-page";
                    }
                    echo "<input type='submit' name='page' value='$i' class='$now_page'> ";
                    $now_page = null;
                }
                echo "&thinsp;…&nbsp;";
                if ($page == $max_pa) {
                    $now_page = "now-page";
                }
                echo "<input type='submit' name='page' value='$max_page' class='$now_page'> ";
                $now_page = null;
            }
        }
        echo "</form>";
    echo "</div>";
}
?>