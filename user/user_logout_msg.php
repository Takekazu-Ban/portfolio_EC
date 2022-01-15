<!-- ログアウト確認画面 -->

<!-- ヘッダー表示 -->
<?php include("../common/header.php"); ?>

<div class="check-main-center">
    <body>
        <?php
        require_once '../common/functions.php';
        echo "<br>";
        echo "<h4>ログアウトすると、カート内の商品が失われますが、<br>よろしいでしょうか？</h4>";
        echo "<br><br>";
        $logout_btn = <<<EOD
        <input type='button' onclick="location.href='../user/user_logout.php'" value='ログアウト' class='OK-btn'>
        EOD;
        echo $logout_btn;
        echo "<input type='button' onclick='history.back()' value='キャンセル' class='return-btn'>";
        ?>
    </body>
</div>

<!-- フッター表示 -->
<?php include("../common/footer.php"); ?>