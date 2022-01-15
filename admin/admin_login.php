<!-- 管理者ログイン画面 -->

<!-- ヘッダー表示 -->
<?php include("../common/header.php"); ?>

<div class="main-center">
    <body>
        <h3>管理者ログイン</h3>
        <br><br>
        <form action="admin_login_check.php" method="post">
            <table>
                <tr>
                    <th><label for="admin_name">名前</label></th>
                    <td><input type="text" name="admin_name"></td>
                </tr>
                <tr>
                    <th><label for="admin_pass">パスワード&thinsp;</label></th>
                    <td><input type="password" name="admin_pass"></td>
                </tr>
            </table>
            <br>
            <input type="submit" value="ログイン" class="OK-btn"><br>
            <br><br>
            <p>会員の方はこちら、<a href="../user/user_login.php">会員ログインへ</a></p>
        </form>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>