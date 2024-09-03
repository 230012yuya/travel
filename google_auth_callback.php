<?php
require_once 'setting.php';

// クライアントIDとクライアントシークレット
$client_id = GOOGLE_CLIENT_ID;
$client_secret = GOOGLE_CLIENT_SECRET;
$redirect_uri = GOOGLE_REDIRECT_URI;

// 認証コードがリクエストされたか確認
if (isset($_GET['code'])) {
    session_start();

    // CSRF対策の状態を確認
    if (!isset($_SESSION['google_auth_state']) || $_GET['state'] !== $_SESSION['google_auth_state']) {
        die('State does not match. Possible CSRF attack.');
    }

    // 認証コードを取得
    $auth_code = $_GET['code'];

    // アクセストークンを取得するためのPOSTリクエストを作成
    $token_url = 'https://oauth2.googleapis.com/token';
    $token_request_data = array(
        'code' => $auth_code,
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri' => $redirect_uri,
        'grant_type' => 'authorization_code'
    );

    // cURLを使用してトークンをリクエスト
    $curl = curl_init($token_url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($token_request_data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    // レスポンスからアクセストークンを取得
    $token_data = json_decode($response, true);
    if (isset($token_data['access_token'])) {
        // アクセストークンを使用してユーザーの情報を取得するAPIリクエストを作成
        $userinfo_url = 'https://www.googleapis.com/oauth2/v2/userinfo';
        $userinfo_request_headers = array(
            'Authorization: Bearer ' . $token_data['access_token']
        );

        // cURLを使用してユーザー情報を取得
        $curl = curl_init($userinfo_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $userinfo_request_headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $userinfo_response = curl_exec($curl);
        curl_close($curl);

        // ユーザー情報を表示
        $userinfo = json_decode($userinfo_response, true);
        if (isset($userinfo['email'])) {
            echo '認証成功！ メールアドレス: ' . $userinfo['email'];
        } else {
            echo 'ユーザー情報の取得に失敗しました。';
        }
    } else {
        echo 'トークンの取得に失敗しました。';
    }
} else {
    echo '認証コードがありません。';
}
?>
