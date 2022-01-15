<!-- 管理者編集確認画面 -->

<!-- ヘッダー表示 -->
<?php include("../common/header.php"); ?>

<div class="check-main-center">
    <body>
        <?php
        require_once '../common/functions.php';     // 関数呼出
        /* XSS対策 */
        $admin_info = sanitize($_POST);
        $admin_id = $admin_info["admin_id"];
        $admin_name = $admin_info["admin_name"];
        $admin_pass = $admin_info["admin_pass"];
        $admin_cfm_pass = $admin_info["admin_cfm_pass"];
        $judge = true;   // 判定の初期化

        /* 編集情報チェック */
        require_once '../common/admin_info_check.php';

        /* 判定によるメッセージ条件分岐 */
        if ($judge === false) {
            echo "<h3>ログインエラー</h3>";
            echo "<br><br>";
            echo $error_msg;    // エラー項目を表示
            echo "<br>";
            echo "<input type='button' onclick='history.back()' value='戻る' class='return-btn'>";
        } else {
            echo "管理者名：";
            echo $admin_name;
            echo "<br><br>";
            echo "上記の管理者を編集しますか？<br><br>";
            echo "<form action='admin_edit_done.php' method='post'>";
            echo "<input type='hidden' name='admin_id' value='".$admin_id."'>";
            echo "<input type='hidden' name='admin_name' value='".$admin_name."'>";
            echo "<input type='hidden' name='admin_pass' value='".$admin_pass."'>";
            echo "<input type='submit' value='OK' class='OK-btn'><br>";
            echo "<input type='button' onclick='history.back()' value='キャンセル' class='return-btn'>";
            echo "</form>";
        }
        ?>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>