<!-- 管理者情報接続エラー画面表示 -->

<?php
require_once '../common/functions.php';     // 関数呼出
include("../common/header.php");    // ヘッダー表示
echo "<div class='main-center'>";
    echo "<body>";
        echo error_msg_admin();     // 管理者情報接続エラー表示
    echo "</body>";
echo "</div>";
include("../common/footer.php");    // フッター表示
exit;