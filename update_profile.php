<?php
session_start();

// セッションからユーザー情報を取得
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

$name = $_SESSION['name'];
$profile_image = $_SESSION['profile_image'];

// データベース接続
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "travel";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("接続失敗: " . $conn->connect_error);
}

// ユーザーのプロフィール情報をデータベースから取得
$sql = "SELECT * FROM user WHERE name = '$name'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// フォーム送信時の処理
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bio = $_POST['bio'];
    $favorite_plans = $_POST['favorite_plans'];

    // 画像アップロード処理
    if ($_FILES['profile_image']['name'] != "") {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);
        $profile_image = basename($_FILES["profile_image"]["name"]);
    }

    // データベース更新
    $update_sql = "UPDATE user SET bio = '$bio', favorite_plans = '$favorite_plans', profile_image = '$profile_image' WHERE name = '$name'";
    if ($conn->query($update_sql) === TRUE) {
        header("Location: profile.php"); // 更新後にプロフィールページにリダイレクト
        exit();
    } else {
        echo "エラー: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール編集</title>
</head>
<body>
    <h1>プロフィール編集</h1>
    <form action="update_profile.php" method="POST" enctype="multipart/form-data">
        <label for="bio">自己紹介:</label><br>
        <textarea name="bio" id="bio" rows="4" cols="30"><?php echo htmlspecialchars($user['bio']); ?></textarea><br>

        <label for="favorite_plans">お気に入りの旅行プラン (IDで入力、カンマ区切り):</label><br>
        <input type="text" name="favorite_plans" id="favorite_plans" value="<?php echo htmlspecialchars($user['favorite_plans']); ?>" placeholder="例: 1,2,3"><br>

        <label for="profile_image">プロフィール画像:</label><br>
        <input type="file" name="profile_image" id="profile_image"><br>

        <input type="submit" value="更新する">
    </form>
</body>
</html>

<?php
$conn->close();
?>
