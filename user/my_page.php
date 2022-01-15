<!-- 会員情報編集画面 -->

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
        <h3>お客様情報</h3><br>
        <div class="my-info">
            <font size="4"><strong><?= $rec['user_name']; ?></strong></font>様<br>
            <table>
                <tr>
                    <td><font size="2">メールアドレス</font></td>
                    <td><font size="2">：</font><font size="3"><?= $rec['user_email']; ?></font></td>
                </tr>
                <tr>
                    <td><font size="2">電話番号</font></td>
                    <td><font size="2">：</font><font size="3"><?= $rec['user_tel']; ?></font></td>
                </tr>
                <tr>
                    <td><font size="2">住所</font></td>
                    <td><font size="2">：</font><font size="3"><?= $rec['user_address']; ?></font></td>
                </tr>
            </table>
        </div>
        <br><br>

        <!-- お客様情報の編集ボタン -->
        <a href='../user/user_edit.php'>
            <div class="my-edit-btn">
                <div class="btn-title">
                    <h4><strong>お客様情報編集</strong></h4>
                </div>
                <div class="btn-subject">
                    <p>住所変更された場合、<br>メールアドレス・電話番号を変更された場合、<br>パスワードを変更したい場合は、<strong>こちらから</strong></p>
                </div>
            </div>
        </a>
        <br>
        <!-- 注文履歴の確認ボタン -->
        <a href='../user/buying_history.php'>
            <div class="my-edit-btn">
                <div class="btn-title">
                    <h4><strong>注文履歴確認</strong></h4>
                </div>
                <div class="btn-subject">
                    <p>ご注文商品を確認する場合、<br>入金状況・発送状況を確認する場合、<br>注文のキャンセルをされる場合は、<strong>こちらから</strong></p>
                </div>
            </div>
        </a>
        <br>
        <input type="button" onclick="history.back()" value="戻る">
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>