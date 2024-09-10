<?php
require_once 'vendor/autoload.php'; // Composerのオートローダーを読み込む
require_once 'setting.php'; // 設定情報を読み込む

session_start();

$client = new Google_Client();
$client->setClientId(GOOGLE_CLIENT_ID);
$client->setClientSecret(GOOGLE_CLIENT_SECRET);
$client->setRedirectUri(GOOGLE_REDIRECT_URI);
$client->addScope('email');
$client->addScope('profile');

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    $oauth2 = new Google_Service_Oauth2($client);
    $userInfo = $oauth2->userinfo->get();

    // ユーザー情報をセッションに保存
    $_SESSION['user'] = $userInfo;
    $_SESSION['loggedin'] = true;

    // ログイン後のページにリダイレクト
    header('Location: home.php');
    exit;
} else {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
    exit;
}
?>
