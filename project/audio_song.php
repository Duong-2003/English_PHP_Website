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
            min-height: 150px;
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
            display: none;
        }
        audio {
            margin: 20px 0;
            border-radius: 5px;
        }
        .error {
            color: red;
        }
        .output {
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 20px;
            width: 500px;
            height: 200px;
            overflow-y: auto;
            margin-left: auto;
            margin-right: auto;
            background: #f9f9f9;
        }
        .btn-start, .btn-stop, #toggleLyrics {
            padding: 10px 20px;
            margin: 5px;
            cursor: pointer;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .btn-start {
            background-color: #28a745;
        }
        .btn-stop {
            background-color: #dc3545;
        }
        #toggleLyrics{
            background-color: #007bff;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    include('../config/conn.php');
    include('../src/font/learn_english/header_english.php');

    $song_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $song = $conn->query("SELECT * FROM songs WHERE id = $song_id")->fetch_assoc();

    if (!$song) {
        echo "<div class='container'><h2>Không có bài hát nào được tìm thấy.</h2></div>";
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
                    <iframe width="100%" height="400" src="<?php echo getYoutubeEmbedUrl($song['video_file']); ?>" frameborder="0" allowfullscreen></iframe>
                <?php else: ?>
                    <p>Không có video</p>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <div id="lyrics">
                    <h3>Lời bài hát:</h3>
                    <p id="lyrics-text"><?php echo nl2br(htmlspecialchars($song['lyrics'])); ?></p>
                </div>
                <button id="toggleLyrics">Hiện/Ẩn Lời Bài Hát</button>
                <button class="speak btn-start" data-lyrics="<?php echo addslashes($songLyrics); ?>" data-comparison="<?php echo addslashes($comparisonLyrics); ?>">Bắt đầu hát</button>
                <button class="btn-stop">Dừng</button>
                <p class="output" id="textarea" cols="30" rows="10" readonly>Kết quả sẽ hiển thị ở đây...</p>
                <p id="score"></p>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var speakButton = document.querySelector('.speak');
            var stopButton = document.querySelector('.btn-stop');
            var songLyrics = speakButton.getAttribute('data-lyrics').toLowerCase();
            var comparisonLyrics = speakButton.getAttribute('data-comparison').toLowerCase();
            var textarea = document.getElementById('textarea');
            var scoreDisplay = document.getElementById('score');
            var audio = document.querySelector('audio');
            var video = document.querySelector('iframe');
            var lyricsElement = document.getElementById('lyrics');
            var toggleLyricsButton = document.getElementById('toggleLyrics');

            var speech = new SpeechRecognitionApi({
                output: textarea,
            });

            var isRecording = false;

            speakButton.addEventListener('click', function () {
                if (video) {
                    video.src += "?autoplay=1";
                }
                audio.play();
                speech.init();
                isRecording = true;
                textarea.innerHTML = 'Đang ghi âm...';
            });

            stopButton.addEventListener('click', function () {
                if (isRecording) {
                    speech.stop();
                    isRecording = false;
                    evaluatePerformance(textarea.textContent.replace('Đang ghi âm...', '').trim(), songLyrics, comparisonLyrics, scoreDisplay);
                }
            });

            toggleLyricsButton.addEventListener('click', function() {
                lyricsElement.style.display = lyricsElement.style.display === 'none' ? 'block' : 'none';
            });

            function evaluatePerformance(transcript, songLyrics, comparisonLyrics, scoreDisplay) {
                function cleanText(text) {
                    return text.toLowerCase().replace(/[.,!?;:()]/g, '').replace(/\s+/g, ' ').trim();
                }

                var cleanedTranscript = cleanText(transcript);
                var cleanedComparison = cleanText(comparisonLyrics);

                var transcriptWords = cleanedTranscript.split(" ");
                var comparisonWords = cleanedComparison.split(" ");

                var correctCount = 0;
                var errors = [];
                var usedComparisonIndices = [];
                var highlightedTranscript = "";

                for (var i = 0; i < transcriptWords.length; i++) {
                    var foundMatch = false;
                    for (var j = 0; j < comparisonWords.length; j++) {
                        if (transcriptWords[i] === comparisonWords[j] && !usedComparisonIndices.includes(j)) {
                            correctCount++;
                            usedComparisonIndices.push(j);
                            foundMatch = true;
                            highlightedTranscript += transcriptWords[i] + " ";
                            break;
                        }
                    }
                    if (!foundMatch) {
                        errors.push(transcriptWords[i]);
                        highlightedTranscript += `<span class="error">${transcriptWords[i]}</span> `;
                    }
                }

                var score = Math.round((correctCount / comparisonWords.length) * 100);
                if (comparisonWords.length === 0) {
                    score = 0;
                }

                scoreDisplay.innerHTML = `
                    <strong>⭐ Điểm của bạn: ${score}%</strong><br>
                    ${errors.length > 0 ? `❌ Sai từ: ${errors.filter((val, index, self) => self.indexOf(val) === index).map(err => `<span class="error">${err}</span>`).join(', ')}` : "✅ Không có lỗi!"}
                `;

                textarea.innerHTML = highlightedTranscript.trim();
            }
        });

        class SpeechRecognitionApi {
            constructor(options) {
                const SpeechToText = window.speechRecognition || window.webkitSpeechRecognition;
                this.speechApi = new SpeechToText();
                this.speechApi.continuous = true;
                this.speechApi.interimResults = true;
                this.speechApi.lang = 'en-US';
                this.output = options.output ? options.output : document.createElement('div');
                this.speechApi.onresult = (event) => {
                    var resultIndex = event.resultIndex;
                    var transcript = event.results[resultIndex][0].transcript;
                    if (event.results[resultIndex].isFinal) {
                        this.output.textContent += transcript + ".\n";
                    }
                };
            }

            init() {
                this.speechApi.start();
            }

            stop() {
                this.speechApi.stop();
            }
        }
    </script>
</body>
</html>