<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Learning English</title>
    <link rel="icon" type="image/x-icon" href="images/icons/dino.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
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
            color: red;
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
include('../config/conn.php'); 
include('../src/font/learn_english/header_english.php');

$song_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$song = $conn->query("SELECT * FROM songs WHERE id = $song_id")->fetch_assoc();

if (!$song) {
    echo "<h2>Không có bài hát nào được tìm thấy.</h2>";
    exit;
}

$songLyrics = htmlspecialchars($song['lyrics']);
$comparisonLyrics = htmlspecialchars($song['comparison_lyrics']);

function getYoutubeEmbedUrl($url) {
    if (strpos($url, "youtu.be") !== false) {
        $parts = explode("/", $url);
        return "https://www.youtube.com/embed/" . end($parts);
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


    <div class="container">
        <h1><?php echo htmlspecialchars($song['title']); ?></h1>
        <div class="row">
            <div class="col-md-6">
                <audio controls>
                    <source src="<?php echo htmlspecialchars($song['audio_file']); ?>" type="audio/mpeg">
                    Your browser does not support the audio tag.
                </audio>
                <?php if (!empty($song['video_file'])): ?>
                    <iframe width="100%" height="281" src="<?php echo getYoutubeEmbedUrl($song['video_file']); ?>" frameborder="0" allowfullscreen></iframe>
                <?php else: ?>
                    <p>Không có video</p>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <div id="lyrics">
                    <h3>Lời bài hát:</h3>
                    <p id="lyrics-text"><?php echo nl2br(htmlspecialchars($song['lyrics'])); ?></p>
                </div>
                <button class="speak" data-lyrics="<?php echo addslashes($songLyrics); ?>" data-comparison="<?php echo addslashes($comparisonLyrics); ?>">Bắt đầu hát</button>
                <p id="textarea">Kết quả sẽ hiển thị ở đây...</p>
                <p id="score"></p>
            </div>
        </div>
    </div>

    <script>
     document.addEventListener('DOMContentLoaded', function () {
    var speakButton = document.querySelector('.speak');
    var songLyrics = speakButton.getAttribute('data-lyrics').toLowerCase();
    var comparisonLyrics = speakButton.getAttribute('data-comparison').toLowerCase();
    var textarea = document.getElementById('textarea');
    var scoreDisplay = document.getElementById('score');
    var audio = document.querySelector('audio');
    var video = document.querySelector('iframe');

    var isRecognizing = false; // Kiểm tra trạng thái nhận diện
    var recognition;
    var totalDuration; // Thời gian tổng của video

    function getVideoDuration() {
        totalDuration = video ? video.duration : 0;
    }

    function startRecognition() {
        if (isRecognizing) return; // Bỏ qua nếu đang nhận diện
        isRecognizing = true;

        var SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        if (!SpeechRecognition) {
            textarea.innerHTML = 'Trình duyệt của bạn không hỗ trợ nhận diện giọng nói.';
            return;
        }

        recognition = new SpeechRecognition();
        recognition.lang = 'en-US';
        recognition.continuous = true; // Cho phép ghi âm liên tục
        recognition.interimResults = true; // Cho phép hiển thị kết quả giữa chừng

        recognition.onresult = function (e) {
            var transcript = '';
            for (var i = e.resultIndex; i < e.results.length; i++) {
                transcript += e.results[i][0].transcript + ' ';
            }
            textarea.innerHTML = transcript; // Cập nhật hiển thị
            evaluatePerformance(transcript.trim(), songLyrics, comparisonLyrics, scoreDisplay);
        };

        recognition.onerror = function (e) {
            textarea.innerHTML = 'Lỗi: ' + e.error;
        };

        recognition.onend = function() {
            isRecognizing = false; // Đánh dấu rằng đã ngừng nhận diện
        };

        recognition.start();
        textarea.innerHTML = 'Đang ghi âm...';
    }

    speakButton.addEventListener('click', function () {
        // Tự động phát video và lấy thời gian tổng
        if (video) {
            video.src += "?autoplay=1"; // Thêm tham số autoplay
            video.addEventListener('loadedmetadata', getVideoDuration); // Lấy thời gian bài hát
        }

        audio.play(); // Phát âm thanh bài hát
        startRecognition(); // Bắt đầu ghi âm

        // Thiết lập đồng hồ để theo dõi thời gian video
        var checkVideoStatus = setInterval(function() {
            if (video && video.currentTime >= totalDuration) {
                recognition.stop(); // Dừng ghi âm khi video kết thúc
                clearInterval(checkVideoStatus);
                textarea.innerHTML += '<br>Video đã kết thúc.';
            }
        }, 1000); // Kiểm tra mỗi giây
    });
    function evaluatePerformance(transcript, songLyrics, comparisonLyrics, scoreDisplay) {
        // Chuẩn hóa văn bản: bỏ dấu câu, viết thường, loại bỏ khoảng trắng thừa
        function cleanText(text) {
            return text.toLowerCase()
                .replace(/[.,!?;:()]/g, '') // Loại bỏ dấu câu
                .replace(/\s+/g, ' ') // Xóa khoảng trắng thừa
                .trim();
        }

        var cleanedTranscript = cleanText(transcript);
        var cleanedComparison = cleanText(comparisonLyrics);

        var transcriptWords = cleanedTranscript.split(" ");
        var comparisonWords = cleanedComparison.split(" ");

        var correctCount = 0;
        var errors = [];

        // So sánh từng từ với comparisonLyrics
        for (var i = 0; i < comparisonWords.length; i++) {
            if (transcriptWords[i] === comparisonWords[i]) {
                correctCount++;
            } else {
                errors.push(comparisonWords[i]); // Lưu từ sai
            }
        }

        // Tính điểm chính xác hơn: số từ đúng / tổng số từ * 100
        var score = Math.round((correctCount / comparisonWords.length) * 100);
        if (correctCount === comparisonWords.length) {
            score = 100; // Nếu đúng toàn bộ, luôn cho điểm 100%
            errors = [];
        }

        // Hiển thị điểm số lên giao diện
        scoreDisplay.innerHTML = `
            <strong>⭐ Điểm của bạn: ${score}%</strong><br>
            ${errors.length > 0 ? `❌ Sai từ: ${errors.map(err => `<span class="error">${err}</span>`).join(', ')}` : "✅ Không có lỗi!"}
        `;
    }
});
    </script>
</body>
</html>

<?php 
$conn->close(); 
?>