<!-- 商品追加チェック・確認画面 -->

<!-- ヘッダー表示 -->
<?php include("../common/header.php"); ?>
<!-- 関数呼出 -->
<?php require_once '../common/functions.php'; ?>

<div class="main-center">
    <body>
        <?php
        try {
            /* XSS対策 */
            $user_info = sanitize($_POST);
            $user_name = $user_info["user_name"];
            $user_email = $user_info["user_email"];
            $user_tel = $user_info["user_tel"];
            $user_address = $user_info["user_address"];
            $user_pass = $user_info["user_pass"];

            $user_pass = password_hash($user_pass, PASSWORD_DEFAULT);   // パスワードハッシュ化
            $dbh = db_open();   // DB接続

            /* 既に登録済みの会員かチェック */
            $stmt = $dbh->prepare("SELECT user_email, user_pass FROM users");
            $stmt->execute();
            while(true) {
                $rec = $stmt -> fetch(PDO::FETCH_ASSOC);
                if(empty($rec) === true) {
                    break;
                }
                $email[] = $rec["user_email"];
                $pass[] = $rec["user_pass"];
            }
            if (empty($email) === true) {
                $email[] = 1;
                $pass[] = 1;
            }
                if (in_array($user_email, $email) === true) {
                echo "すでに登録されている会員です。<br><br>";
                echo "<a href='../ec_shop/shop_list.php'>トップページへ戻る</a>";
                $dbh = null;    // DB切断
            } else {
                $stmt = $dbh->prepare("INSERT INTO users (user_name, user_email, user_tel, user_address, user_pass) VALUES(:user_name, :user_email, :user_tel, :user_address, :user_pass)");
                $stmt->bindParam(":user_name", $user_name, PDO::PARAM_STR);
                $stmt->bindParam(":user_email", $user_email, PDO::PARAM_STR);
                $stmt->bindParam(":user_tel", $user_tel, PDO::PARAM_STR);
                $stmt->bindParam(":user_address", $user_address, PDO::PARAM_STR);
                $stmt->bindParam(":user_pass", $user_pass, PDO::PARAM_STR);
                $stmt->execute();
                $dbh = null;    // DB切断
                /* ローカル環境時の画面遷移 */
                header("Location: ../ec_shop/shop_list.php");
                /* 本番環境時の画面遷移 */
                echo <<<EOF
                <script>
                    location.href='https://portfolio22.shop/ec_shop/shop_list.php';
                </script>
                EOF;
            }
        } catch(Exception $e) {     // DB接続が出来なたった時
            echo error_msg();     // 接続エラー表示
            exit;
        }
        ?>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>