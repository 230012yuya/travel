<?php
// セッションを開始
session_start();

// セッションから旅行プランを取得
if (isset($_SESSION['ai_plan'])) {
    $ai_plan = $_SESSION['ai_plan'];
    //unset($_SESSION['ai_plan']); // 表示後にセッションをクリア
} else {
    $ai_plan = null;
}

$plan = $_SESSION['ai_plan']['plan'];
$plan_schedules = $_SESSION['ai_plan']['plan_schedule'];

foreach ($plan_schedules as $value) {
    $plan_schedule[$value['day']][] = $value;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>旅行プラン表示</title>
    <style>
        body {
            font-family: 'Lora', serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #6a11cb, #2575fc); /* グラデーション背景 */
            color: #000;
        }

        .navbar {
            overflow: hidden;
            background-color: rgba(50, 50, 70, 0.9);
            padding: 0 20px;
            font-size: 18px;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .navbar a:hover {
            background-color: #ffb6b9;
            transform: scale(1.05);
        }

        .container {
            max-width: 900px;
            width: 90%;
            margin: 100px auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(5px);
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 36px;
            font-family: 'Roboto', sans-serif;
            margin-bottom: 20px;
        }

        .error {
            color: red;
            text-align: center;
        }

        .schedule {
            margin-top: 30px;
        }

        .day {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #ddd;
        }

        .activity {
            margin-left: 20px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        .activity p {
            margin: 5px 0;
            font-size: 16px;
        }

        .save-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
            margin-top: 20px;
        }

        .save-btn:hover {
            background: linear-gradient(135deg, #218838, #28a745);
            transform: translateY(-3px);
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
    <div class="container">
        <h1>旅行プラン</h1>
        <?php if ($ai_plan): ?>
            <p><strong>出発地:</strong> <?= htmlspecialchars($plan['departure_point']) ?></p>
            <p><strong>目的地:</strong> <?= htmlspecialchars($plan['destination']) ?></p>
            <p><strong>旅行日程:</strong> <?= htmlspecialchars($plan['start_date']) ?> ～ <?= htmlspecialchars($plan['end_date']) ?></p>
            <p><strong>予算:</strong> <?= htmlspecialchars($plan['budget']) ?> 円</p>
            <p><strong>人数:</strong> <?= htmlspecialchars($plan['number_of_people']) ?> 人</p>
            <p><strong>キーワード:</strong> <?= htmlspecialchars($plan['keywords']) ?> </p>
            <div class="schedule">
                <h2>日別スケジュール</h2>
                <?php foreach ($plan_schedule as $day => $day_schedule): ?>
                    <div class="day">
                        <h3>Day <?= $day ?></h3>
                        <?php foreach ($day_schedule as $value): ?>
                            <div class="activity">
                                <p><strong>時間:</strong> <?= htmlspecialchars($value['time']) ?></p>
                                <p><strong>アクティビティ名:</strong> <?= htmlspecialchars($value['activity']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="error">旅行プランがありません。</p>
        <?php endif; ?>

        <div>
            <form action="save_plan.php" method="post">
                <button>プラン保存</button>
            </form>
        </div>
    </div>
    <script>
        // ログアウト確認ダイアログ
        function confirmLogout() {
            var confirmation = confirm("本当にログアウトしますか？");
            if (confirmation) {
                window.location.href = "logout.php"; // OKが押された場合はログアウト
            }
        }
    </script>
</body>

</html>