<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// セッションから user_id を取得
$user_id = $_SESSION['user_id'];

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "travel";

// データベース接続
$conn = new mysqli($servername, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("接続失敗: " . $conn->connect_error);
}

// ユーザー情報を取得
$sql = "SELECT * FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$profile_image = $user['profile_image'];

// デフォルト画像のパス
$default_image = "kkrn_icon_user_6.png";

// POSTリクエスト処理
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // **画像リセットの処理**
    if (isset($_POST['reset_image'])) {
        $profile_image = $default_image;

        // データベースを更新してデフォルト画像にリセット
        $reset_sql = "UPDATE user SET profile_image = ? WHERE id = ?";
        $reset_stmt = $conn->prepare($reset_sql);
        $reset_stmt->bind_param("si", $profile_image, $user_id);

        if ($reset_stmt->execute()) {
            header("Location: profile.php");
            exit; // 成功後リダイレクト
        } else {
            echo "画像リセットエラー: " . $conn->error;
        }
    }

    // **プロフィール情報の更新**
    $bio = $_POST['bio'] ?? '';
    $favorite_plans = $_POST['favorite_plans'] ?? '';

    // プロフィール画像の処理
    if (!empty($_FILES['profile_image']['name'])) {
        $target_dir = "uploads/";
        $file_name = uniqid() . "_" . basename($_FILES["profile_image"]["name"]);
        $target_file = $target_dir . $file_name;

        // ファイル形式の検証
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (in_array($file_type, $allowed_types)) {
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                $profile_image = $file_name;
            } else {
                echo "画像アップロードに失敗しました。";
            }
        } else {
            echo "許可されていないファイル形式です。";
        }
    }

        // ユーザー情報を更新
    $update_sql = "UPDATE user SET bio = ?, favorite_plans = ?, profile_image = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssi", $bio, $favorite_plans, $profile_image, $user_id);

    if ($update_stmt->execute()) {
        header("Location: profile.php");
        exit;
    } else {
        echo "プロフィール更新エラー: " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィールページ</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #ff9a9e, #fad0c4, #fbc2eb, #a18cd1, #84fab0, #8fd3f4);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .navbar {
            overflow: hidden;
            background-color: rgba(50, 50, 70, 0.9);
            padding: 0 15px;
            font-size: 18px;
            width: 100%;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;
        }

        .navbar a:hover {
            background-color: #ffb6b9;
            color: #fff;
            transform: scale(1.05);
        }

        .title {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 50px;
            font-weight: bold;
            background: linear-gradient(45deg, #ff6b6b, #ffd93d, #6bc9ff);
            -webkit-background-clip: text;
            color: transparent;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }

        .title:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .profile-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 500px;
            margin-top: 50px;
        }

        .profile-container img {
            border-radius: 50%;
            width: 200px;
            height: 200px;
            object-fit: cover;
            border: 3px solid #ffb6b9;
        }

        .section-title {
            font-size: 22px;
            font-weight: bold;
            color: #ff6b6b;
            margin-top: 20px;
        }

        .section-content {
            font-size: 18px;
            color: #333;
            font-weight: bold;
            margin-bottom: 15px;
        }

        p {
            margin: 10px 0;
        }

        a.button {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #ff6b6b;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        a.button:hover {
            background-color: #ffd93d;
            transform: scale(1.05);
        }

        .edit-form {
            display: none;
            margin-top: 20px;
        }

        .edit-button {
            background-color: #ffd93d;
            padding: 10px 20px;
            font-weight: bold;
            margin-top: 20px;
            border: none;
            border-radius: 15px;
            cursor: pointer;
        }

        .edit-button:hover {
            background-color: #ff6b6b;
            color: white;
        }

        textarea, input[type="file"], input[type="submit"], .reset-button {
            margin-top: 10px;
            width: 100%;
            padding: 10px;
            border-radius: 15px;
            border: 1px solid #ccc;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease;
        }

        textarea:focus, input[type="file"]:focus, input[type="submit"]:hover, .reset-button:hover {
            border-color: #ff6b6b;
        }

        input[type="submit"] {
            background-color: #ff6b6b;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #ffd93d;
        }

        .reset-button {
            background-color: #84fab0;
            color: white;
            font-weight: bold;
            border: none;
            margin-top: 10px;
        }

        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="navbar" id="myNavbar">
        <a href="home.php">ホーム</a>
        <a href="create_plan.php">旅行プラン作成</a>
        <a href="display.php">旅行プラン表示</a>
        <a href="profile.php">プロフィール</a>
        <a href="view_plans.php">過去の旅行プラン</a>
        <a href="javascript:void(0);" onclick="confirmLogout()">ログアウト</a>
    </div>

    <div class="title">Traveeel</div>

    <div class="profile-container">
        <h1><?php echo htmlspecialchars($user['name']); ?>さんのプロフィール</h1>
        <img id="profileImage" src="uploads/<?php echo htmlspecialchars($user['profile_image'] ?: 'image1.png'); ?>" alt="プロフィール画像">
        <div class="section-title">自己紹介</div>
        <p class="section-content"><?php echo htmlspecialchars($user['bio'] ?: '未設定'); ?></p>
        <div class="section-title">お気に入りの旅行プラン</div>
        <p class="section-content"><?php echo htmlspecialchars($user['favorite_plans'] ?: '未設定'); ?></p>

        <button class="edit-button" onclick="toggleEditForm()">プロフィール編集</button>

        <div class="edit-form" id="editForm">
        <form action="profile.php" method="POST" enctype="multipart/form-data">
    <label for="bio" class="section-title">自己紹介:</label>
    <textarea name="bio" id="bio" rows="4"><?php echo htmlspecialchars($user['bio']); ?></textarea>

    <label for="favorite_plans" class="section-title">お気に入りの旅行プラン:</label>
    <textarea name="favorite_plans" id="favorite_plans" rows="4"><?php echo htmlspecialchars($user['favorite_plans']); ?></textarea>

    <label for="profile_image">プロフィール画像:</label>
    <input type="file" name="profile_image" id="profile_image">

    <input type="submit" value="更新する">
</form>

<form action="profile.php" method="POST" style="margin-top: 10px;">
    <input type="hidden" name="reset_image" value="1">
    <button type="submit" class="reset-button">画像をリセット</button>
</form>

        </div>

        <p class="error-message" id="errorMessage" style="display: none;">エラーが発生しました。もう一度試してください。</p>
    </div>

    <script>
        function confirmLogout() {
            if (confirm("本当にログアウトしますか？")) {
                window.location.href = "logout.php";
            }
        }

        function toggleEditForm() {
            const form = document.getElementById('editForm');
            form.style.display = form.style.display === 'block' ? 'none' : 'block';
            if (form.style.display === 'block') {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }

        function resetProfileImage() {
            const imgElement = document.getElementById('profileImage');
            imgElement.src = 'images/kkrn_icon_user_6.png'; // デフォルト画像
        }
    </script>
</body>
</html>
