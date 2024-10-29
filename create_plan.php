<?php
// env.php を読み込み
require_once '../../env.php';

$posts = json_decode(file_get_contents('php://input'), true);

// Gemini APIの場合
$data = createByAI($posts);

// テストデータの場合
// $data = testData();

header('Content-Type: application/json');
echo $data;

function createByAI($conditions)
{
    if (!$conditions) return;

    // Google APIキー
    $api_key = getenv('AIzaSyAozQKdv6q6cdO1p4hw8e0a8SXs7mpC9qg');

    // TODO 欲しいJSONデータがレスポンスされるようにプロンプトを考える    
    $prompt = "つぎの条件で旅行プランをJSONのみでレスポンス" . PHP_EOL;
    $prompt .= "departure: {$conditions['departure']}" . PHP_EOL;
    $prompt .= "destination: {$conditions['destination']}" . PHP_EOL;
    $prompt .= "departureDate: {$conditions['departureDate']}" . PHP_EOL;
    $prompt .= "arrivalDate: {$conditions['arrivalDate']}" . PHP_EOL;
    $prompt .= "number_of_people: {$conditions['number_of_people']}" . PHP_EOL;
    $prompt .= "budget: {$conditions['budget']}" . PHP_EOL;
    $prompt .= "keywords: {$conditions['keywords']}" . PHP_EOL;
    $prompt .= "JSONテンプレート" . PHP_EOL;
    $prompt .= template();

    $data = [
        'contents' => [
            [
                'parts' => [
                    ['text' => $prompt],
                ]
            ]
        ]
    ];

    // TODO Gemini AI処理
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $api_key);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode(['error' => curl_error($ch)]);
    } else {
        $response_data = json_decode($response, true);
        if (isset($response_data['candidates'][0]['content']['parts'][0]['text'])) {
            $text = $response_data['candidates'][0]['content']['parts'][0]['text'];
            $json = str_replace(['```json', '```'], '', $text);
        }
    }
    curl_close($ch);
    return $json;
}

// AIの結果を想定（テストデータ）
function testData()
{
    $data = '
{
    "plan": {
        "departure": "東京",
        "destination": "札幌",
        "departureDate": "2024-03-01",
        "arrivalDate": "2024-03-05",
        "budget": "50000",
        "keywords": "観光"
    },
    "plan_items": [
        {
            "date": "2024-03-01",
            "transportation": "新幹線",
            "place": "東京駅",
            "activity": "到着",
            "memo": "ホテルにチェックイン"
        },
        {
            "date": "2024-03-01",
            "transportation": "徒歩",
            "place": "東京スカイツリー",
            "activity": "展望台",
            "memo": "東京の景色を満喫"
        },
        {
            "date": "2024-03-01",
            "transportation": "徒歩",
            "place": "浅草寺",
            "activity": "参拝",
            "memo": "雷門を通って仲見世通りを散策"
        },
        {
            "date": "2024-03-02",
            "transportation": "電車",
            "place": "上野動物園",
            "activity": "動物鑑賞",
            "memo": "パンダに会いに行く"
        },
        {
            "date": "2024-03-02",
            "transportation": "徒歩",
            "place": "上野公園",
            "activity": "散歩",
            "memo": "桜並木を歩く"
        },
        {
            "date": "2024-03-02",
            "transportation": "電車",
            "place": "秋葉原",
            "activity": "買い物",
            "memo": "電気街で買い物を楽しむ"
        },
        {
            "date": "2024-03-03",
            "transportation": "電車",
            "place": "渋谷",
            "activity": "ショッピング",
            "memo": "流行の洋服や雑貨を見る"
        },
        {
            "date": "2024-03-03",
            "transportation": "徒歩",
            "place": "渋谷スクランブル交差点",
            "activity": "散策",
            "memo": "スクランブル交差点を渡る"
        },
        {
            "date": "2024-03-03",
            "transportation": "電車",
            "place": "新宿",
            "activity": "ディナー",
            "memo": "新宿ゴールデン街で食事"
        },
        {
            "date": "2024-03-04",
            "transportation": "電車",
            "place": "築地市場",
            "activity": "市場見学",
            "memo": "新鮮な魚介類を食べる"
        },
        {
            "date": "2024-03-04",
            "transportation": "電車",
            "place": "皇居",
            "activity": "散策",
            "memo": "皇居東御苑を歩く"
        },
        {
            "date": "2024-03-04",
            "transportation": "電車",
            "place": "銀座",
            "activity": "買い物",
            "memo": "高級ブランドショップを巡る"
        },
        {
            "date": "2024-03-05",
            "transportation": "新幹線",
            "place": "東京駅",
            "activity": "出発",
            "memo": "お土産を買って帰路につく"
        }
    ]
}';
    return $data;
}


function template()
{
    $template = '
{
        "plan": {
            "departure": "xxxx",
            "destination": "xxxx",
            "departureDate": "xxxx-xx-xx",
            "arrivalDate": "xxxx-xx-xx",
            "budget": "xxxxxx",
            "keywords": "xxxx, xxxx, xxxx"
        },
        "plan_items": [
            {
                "date": "xxxx-xx-xx xx:xx",
                "transportation": "xxxx",
                "place": "xxxx",
                "activity": "xxxx",
                "memo": "xxxxxxxx"
            },
            {
                "date": "xxxx-xx-xx xx:xx",
                "transportation": "xxxx",
                "place": "xxxx",
                "activity": "xxxx",
                "memo": "xxxxxxxx"
            },
            {
                "date": "xxxx-xx-xx xx:xx",
                "transportation": "xxxx",
                "place": "xxxx",
                "activity": "xxxx",
                "memo": "xxxxxxxx"
            }
        ]
    }';
    return $template;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>旅行プラン作成</title>
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
        text-shadow: 4px 4px 10px rgba(0, 0, 0, 0.5), 0 0 20px rgba(0, 0, 0, 0.7); /* 影を強調 */
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
            font-size: 28px; /* タイトルサイズ */
            margin-bottom: 30px;
        }

        ul {
            list-style-type: none; /* リストのスタイルをなしに */
            padding: 0;
        }

        li {
            background-color: #e3f2fd; /* 各プランの背景色 */
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            transition: transform 0.2s;
        }

        li:hover {
            transform: scale(1.02); /* ホバー時に少し拡大 */
        }

    </style>
</head>
<body style="font-family: 'Roboto', sans-serif; margin: 0; padding: 0; background-color: #f0f9ff; color: #333; display: flex; flex-direction: column; min-height: 100vh;">

    <div class="navbar" id="myNavbar" style="overflow: hidden; background-color: rgba(50, 50, 70, 0.9); padding: 0 15px; font-size: 18px;">
        <a href="home.php" style="float: left; display: block; color: white; text-align: center; padding: 14px 20px; text-decoration: none; font-weight: bold; transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;">ホーム</a>
        <a href="create_plan.php" style="float: left; display: block; color: white; text-align: center; padding: 14px 20px; text-decoration: none; font-weight: bold; transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;">旅行プラン作成</a>
        <a href="display.php" style="float: left; display: block; color: white; text-align: center; padding: 14px 20px; text-decoration: none; font-weight: bold; transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;">旅行プラン表示</a>
        <a href="profile.php" style="float: left; display: block; color: white; text-align: center; padding: 14px 20px; text-decoration: none; font-weight: bold; transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;">プロフィール</a>
        <a href="view_plans.php" style="float: left; display: block; color: white; text-align: center; padding: 14px 20px; text-decoration: none; font-weight: bold; transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;">過去の旅行プラン</a>
        <a href="javascript:void(0);" onclick="confirmLogout()" style="float: left; display: block; color: white; text-align: center; padding: 14px 20px; text-decoration: none; font-weight: bold; transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;">ログアウト</a>
    </div>

    <div class="title" style="position: absolute; top: 10px; right: 20px; font-size: 50px; font-weight: bold; background: linear-gradient(45deg, #ff6b6b, #ffd93d, #6bc9ff); -webkit-background-clip: text; color: transparent; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3); transition: transform 0.3s ease;">Traveeel</div>

    <div class="form-container" style="max-width: 800px; max-height: 90vh; margin: 50px auto; padding: 30px; background-color: rgba(255, 255, 255, 0.9); border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); overflow-y: auto;">
        <h1 style="text-align: center; color: #ff6b6b; font-size: 28px; margin-bottom: 30px;">旅行プラン作成</h1>
        <form action="save_plan.php" method="post">
            <div class="form-row" style="display: flex; flex-direction: column; margin-bottom: 20px;">
                <label for="departure" style="margin-bottom: 8px; font-size: 16px; color: #333;">出発地点:</label>
                <input type="text" id="departure" name="departure" required style="padding: 12px; font-size: 16px; border: 1px solid #ffb6b9; border-radius: 5px; background-color: #f9f9f9; transition: border-color 0.3s; width: 100%;">
            </div>

            <div class="form-row" style="display: flex; flex-direction: column; margin-bottom: 20px;">
                <label for="destination" style="margin-bottom: 8px; font-size: 16px; color: #333;">目的地:</label>
                <input type="text" id="destination" name="destination" required style="padding: 12px; font-size: 16px; border: 1px solid #ffb6b9; border-radius: 5px; background-color: #f9f9f9; transition: border-color 0.3s; width: 100%;">
            </div>

            <div class="form-row" style="display: flex; flex-direction: column; margin-bottom: 20px;">
                <label for="departureDate" style="margin-bottom: 8px; font-size: 16px; color: #333;">開始日:</label>
                <input type="date" id="departureDate" name="departureDate" required style="padding: 12px; font-size: 16px; border: 1px solid #ffb6b9; border-radius: 5px; background-color: #f9f9f9; transition: border-color 0.3s; width: 100%;">
            </div>

            <div class="form-row" style="display: flex; flex-direction: column; margin-bottom: 20px;">
                <label for="arrivalDate" style="margin-bottom: 8px; font-size: 16px; color: #333;">終了日:</label>
                <input type="date" id="arrivalDate" name="arrivalDate" required style="padding: 12px; font-size: 16px; border: 1px solid #ffb6b9; border-radius: 5px; background-color: #f9f9f9; transition: border-color 0.3s; width: 100%;">
            </div>

            <div class="form-row" style="display: flex; flex-direction: column; margin-bottom: 20px;">
                <label for="number_of_people" style="margin-bottom: 8px; font-size: 16px; color: #333;">人数:</label>
                <input type="number" id="number_of_people" name="number_of_people" min="1" required style="padding: 12px; font-size: 16px; border: 1px solid #ffb6b9; border-radius: 5px; background-color: #f9f9f9; transition: border-color 0.3s; width: 100%;">
            </div>

            <div class="form-row" style="display: flex; flex-direction: column; margin-bottom: 20px;">
                <label for="budget" style="margin-bottom: 8px; font-size: 16px; color: #333;">予算:</label>
                <input type="number" id="budget" name="budget" step="1" min="0" required style="padding: 12px; font-size: 16px; border: 1px solid #ffb6b9; border-radius: 5px; background-color: #f9f9f9; transition: border-color 0.3s; width: 100%;">
            </div>

            <div class="form-row" style="display: flex; flex-direction: column; margin-bottom: 20px;">
                <label for="details" style="margin-bottom: 8px; font-size: 16px; color: #333;">詳細:</label>
                <textarea id="details" name="details" required style="padding: 12px; font-size: 16px; border: 1px solid #ffb6b9; border-radius: 5px; background-color: #f9f9f9; transition: border-color 0.3s; width: 100%; height: 100px; resize: vertical;"></textarea>
            </div>

            <button type="submit" style="width: 100%; padding: 15px; font-size: 18px; font-weight: bold; background-color: #ff6b6b; color: white; border: none; border-radius: 10px; cursor: pointer; transition: transform 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease;">
                作成
            </button>
        </form>
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