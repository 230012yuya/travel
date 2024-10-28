<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "travel";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("接続失敗: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// お気に入りを取得するクエリ（3つまで）
$sql_favorites = "SELECT plans.destination, plans.start_date, plans.end_date FROM user_favorites 
                  JOIN plans ON user_favorites.plan_id = plans.id 
                  WHERE user_favorites.user_id = '$user_id'
                  LIMIT 3";
$favorites_result = $conn->query($sql_favorites);

// ユーザー情報を取得
$sql_user = "SELECT name, bio, profile_image FROM user WHERE id='$user_id'";
$user_result = $conn->query($sql_user);
$user = $user_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f9ff; /* 柔らかいパステルブルー */
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar {
            overflow: hidden;
            background-color: rgba(50, 50, 70, 0.9); /* 少し濃い目の背景 */
            padding: 0 15px;
            font-size: 18px;
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
            background-color: #ffb6b9; /* 柔らかいピンク */
            color: #fff;
            transform: scale(1.05); /* ホバー時の動き */
        }

        /* Traveeelタイトル */
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

        main {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9); /* 半透明の背景 */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #ff6b6b; /* カラフルな赤 */
            font-size: 28px;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            font-size: 16px;
            color: #333;
        }

        select {
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ffb6b9; /* カラフルなピンク */
            border-radius: 5px;
            background-color: #f9f9f9;
            margin-bottom: 20px;
        }

        button {
            padding: 15px;
            font-size: 18px;
            font-weight: bold;
            background-color: #ff6b6b; /* カラフルな赤 */
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease;
        }

        button:hover {
            background-color: #ffd93d; /* 明るい黄色に変更 */
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        button:active {
            background-color: #ff6b6b;
            transform: scale(1.02);
        }

      /* プロフィール画像のスタイル */
        .profile-image-wrapper {
            position: relative;
            width: 120px;
            height: 120px;
            margin-bottom: 15px;
            margin-left: auto;
            margin-right: auto;
            border-radius: 50%;
            overflow: hidden; /* 画像がコンテナの外に出ないようにする */
            border: 4px solid #ddd; /* 枠の追加 */
        }

        .profile-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            cursor: pointer;
        }

        #profileImageInput {
            display: none; /* 隠しフィールド */
        }

        .profile-image-label {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
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

<!-- Traveeelのタイトル -->
<div class="title">Traveeel</div>

<main>
    <h1>プロフィール</h1>

    <!-- ユーザーアイコンと名前の表示 -->
    <div class="profile-header">
        <div class="profile-image-wrapper">
            <img src="uploads/<?php echo !empty($user['profile_image']) ? $user['profile_image'] : 'default.png'; ?>" alt="" class="profile-image" id="profileImage">
            <label for="profileImageInput" class="profile-image-label"></label>
            <input type="file" name="profile_image" id="profileImageInput" accept="image/*" onchange="document.getElementById('profileImage').src = window.URL.createObjectURL(this.files[0]);">
        </div>
        <h2><?php echo $user['name']; ?></h2>
    </div>

    <!-- お気に入りのプラン表示部分 -->
    <h2>お気に入りのプラン</h2>
    <ul>
        <?php while ($row = $favorites_result->fetch_assoc()) { ?>
            <li><?php echo $row['destination'] . " - " . $row['start_date'] . " 〜 " . $row['end_date']; ?></li>
        <?php } ?>
    </ul>

    <!-- プロフィール更新フォーム -->
    <form action="profile.php" method="post" enctype="multipart/form-data">
        <label for="name">ユーザー名:</label>
        <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>
        
        <label for="bio">自己紹介文:</label>
        <textarea id="bio" name="bio" required><?php echo $user['bio']; ?></textarea>

        <button type="submit">更新</button>
    </form>
</main>

<script>
function confirmLogout() {
    if (confirm("本当にログアウトしますか？")) {
        window.location.href = "logout.php";
    }
}
</script>

</body>
</html>
<?php
$conn->close(); 
?>
