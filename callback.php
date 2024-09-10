<?php
require_once 'vendor/autoload.php'; // Composerのオートローダーを読み込む
require_once 'setting.php';

session_start();

$client = new Google_Client();
$client->setClientId(GOOGLE_CLIENT_ID);
$client->setClientSecret(GOOGLE_CLIENT_SECRET);
$client->setRedirectUri(GOOGLE_REDIRECT_URI);

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    // ユーザー情報の取得
    $oauth2 = new Google_Service_Oauth2($client);
    $userInfo = $oauth2->userinfo->get();

    // ユーザー情報をセッションに保存
    $_SESSION['user'] = $userInfo;
    $_SESSION['loggedin'] = true;  // ログイン状態を示すフラグを設定

    // ログイン後のページにリダイレクト（home.phpに変更）
    header('Location: home.php');
    exit;
} else {
    header('Location: login.php');
    exit;
}
?>
