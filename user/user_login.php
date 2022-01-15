<!-- 会員ログイン画面 -->

<!-- ヘッダー呼出 -->
<?php include("../common/header.php"); ?>

<div class="main-center">
    <body>
        <h3>ログイン</h3>
        <br><br>
        <form action="user_login_check.php" method="post">
            <table>
                <tr>
                    <th><label for="user_email">メールアドレス&thinsp;</label></th>
                    <td><input type="text" name="user_email"></td>
                </tr>
                <tr>
                    <th><label for="user_pass">パスワード</label></th>
                    <td><input type="password" name="user_pass"></td>
                </tr>
            </table>
            <br>
            <input type="submit" value="ログイン" class="OK-btn"><br>
            <br><br>
            <p>会員登録がまだの方はこちら、<a href="./user_sign_up.php">会員登録へ</a></p>
            <p>管理者の方はこちら、<a href="../admin/admin_login.php">管理者ログインへ</a></p>
            <br>
            <a href="../ec_shop/shop_list.php">ログインせずに入店する</a>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>

