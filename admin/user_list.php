<!-- 会員一覧画面 -->

<!-- ヘッダー呼出 -->
<?php include("../common/header.php"); ?>

<div class="main-center">
    <body>
        <?php
        require_once '../common/functions.php';
        try {
            /* DBから会員を取得 */
            $dbh = db_open();   // DB接続
            $stmt = $dbh->prepare("SELECT user_id, user_name FROM users");   // SQLでadminsテーブルからIDと名前を選択
            $stmt->execute();    // SQL実行
            $dbh = null;    // DB切断

            echo "<h3>会員一覧</h3><br>";

            /* 会員一覧表の表示 */
            echo "<table class='table-header' border='2' width='100%'>";
                echo "<tr>";
                echo "<th width='10%' align='center'>ID</th>";
                echo "<th width='60%' align='center'>名前</th>";
                echo "<th width='30%' align='center'>注文履歴</th>";
                echo "</tr>";
            echo "</table>";
            echo "<div class='list-frame'>";
                echo "<table class='table-col' border='1' width='100%'>";
                    /* DBから取得した会員を一覧表示するループ */
                    while(true) {
                        $rec = $stmt->fetch(PDO::FETCH_ASSOC);  // 取出した全てのレコードを$recに格納
                        if ($rec === false) {   // 取得する管理者が居なくなった場合
                            break;  // ループを抜ける
                        }
                        echo "<tr height='40'>";
                            echo "<td width='10%' align='center'>";
                                echo $rec['user_id'];
                                $user_id = $rec['user_id'];
                            echo "</td>";
                            echo "<td width='60%'>";
                                echo $rec['user_name'];
                            echo "</td>";
                            echo "<td width='30%' align='center'>";
                                $order_list = <<<EOD
                                <input type='button' onclick="location.href='../admin/user_order_list.php?id=$user_id'" value='注文一覧'>
                                EOD;
                                echo $order_list;
                            echo "</td>";
                        echo "</tr>";
                    }
                echo "</table>";
            echo "</div>";

        } catch(Exception $e) {     // DB接続が出来なたった時
            echo error_msg_admin();     // 管理者情報接続エラー表示
            exit;
        }
        ?>
            <br>
            <a href="../admin/order_list.php">注文一覧ページへ</a>
            <br>
            <a href="../admin/admin_top.php">管理者TOPページへ</a>
    </body>
</div>

<!-- フッター呼出 -->
<?php include("../common/footer.php"); ?>