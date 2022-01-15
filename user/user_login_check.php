<!-- ログインチェック画面 -->

<!-- ヘッダー呼出 -->
<?php include("../common/header.php"); ?>

<div class="main-center">
    <body>
        <?php
        require_once '../common/functions.php';     // 関数呼出
        /* XSS対策 */
        $user_info = sanitize($_POST);
        $user_email = $user_info["user_email"];
        $user_pass = $user_info["user_pass"];
        $judge = true;

        /* DBから会員選択呼出 */
        $dbh = db_open();   // DB接続
        $stmt = $dbh->prepare("SELECT user_pass, user_id, user_name FROM users WHERE user_email = :user_email");
        $stmt->bindParam(':user_email', $user_email, PDO::PARAM_STR);
        $stmt->execute();   // SQL実行
        $dbh = null;    // DB切断
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        /* バリデーションチェック */
        if (empty($user_email) === true) {
            $error_msg = "・メールアドレスを入力してください。<br>";
            $judge = false;
        } else {
            $reg_str = "/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/";
            if (preg_match( $reg_str, $user_email) == false) {
                $error_msg .= "・正しいメールアドレスを入力してください。<br>";
                $judge = false;
            }
        }
        if (empty($user_pass) === true) {
            $error_msg .= "・パスワードを入力してください。<br>";
            $judge = false;
        } elseif (empty($user_email) === false) {
            if (password_verify($user_pass, $rec["user_pass"])) {
                session_start();
                $_SESSION["user_login"] = 1;
                $_SESSION["user_name"] = $rec["user_name"];
                $_SESSION["user_id"] = $rec["user_id"];
                /* ローカル環境時の画面遷移 */
                header("Location: ../ec_shop/shop_list.php");
                /* 本番環境時の画面遷移 */
                echo <<<EOF
                <script>
                    location.href='https://portfolio22.shop/ec_shop/shop_list.php';
                </script>
                EOF;
            } else {
                $error_msg .= "・メールアドレスもしくはパスワードが間違っています。<br>";
                $judge = false;
            }
        }

        /* エラーメッセージ表示*/
        if ($judge === false) {
            echo "<h3>ログインエラー</h3>";
            echo "<br><br>";
            echo $error_msg;
            echo "<br>";
            echo "<input type='button' onclick='history.back()' value='戻る' class='return-btn'>";
        }
        ?>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>