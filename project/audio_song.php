<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hát và Chấm điểm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        #textarea {
            margin-top: 20px;
            font-size: 20px;
            min-height: 50px;
        }
        #score {
            margin-top: 20px;
            font-size: 24px;
            color: green;
        }
        #lyrics {
            margin: 20px 0;
            font-size: 18px;
        }
        audio {
            margin: 20px 0;
        }
        .error {
            color: red; /* Màu đỏ cho các từ sai */
        }
    </style>
</head>
<body>
    <div>
        <h1>Hát và Chấm Điểm</h1>
        <audio controls>
            <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg"> <!-- Link audio hợp lệ -->
            Your browser does not support the audio tag.
        </audio>
        <div id="lyrics">
            <h3>Lời bài hát:</h3>
            <p id="lyrics-text">Twinkle, twinkle, little star,<br>
            How I wonder what you are!<br>
            Up above the world so high,<br>
            Like a diamond in the sky.<br>
            Twinkle, twinkle, little star,<br>
            How I wonder what you are!</p>
        </div>
        <button id="speak">Bắt đầu hát</button>
        <p id="textarea">Kết quả sẽ hiển thị ở đây...</p>
        <p id="score"></p>
    </div>

    <script>
        var speak = document.getElementById('speak');
        var textarea = document.getElementById('textarea');
        var scoreDisplay = document.getElementById('score');

        var SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        var recognition = new SpeechRecognition();
        
        // Lời bài hát để so sánh
        var songLyrics = "twinkle twinkle little star how i wonder what you are up above the world so high like a diamond in the sky twinkle twinkle little star how i wonder what you are";

        speak.addEventListener('click', function () {
            recognition.start();
            textarea.innerHTML = 'Đang ghi âm...';
        });

        recognition.onresult = function (e) {
            var transcript = e.results[0][0].transcript;
            textarea.innerHTML = transcript;
            evaluatePerformance(transcript);
        };

        recognition.onerror = function (e) {
            textarea.innerHTML = 'Lỗi: ' + e.error;
        };

        function evaluatePerformance(transcript) {
            var lyricsWords = songLyrics.toLowerCase().split(/\s+/);
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