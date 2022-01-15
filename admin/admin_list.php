<!-- 管理者一覧画面 -->

<!-- ヘッダー表示 -->
<?php include("../common/header.php"); ?>

<!-- 管理者一覧表示 -->
<div class="main-center">
    <body>
        <?php
        require_once '../common/functions.php';     // 関数呼出
        try {
            /* DBから管理者を取得 */
            $dbh = db_open();   // DB接続
            $stmt = $dbh->prepare("SELECT admin_id, admin_name FROM admins");
            $stmt->execute();    // 管理者情報の呼出実行
            $dbh = null;    // DB切断

            echo "<h3>管理者一覧</h3><br>";     // ページタイトル
            echo "<form action='admin_branch.php' method='post'>";

                /* 一覧表の表示 */
                echo "<table class='table-header' border='2' width='100%'>";    // 一覧表ヘッダー
                    echo "<tr>";
                        echo "<th width='60%' align='center'>名前</th>";
                        echo "<th>操作</th>";
                    echo "</tr>";
                echo "</table>";
                echo "<div class='list-frame'>";
                    echo "<table class='table-col' border='1' width='100%'>";
                        /* DBから取得した管理者を一覧表示するループ */
                        while(true) {
                            $rec = $stmt->fetch(PDO::FETCH_ASSOC);  // 取出した全てのレコードを$recに格納
                            if ($rec === false) {   // 取得する管理者が居なくなった場合
                                break;  // ループを抜ける
                            }
                            echo "<tr height='40'>";
                                echo "<td width='60%'>";
                                    echo $rec['admin_name'];
                                    $admin_id = $rec['admin_id'];
                                echo "</td>";
                                echo "<td align='center'>";
                                    $admin_edit = <<<EOD
                                    <input type='button' onclick="location.href='../admin/admin_edit.php?id=$admin_id'" value='編集'>
                                    EOD;
                                    echo $admin_edit;
                                echo "</td>";
                                echo "<td align='center'>";
                                    $admin_delete = <<<EOD
                                    <input type='button' onclick="location.href='../admin/admin_delete.php?id=$admin_id'" value='削除'>
                                    EOD;
                                    echo $admin_delete;
                                echo "</td>";
                            echo "</tr>";
                        }
                    echo "</table>";
                echo "</div>";

                /* 管理者追加ボタン */
                echo "<input class='add-btn' type='submit' name='add' value='追加'>";
            echo "</form>";
        } catch(Exception $e) {     // DB接続が出来なたった時
            echo error_msg_admin();     // 管理者情報接続エラー表示
            exit;
        }
        ?>
            <a href="../admin/admin_top.php">管理者TOPページへ</a>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>