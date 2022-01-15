<!-- 会員情報編集チェック・確認 -->

<!-- ヘッダー呼出 -->
<?php include("../common/header.php"); ?>

<div class="check-main-center">
    <body>
        <?php
        require_once '../common/functions.php';     // 関数呼出
        /* XSS対策 */
        $user_info = sanitize($_POST);
        $user_id = $user_info["user_id"];
        $user_name = $user_info["user_name"];
        $user_email = $user_info["user_email"];
        $user_tel = $user_info["user_tel"];
        $user_address = $user_info["user_address"];
        $user_pass = $user_info["user_pass"];
        $user_cfm_pass = $user_info["user_cfm_pass"];
        $judge = true;

        /* 会員情報チェック */
        require_once '../common/user_info_check.php';

        if ($judge === false) {
            echo "<h3>ログインエラー</h3>";
            echo "<br><br>";
            echo $judge;
            echo $error_msg;
            echo "<br>";
            echo "<input type='button' onclick='history.back()' value='戻る' class='return-btn'>";
        } else {
            echo "名前　　　　　：";
            echo $user_name;
            echo "<br>";
            echo "メールアドレス：";
            echo $user_email;
            echo "<br>";
            echo "住所　　　　　：";
            echo $user_address;
            echo "<br>";
            echo "電話番号　　　：";
            echo $user_tel;
            echo "<br><br>";
            echo "上記の会員情報を編集しますか？<br><br>";
            echo "<form action='user_edit_done.php' method='post'>";
            echo "<input type='hidden' name='user_id' value='".$user_id."'>";
            echo "<input type='hidden' name='user_name' value='".$user_name."'>";
            echo "<input type='hidden' name='user_email' value='".$user_email."'>";
            echo "<input type='hidden' name='user_address' value='".$user_address."'>";
            echo "<input type='hidden' name='user_tel' value='".$user_tel."'>";
            echo "<input type='hidden' name='user_pass' value='".$user_pass."'>";
            echo "<input type='submit' value='OK' class='OK-btn'><br>";
            echo "<input type='button' onclick='history.back()' value='キャンセル' class='return-btn'>";
            echo "</form>";
        }
        ?>
    </body>
</div>
<?php include("../common/footer.php"); ?>