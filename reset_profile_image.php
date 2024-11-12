<?php
session_start();
require 'db_connection.php'; // 必要に応じてデータベース接続をロード

$userId = $_SESSION['user_id']; // ログイン中のユーザーID

// ユーザー情報を取得
$query = "SELECT profile_image FROM users WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// プロフィール画像を削除
if ($user && $user['profile_image'] && file_exists("uploads/" . $user['profile_image'])) {
    unlink("uploads/" . $user['profile_image']);
}

// デフォルト画像に更新
$query = "UPDATE users SET profile_image = NULL WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$userId]);

echo json_encode(['success' => true]);
?>
