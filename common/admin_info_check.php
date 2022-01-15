<!-- 追加の管理者情報チェック機能 -->

<?php
/* 名前のチェック */
if (empty($admin_name) === true) {
    $error_msg = "・名前を入力してください。<br>";
    $judge = false;
} else {
    if (mb_strlen($admin_name) > 15) {
        $error_msg = "・名前は、15文字以内で入力してください。<br>";
        $judge = false;
    }
}
/* パスワードのチェック */
if (empty($admin_pass) === true) {
    $error_msg .= "・パスワードを入力してください。<br>";
    $judge = false;
} elseif ((strlen($admin_pass) < 4) || (strlen($admin_pass) > 20) || (preg_match("/^[a-zA-Z0-9]+$/", $admin_pass) == false)) {
    $error_msg .= "・パスワードは、半角英数4文字以上20文字以内で入力してください。<br>";
    $judge = false;
} elseif ($admin_pass != $admin_cfm_pass) {
    $error_msg .= "・パスワードが一致しません。<br>";
    $judge = false;
}
