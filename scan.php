<?php
include 'db.php';

function extract_info($text) {
    // Basic name, email, phone extraction
    preg_match('/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}/i', $text, $email);
    preg_match('/\+?\d[\d\s\-]{9,}/', $text, $phone);
    $lines = explode("\n", trim($text));
    $name = trim($lines[0]) ?? 'Not found';

    return [
        'name' => $name,
        'email' => $email[0] ?? 'Not found',
        'phone' => $phone[0] ?? 'Not found',
    ];
}

function score_resume($resume_text, $jd_text) {
    $resume_words = array_unique(explode(" ", strtolower(preg_replace("/[^a-z0-9 ]/", "", $resume_text))));  
    $jd_words = array_unique(explode(" ", strtolower(preg_replace("/[^a-z0-9 ]/", "", $jd_text))));

    $match_count = count(array_intersect($jd_words, $resume_words));
    $total = max(count($jd_words), 1);
    return round(($match_count / $total) * 100, 2);
}

// Main logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['resume'])) {
    $tmp = $_FILES['resume']['tmp_name'];
    $text = file_get_contents($tmp);
    $jd = $_POST['jd'];

    $info = extract_info($text);
    $score = score_resume($text, $jd);

    $stmt = $mysqli->prepare("INSERT INTO resumes (name, email, phone, score) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssd", $info['name'], $info['email'], $info['phone'], $score);
    $stmt->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATS Resume Scan Result</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #4e73df;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .container {
            max-width: 700px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #4e73df;
            margin-bottom: 20px;
            text-align: center;
        }

        .result-details {
            font-size: 16px;
            color: #333;
            margin-bottom: 20px;
        }

        .result-details span {
            font-weight: 600;
        }

        .progress-bar {
            width: 100%;
            background-color: #e0e0e0;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .progress-bar div {
            height: 20px;
            border-radius: 10px;
            transition: width 0.5s ease;
        }

        .score-value {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #4e73df;
            margin-top: 10px;
        }

        .resume-text {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
            font-family: 'Courier New', Courier, monospace;
            white-space: pre-wrap;
            word-wrap: break-word;
            border: 1px solid #ccc;
        }

        /* Footer Section */
        footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #888;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .container {
                margin: 20px;
                padding: 15px;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>ATS Resume Scanner</h1>
    <p>Optimize your resume with accurate scoring!</p>
</header>

<div class="container">
    <h2>Scan Result</h2>
    <div class="result-details">
        <p><span>Name:</span> <?php echo $info['name']; ?></p>
        <p><span>Email:</span> <?php echo $info['email']; ?></p>
        <p><span>Phone:</span> <?php echo $info['phone']; ?></p>
    </div>

    <!-- Progress Bar -->
    <div class="progress-bar">
        <div style="width: <?php echo $score; ?>%; background-color: #4e73df;"></div>
    </div>

    <div class="score-value">
        <p>Score: <?php echo $score; ?> / 100</p>
    </div>

    <!-- Display Resume Text -->
    <div class="resume-text">
        <h3>Resume Content</h3>
        <p><?php echo nl2br(htmlspecialchars($text)); ?></p>
    </div>
</div>

<footer>
    <p>&copy; 2025 ATS Resume Scanner. All rights reserved.</p>
</footer>

</body>
</html>

<?php } ?>
