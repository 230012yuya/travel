<?php
require_once 'setting.php';

// セッションを開始して認証コードを保存
session_start();
$_SESSION['google_auth_state'] = bin2hex(random_bytes(10));

// 認証用URLを生成
$auth_url = "https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=" . GOOGLE_CLIENT_ID .
    "&redirect_uri=" . urlencode(GOOGLE_REDIRECT_URI) .
    "&state=" . $_SESSION['google_auth_state'] .
    "&scope=openid%20email%20profile";

// ユーザーをGoogleの認証ページにリダイレクト
header("Location: $auth_url");
exit;
?>
