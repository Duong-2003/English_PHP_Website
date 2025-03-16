<!DOCTYPE html>
<html lang="en">
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
            background-color: #f8f9fa; /* Màu nền sáng */
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        h1 {
            color: #007bff; /* Màu xanh cho tiêu đề */
            margin-bottom: 30px;
        }
        #lyrics {
            background-color: #ffffff; /* Nền trắng cho lời bài hát */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        #textarea {
            margin-top: 20px;
            font-size: 20px;
            min-height: 50px;
            border: 1px solid #007bff;
            border-radius: 5px;
            padding: 10px;
            background-color: #e9ecef; /* Màu nền cho kết quả */
        }
        #score {
            margin-top: 20px;
            font-size: 24px;
            color: green;
        }
        .error {
            color: red; /* Màu đỏ cho các từ sai */
        }
        button {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php 
    session_start();
    include('../config/conn.php'); // Kết nối cơ sở dữ liệu
    include('../src/font/learn_english/header_english.php');

    // Lấy ID bài hát từ URL
    $song_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    // Lấy thông tin bài hát dựa trên ID
    $song = $conn->query("SELECT * FROM songs WHERE id = $song_id")->fetch_assoc();
    ?>
    
    <div class="container">
        <h1>Sing and Score</h1>
        
        <!-- Hiển thị audio và lời bài hát -->
        <?php if ($song): ?>
            <audio controls>
                <source src="<?php echo htmlspecialchars($song['audio_file']); ?>" type="audio/mpeg">
                Your browser does not support the audio tag.
            </audio>
            


            <div id="lyrics">
                <h3>Lyrics:</h3>
                <p id="lyrics-text"><?php echo nl2br(htmlspecialchars($song['lyrics'])); ?></p>
            </div>
        <?php else: ?>
            <p>No song available to display.</p>
        <?php endif; ?>

        <button id="speak" class="btn btn-primary btn-lg">Start Singing</button>
        <p id="textarea">Results will be displayed here...</p>
        <p id="score"></p>
    </div>

    <script>
        var speak = document.getElementById('speak');
        var textarea = document.getElementById('textarea');
        var scoreDisplay = document.getElementById('score');

        var SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        var recognition = new SpeechRecognition();
        
        // Lời bài hát để so sánh
        var songLyrics = "<?php echo addslashes($song['lyrics']); ?>".toLowerCase(); // Lấy lời bài hát từ DB

        speak.addEventListener('click', function () {
            recognition.start();
            textarea.innerHTML = 'Recording...';
        });

        recognition.onresult = function (e) {
            var transcript = e.results[0][0].transcript;
            textarea.innerHTML = transcript;
            evaluatePerformance(transcript);
        };

        recognition.onerror = function (e) {
            textarea.innerHTML = 'Error: ' + e.error;
        };

        function evaluatePerformance(transcript) {
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
            scoreDisplay.innerHTML = `Score: ${score.toFixed(2)}%<br>Errors: ${errors.map(err => `<span class="error">${err}</span>`).join(', ')}`;
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>