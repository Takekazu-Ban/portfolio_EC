<!-- 管理者削除確認画面 -->

<!-- ヘッダー表示 -->
<?php include("../common/header.php"); ?>

<!-- 管理者削除確認表示 -->
<div class="main-center">
    <body>
        <?php
        require_once '../common/functions.php';     // 関数呼出
        try {
            /* 指定の管理者情報呼出 */
            $admin_id = $_GET["id"];    // 削除対象の管理者IDを受取
            $dbh = db_open();   // DB接続
            $stmt = $dbh->prepare("SELECT admin_id, admin_name FROM admins WHERE admin_id = :admin_id");
            $stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
            $stmt->execute();   // 管理者情報の呼出実行
            $dbh = null;    // DB切断
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$rec) {    // 指定のIDがない場合
                echo "・指定したデータはありません。";
                echo "<br><br>";
                echo "<input type='button' onclick='history.back()' value='戻る' class='return-btn'>";
                echo "</div>";
                include("../common/footer.php");    // フッター表示
                exit;
            }
        } catch (Exception $e) {     // DB接続が出来なたった時
            echo error_msg_admin();     // 管理者情報接続エラー表示
            exit;
        }
        ?>

        <!-- 確認メッセージ表示 -->
        <h3>管理者削除</h3>
        <p>名前：<?= $rec["admin_name"]; ?></p>
        <br><br>
        <p>上記の管理者を削除しますか？</p>
        <br><br>
        <form action="admin_delete_done.php" method="post">
            <input type="hidden" name="admin_id" value="<?= $admin_id; ?>">
            <input type="submit" value="削除する" class="OK-btn"><br>
            <input type="button" onclick="history.back()" value="戻る" class="return-btn">
        </form>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>