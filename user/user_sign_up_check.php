<!-- 新規会員登録チェック・確認 -->

<!-- ヘッダー表示 -->
<?php include("../common/header.php"); ?>
<!-- 関数呼出 -->
<?php require_once '../common/functions.php'; ?>

<div class="check-main-center">
    <body>
        <?php
        /* XSS対策 */
        $user_info = sanitize($_POST);
        $user_name = $user_info["user_name"];
        $user_email = $user_info["user_email"];
        $user_tel = $user_info["user_tel"];
        $user_address = $user_info["user_address"];
        $user_pass = $user_info["user_pass"];
        $user_cfm_pass = $user_info["user_cfm_pass"];
        $judge = true;   // 判定を初期化

        /* 会員情報チェック */
        require_once '../common/user_info_check.php';

        /* 判定によるメッセージ条件分岐 */
        if ($judge === false) {
            echo "<h3>ログインエラー</h3>";
            echo "<br><br>";
            echo $error_msg;
            echo "<br>";
            echo "<input type='button' onclick='history.back()' value='戻る' class='return-btn'>";
        } else {
            echo "<h5>以下の内容で新規登録しますか？</h5><br><br>";
            echo "<table>";
            echo "<tr>";
            echo "<th>名前</th>";
            echo "<td>$user_name<td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>メールアドレス</th>";
            echo "<td>$user_email<td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>住所</th>";
            echo "<td>$user_address<td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>電話番号</th>";
            echo "<td>$user_tel<td>";
            echo "</tr>";
            echo "</table><br>";
            echo "<form action='user_sign_up_done.php' method='post'>";
            echo "<input type='hidden' name='user_name' value='".$user_name."'>";
            echo "<input type='hidden' name='user_email' value='".$user_email."'>";
            echo "<input type='hidden' name='user_address' value='".$user_address."'>";
            echo "<input type='hidden' name='user_tel' value='".$user_tel."'>";
            echo "<input type='hidden' name='user_pass' value='".$user_pass."'>";
            echo "<input type='submit' value='OK' class='OK-btn'><br>";
            echo "<input type='button' onclick='history.back()' value='キャンセル' class='return-btn'>";
        }
        ?>
        <br><br>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>