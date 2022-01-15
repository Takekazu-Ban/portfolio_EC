<!-- 管理者追加画面 -->

<!-- ヘッダー表示 -->
<?php include("../common/header.php"); ?>

<!-- 管理者追加項目 -->
<div class="main-center">
    <body>
        <h3>新規管理者追加</h3>
        <br><br>
        <form action="admin_add_check.php" method="post">
            <table>
                <tr>
                    <th><label for="admin_name">名前</label></th>
                    <td><input type="text" name="admin_name"></td>
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
            <input type="submit" value="管理者追加" class="OK-btn"><br>
            <input type="button" onclick="history.back()" value="戻る" class="return-btn">
        </form>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>