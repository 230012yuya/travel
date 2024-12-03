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
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
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

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .error {
            color: red;
            text-align: center;
        }

        .schedule {
            margin-top: 20px;
        }

        .day {
            margin-bottom: 20px;
        }

        .activity {
            margin-left: 20px;
            padding: 10px;
            border-left: 3px solid #007bff;
            margin-bottom: 10px;
        }

        .activity p {
            margin: 5px 0;
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
            <p><strong>旅行日程:</strong> <?= htmlspecialchars($plan['start_date']) ?> ～ <?= htmlspecialchars($plan['start_date']) ?></p>
            <p><strong>予算:</strong> <?= htmlspecialchars($plan['budget']) ?> 円</p>
            <p><strong>人数:</strong> <?= htmlspecialchars($plan['number_of_people']) ?> 人</p>
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