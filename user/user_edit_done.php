<!-- 会員情報編集実行 -->

<!-- ヘッダー呼出 -->
<?php include("../common/header.php"); ?>
<!-- 関数呼出 -->
<?php require_once '../common/functions.php'; ?>

<div class="main-center">
    <body>
        <?php
        try {
            /* XSS 対策*/
            $user_info = sanitize($_POST);
            $user_id = $user_info["user_id"];
            $user_name = $user_info["user_name"];
            $user_email = $user_info["user_email"];
            $user_tel = $user_info["user_tel"];
            $user_address = $user_info["user_address"];
            $user_pass = $user_info["user_pass"];
            $user_pass = password_hash($user_pass, PASSWORD_DEFAULT);   // パスワードハッシュ化

            $dbh = db_open();   // DB接続
            $stmt = $dbh->prepare("UPDATE users SET user_name = :user_name, user_email = :user_email, user_tel = :user_tel, user_address = :user_address, user_pass = :user_pass WHERE user_id = :user_id");
            $stmt->bindParam(":user_name", $user_name, PDO::PARAM_STR);
            $stmt->bindParam(":user_email", $user_email, PDO::PARAM_STR);
            $stmt->bindParam(":user_tel", $user_tel, PDO::PARAM_STR);
            $stmt->bindParam(":user_address", $user_address, PDO::PARAM_STR);
            $stmt->bindParam(":user_pass", $user_pass, PDO::PARAM_STR);
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();   // SQL実行
            $dbh = null;    // DB切断

            $_SESSION["user_name"] = $user_name;
            /* ローカル環境時の画面遷移 */
            header("Location: ../user/my_page.php");
            /* 本番環境時の画面遷移 */
            echo <<<EOF
            <script>
                location.href='https://portfolio22.shop/user/my_page.php';
            </script>
            EOF;
        } catch(Exception $e) {     // DB接続が出来なたった時
            echo error_msg();     // 接続エラー表示
            exit;
        }
        ?>
    </body>
</div>

<?php include("../common/footer.php"); ?>