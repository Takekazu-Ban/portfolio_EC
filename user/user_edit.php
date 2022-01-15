<!-- 会員情報修正画面 -->

<!-- ヘッダー呼出 -->
<?php include("../common/header.php"); ?>

<div class="main-center">
    <body>
        <?php
        require_once '../common/functions.php';     // 関数呼出
        try {
            $dbh = db_open();   // データベース接続
            $user_id = $_SESSION["user_id"];  // ID取得
            $stmt = $dbh->prepare('SELECT * FROM users WHERE user_id = :user_id');
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();   // SQL実行
            $dbh = null;    // DB切断
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {     // DB接続が出来なたった時
            echo error_msg();     // 接続エラー表示
            exit;
        }
        ?>

        <!-- 修正入力部分 -->
        <h3>会員情報修正</h3>
        <br>
        <form action="user_edit_check.php" method="post">
            <table>
                <tr>
                    <th><label for="user_name">名前</label></th>
                    <td><input type="text" name="user_name" value="<?= $rec['user_name']; ?>"></td>
                </tr>
                <tr>
                    <th><label for="user_email">メールアドレス</label></th>
                    <td><input type="text" name="user_email" value="<?= $rec['user_email']; ?>"></td>
                </tr>
                <tr>
                    <th><label for="user_tel">電話番号</label></th>
                    <td><input type="text" name="user_tel" value="<?= $rec['user_tel']; ?>"></td>
                <tr>
                <tr>
                    <th><label for="user_address">住所</label></th>
                    <td><input type="text" name="user_address" value="<?= $rec['user_address']; ?>"></td>
                </tr>
                <tr>
                    <th><label for="user_pass">パスワード</label></th>
                    <td><input type="password" name="user_pass"></td>
                </tr>
                <tr>
                    <th><label for="user_cfm_pass">パスワード(確認用)</label></th>
                    <td><input type="password" name="user_cfm_pass"></td>
                </tr>
            </table>
            <input type='hidden' name='user_id' value='<?= $rec['user_id']; ?>'>
            <br>
            <input type="submit" value="更新" class="OK-btn"><br>
            <input type="button" onclick="history.back()" value="戻る" class="return-btn">
        </form>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>