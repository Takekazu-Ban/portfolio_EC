<!-- 会員情報チェック -->

<?php
/* 名前をチェック */
if (empty($user_name) === true) {
    $error_msg = "・名前を入力してください。<br>";
    $judge = false;
} else {
    if (mb_strlen($user_name) > 15) {
        $error_msg = "・名前は、15文字以内で入力してください。<br>";
        $judge = false;
    }
}
/* メールアドレスをチェック */
if (empty($user_email) === true) {
    $error_msg .= "・メールアドレスを入力してください。<br>";
    $judge = false;
} else {
    $reg_str = "/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/";
    if (preg_match( $reg_str, $user_email) == false) {
        $error_msg .= "・正しいメールアドレスを入力してください。<br>";
        $judge = false;
    }
    if (strlen($user_email) > 50) {
        $error_msg .= "・メールアドレスは、半角数字で50文字以内で入力してください。<br>";
        $judge = false;
    }
}
/* 住所をチェック */
if (empty($user_address) === true) {
    $error_msg .= "・住所を入力してください。<br>";
    $judge = false;
} elseif (mb_strlen($user_address) > 50) {
    $error_msg .= "・住所は、50文字以内で入力してください。<br>";
    $judge = false;
}
/* 電話番号をチェック */
if (empty($user_tel) === true) {
    $error_msg .= "・電話番号を入力してください。<br>";
    $judge = false;
} elseif ((preg_match("/\A\d{2,5}-?\d{2,5}-?\d{4,5}\z/", $user_tel) === 0) || (strlen($user_tel) < 10) || (strlen($user_tel) > 11)) {
    $error_msg .= "・半角数字で正しい電話番号を入力してください。<br>";
    $judge = false;
}
/* パスワードをチェック */
if (empty($user_pass) === true) {
    $error_msg .= "・パスワードを入力してください。<br>";
    $judge = false;
} elseif ((strlen($user_pass) < 4) || (strlen($user_pass) > 20) || (preg_match("/^[a-zA-Z0-9]+$/", $user_pass) == false)) {
    $error_msg .= "・パスワードは、半角英数4文字以上20文字以内で入力してください。<br>";
    $judge = false;
} elseif ($user_pass != $user_cfm_pass) {
    $error_msg .= "・パスワードが一致しません。<br>";
    $judge = false;
}
