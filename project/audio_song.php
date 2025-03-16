<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Learning English</title>
    <link rel="icon" type="image/x-icon" href="images/icons/dino.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            text-align: center;
            margin-top: 50px;
        }
        h1 {
            color: #007bff;
            margin-bottom: 30px;
        }
        #textarea {
            margin-top: 20px;
            font-size: 20px;
            min-height: 50px;
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 5px;
        }
        #score {
            margin-top: 20px;
            font-size: 24px;
            color: green;
        }
        #lyrics {
            margin: 20px 0;
            font-size: 18px;
            background-color: #ffffff;
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 15px;
        }
        audio {
            margin: 20px 0;
            border-radius: 5px;
        }
        .error {
            color: red; /* Màu đỏ cho các từ sai */
        }
        .speak {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .speak:hover {
            background-color: #218838;
        }
    </style>
</head>
<?php
    session_start();
    include('../config/conn.php'); // Kết nối cơ sở dữ liệu
    include('../src/font/learn_english/header_english.php');

    // Lấy ID bài hát từ URL
    $song_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Lấy thông tin bài hát dựa trên ID
    $song = $conn->query("SELECT * FROM songs WHERE id = $song_id")->fetch_assoc();

    if (!$song) {
        echo "<h2>Không có bài hát nào được tìm thấy.</h2>";
        exit;
    }

    function getYoutubeEmbedUrl($url) {
        if (strpos($url, "youtu.be") !== false) {
            $parts = explode("/", $url);
            $id = end($parts);
            return "https://www.youtube.com/embed/" . $id;
        }
        if (strpos($url, "youtube.com") !== false) {
            parse_str(parse_url($url, PHP_URL_QUERY), $query);
            if (isset($query['v'])) {
                return "https://www.youtube.com/embed/" . $query['v'];
            }
        }
        return $url;
    }
    ?>

<body>
    
    <div>
        <h1><?php echo htmlspecialchars($song['title']); ?></h1>
        <audio controls>
            <source src="<?php echo htmlspecialchars($song['audio_file']); ?>" type="audio/mpeg">
            Your browser does not support the audio tag.
        </audio>
        <?php if (!empty($song['video_file'])): ?>
            <?php $embedUrl = getYoutubeEmbedUrl($song['video_file']); ?>
            <iframe width="500" height="281" src="<?php echo $embedUrl; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full"></iframe>
        <?php else: ?>
            <p>Không có video</p>
        <?php endif; ?>
        <div id="lyrics">
            <h3>Lời bài hát:</h3>
            <p id="lyrics-text"><?php echo nl2br(htmlspecialchars($song['lyrics'])); ?></p>
        </div>
        <button class="speak" data-id="<?php echo $song['id']; ?>" data-lyrics="<?php echo addslashes($song['lyrics']); ?>">Bắt đầu hát</button>
        <p class="textarea">Kết quả sẽ hiển thị ở đây...</p>
        <p class="score"></p>
    </div>

    <script>
        var speakButton = document.querySelector('.speak');

        speakButton.addEventListener('click', function () {
            var textarea = speakButton.nextElementSibling;
            var scoreDisplay = textarea.nextElementSibling;
            var songLyrics = speakButton.getAttribute('data-lyrics').toLowerCase();

            var SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            if (!SpeechRecognition) {
                textarea.innerHTML = 'Trình duyệt của bạn không hỗ trợ nhận diện giọng nói.';
                return;
            }

            var recognition = new SpeechRecognition();

            recognition.start();
            textarea.innerHTML = 'Đang ghi âm...';

            recognition.onresult = function (e) {
                var transcript = e.results[0][0].transcript;
                textarea.innerHTML = transcript;
                evaluatePerformance(transcript, songLyrics, scoreDisplay);
            };

            recognition.onerror = function (e) {
                textarea.innerHTML = 'Lỗi: ' + e.error;
            };

            recognition.onend = function() {
                textarea.innerHTML += '<br>Ghi âm đã dừng.';
            };
        });

        function evaluatePerformance(transcript, songLyrics, scoreDisplay) {
            var lyricsWords = songLyrics.split(/\s+/);
            var transcriptWords = transcript.toLowerCase().split(/\s+/);
            var correctCount = 0;
            var errors = [];

            lyricsWords.forEach(function (word, index) {
                if (transcriptWords[index] === word) {
                    correctCount++;
                } else {
                    errors.push(word);
                }
            });

            var score = (correctCount / lyricsWords.length) * 100; // Tính điểm phần trăm
            scoreDisplay.innerHTML = `Điểm: ${score.toFixed(2)}%<br>Lỗi: ${errors.map(err => `<span class="error">${err}</span>`).join(', ')}`;
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>