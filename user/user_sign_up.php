<!-- 新規会員登録画面 -->

<!-- ヘッダー呼出 -->
<?php include("../common/header.php"); ?>

<!-- 登録情報入力部分 -->
<div class="main-center">
    <body>
        <h3>新規会員登録</h3>
        <br><br>
        <form action="user_sign_up_check.php" method="post">
            <table>
                <tr>
                    <th><label for="user_name">名前</label></th>
                    <td><input type="text" name="user_name"></td>
                </tr>
                <tr>
                    <th><label for="user_email">メールアドレス</label></th>
                    <td><input type="text" name="user_email"></td>
                </tr>
                <tr>
                    <th><label for="user_tel">電話番号</label></th>
                    <td><input type="text" name="user_tel"></td>
                <tr>
                <tr>
                    <th><label for="user_address">住所</label></th>
                    <td><input type="text" name="user_address"></td>
                </tr>
                <tr>
                    <th><label for="user_pass">パスワード</label></th>
                    <td><input type="password" name="user_pass"></td>
                </tr>
                <tr>
                    <th><label for="user_cfm_pass">パスワード(確認用)&thinsp;</label></th>
                    <td><input type="password" name="user_cfm_pass"></td>
                </tr>
            </table>
            <br>
            <input type="submit" value="新規登録" class="OK-btn"><br>
            <input type="button" onclick="history.back()" value="戻る" class="return-btn">
        </form>
        <br><br>
        <p>会員登録がお済みの方はこちら、<a href="./user_login.php">会員ログインへ</a></p>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>