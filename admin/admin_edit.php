<!-- 管理者情報編集画面 -->

<!-- ヘッダー表示 -->
<?php include("../common/header.php"); ?>

<!-- 管理者情報編集表示 -->
<div class="main-center">
    <body>
        <?php
        require_once '../common/functions.php';     // 関数呼出
        try {
            /* 指定の管理者情報呼出 */
            $dbh = db_open();   // DB接続
            $admin_id = $_GET["id"];  // 編集対象の管理者IDを受取
            $stmt = $dbh->prepare('SELECT admin_id, admin_name FROM admins WHERE admin_id = :admin_id');   // SQLでadminsテーブルからIDと名前を選択
            $stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
            $stmt->execute();   // 管理者選択実行
            $dbh = null;    // DB切断
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$rec) {    // 指定のIDがない場合
                echo "指定したデータはありません。" . "<br>";
                echo "<a href='admin_login.php'>ログイン画面へ</a>";
                echo "</div>";
                include("../common/footer.php");
                exit;
            }
        } catch (Exception $e) {     // DB接続が出来なたった時
            echo error_msg_admin();     // 管理者情報接続エラー表示
            exit;
        }
        ?>
        <!-- 指定の管理者情報編集表示 -->
        <h3>管理者情報編集</h3>
        <form action="admin_edit_check.php" method="post">
            <table>
                <tr>
                    <th><label for="admin_name">名前</label></th>
                    <td><input type="text" name="admin_name" value="<?= $rec['admin_name']; ?>"></td>
                </tr>
                <tr>
                    <th><label for="admin_pass">パスワード</label></th>
                    <td><input type="password" name="admin_pass"></td>
                </tr>
                <tr>
                    <th><label for="admin_cfm_pass">パスワード(確認用)</label></th>
                    <td><input type="password" name="admin_cfm_pass"></td>
                </tr>
            </table>
            <br>
            <input type="hidden" name="admin_id" value="<?= $admin_id ?>">
            <input type="submit" value="編集" class="OK-btn"><br>
            <input type="button" onclick="history.back()" value="戻る" class="return-btn">
        </form>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>