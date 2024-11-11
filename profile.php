<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

$name = $_SESSION['name'];
$profile_image = $_SESSION['profile_image'];

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "travel";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("接続失敗: " . $conn->connect_error);
}

$sql = "SELECT * FROM user WHERE name = '$name'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

$user_id = $_SESSION['user_id'];
$favorites_sql = "SELECT plans.* FROM plans 
                  JOIN user_favorites ON plans.id = user_favorites.plan_id 
                  WHERE user_favorites.user_id = '$user_id'";
$favorites_result = $conn->query($favorites_sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bio = $_POST['bio'];
    $favorite_plans = $_POST['favorite_plans'];

    if ($_FILES['profile_image']['name'] != "") {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);
        $profile_image = basename($_FILES["profile_image"]["name"]);
    }

    $update_sql = "UPDATE user SET bio = '$bio', profile_image = '$profile_image' WHERE name = '$name'";
    if ($conn->query($update_sql) === TRUE) {
        header("Location: profile.php");
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
    <title>プロフィールページ</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f9ff;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar {
            overflow: hidden;
            background-color: rgba(50, 50, 70, 0.9);
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
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
            margin: 80px auto;
        }

        .profile-container img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 3px solid #ffb6b9;
        }

        h1 {
            font-size: 24px;
            color: #3a506b;
            margin-bottom: 15px;
        }

        p {
            color: #555;
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
        }

        .edit-button {
            background-color: #ffd93d;
            padding: 8px 15px;
            font-weight: bold;
            margin-top: 15px;
        }

        .edit-button:hover {
            background-color: #ff6b6b;
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
        <img src="uploads/<?php echo htmlspecialchars($user['profile_image']); ?>" alt="プロフィール画像">
        <p><strong>自己紹介:</strong> <?php echo htmlspecialchars($user['bio']); ?></p>
        <h2>お気に入りプラン</h2>
        <ul>
            <?php while ($plan = $favorites_result->fetch_assoc()): ?>
                <li>
                    目的地: <?php echo htmlspecialchars($plan['destination']); ?><br>
                    日程: <?php echo htmlspecialchars($plan['start_date']); ?> ~ <?php echo htmlspecialchars($plan['end_date']); ?><br>
                    <a href="plan_detail.php?plan_id=<?php echo $plan['id']; ?>">詳細を見る</a>
                </li>
            <?php endwhile; ?>
        </ul>
        <!-- 編集フォームの表示 -->
        <button class="edit-button" onclick="toggleEditForm()">プロフィール編集</button>

        <div class="edit-form" id="editForm">
            <form action="profile.php" method="POST" enctype="multipart/form-data">
                <label for="bio">自己紹介:</label><br>
                <textarea name="bio" id="bio" rows="4" cols="30"><?php echo htmlspecialchars($user['bio']); ?></textarea><br>

                <label for="favorite_plans">お気に入りの旅行プラン:</label><br>
                <input type="text" name="favorite_plans" id="favorite_plans" value="<?php echo htmlspecialchars($user['favorite_plans']); ?>"><br>

                <label for="profile_image">プロフィール画像:</label><br>
                <input type="file" name="profile_image" id="profile_image"><br>

                <input type="submit" value="更新する">
            </form>
        </div>
    </div>

    <script>
        function confirmLogout() {
            var confirmation = confirm("本当にログアウトしますか？");
            if (confirmation) {
                window.location.href = "logout.php";
            }
        }

        // 編集フォームの表示・非表示を切り替える
        function toggleEditForm() {
            const form = document.getElementById('editForm');
            form.style.display = form.style.display === 'block' ? 'none' : 'block';
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
