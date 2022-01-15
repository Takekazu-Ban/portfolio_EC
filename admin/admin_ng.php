<!-- ログインせずに管理者画面のURLにいる場合 -->

<!-- ヘッダー表示 -->
<?php include("../common/header.php"); ?>

<div class="main-center">
    <body>
        <?php
        session_start();
        session_regenerate_id(true);
        if (isset($_SESSION["login"]) === false) {
            echo "ログインしていません。<br><br>";
            echo "<a href='admin_login.html'>ログイン画面へ</a>";
        }
        ?>
        <h4>管理者が選択されていません。</h4>
        <br><br>
        <a href="admin_list.php">管理者一覧に戻る</a>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>