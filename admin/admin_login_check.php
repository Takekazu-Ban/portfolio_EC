<!-- 管理者ログインチェック -->

<!-- ヘッダー表示 -->
<?php include("../common/header.php"); ?>

<div class="main-center">
    <body>
        <?php
        try {
            require_once '../common/functions.php';     // 関数呼出

            /* XSS対策 */
            $admin_info = sanitize($_POST);
            $admin_name = $admin_info["admin_name"];
            $admin_pass = $admin_info["admin_pass"];
            $judge = true;   // 判定初期化

            $dbh = db_open();   // DB接続
            $stmt = $dbh->prepare("SELECT admin_id, admin_pass FROM admins WHERE admin_name=:admin_name");
            $stmt->bindParam(":admin_name", $admin_name, PDO::PARAM_STR);
            $stmt->execute();   // 管理者選択実行
            $dbh = null;    // DB切断
            $rec =$stmt->fetch(PDO::FETCH_ASSOC);

            /* バリデーションチェック */
            if (empty($admin_name) === true) {
                $error_msg = "・名前を入力してください。<br>";
                $judge = false;
            }
            if (empty($admin_pass) === true) {
                $error_msg .= "・パスワードを入力してください。<br>";
                $judge = false;
            } elseif (empty($admin_name) === false) {
                if (password_verify($admin_pass, $rec["admin_pass"])) {
                    session_start();
                    $_SESSION["login"] = 1;
                    $_SESSION["admin_id"] = $rec["admin_id"];
                    $_SESSION["admin_name"] = $admin_name;
                    /* ローカル環境時の画面遷移 */
                    header("Location:admin_top.php");
                    /* 本番環境時の画面遷移 */
                    echo <<<EOF
                    <script>
                        location.href='https://portfolio22.shop/admin/admin_top.php';
                    </script>
                    EOF;
                } else {
                    $error_msg .= "・名前もしくはパスワードが間違っています。<br>";
                    $judge = false;
                }
            }

            /* エラーメッセージ表示*/
            if ($judge == false) {
                echo "<h3>ログインエラー</h3>";
                echo "<br><br>";
                echo $error_msg. "<br>";
                echo "<a href='../admin/admin_login.php'>戻る</a>";
            }
        } catch(Exception $e) {     // DB接続が出来なたった時
            echo error_msg_admin();     // 管理者情報接続エラー表示
            exit;
        }
        ?>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>