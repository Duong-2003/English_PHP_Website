<?php
session_start();
include '../config/conn.php';

// Kiểm tra kết nối CSDL
if ($conn->connect_error) {
    error_log("Lỗi kết nối CSDL: " . $conn->connect_error);
    die("Lỗi server. Vui lòng thử lại sau.");
}

// Lấy danh sách bài hát từ CSDL
$sql = "SELECT * FROM songs";
$result = $conn->query($sql);
$songs = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $songs[] = $row;
    }
}

// Xác định bài hát cần phát
$song_id = isset($_GET['id']) ? intval($_GET['id']) : (isset($songs[0]['id']) ? $songs[0]['id'] : 0);
$song = null;
foreach ($songs as $s) {
    if ($s['id'] == $song_id) {
        $song = $s;
        break;
    }
}
if (!$song) {
    die("Không tìm thấy bài hát.");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chơi Karaoke – Video</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.webrtc-experiment.com/RecordRTC.js"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            text-align: center;
            padding: 20px;
        }
        .lyrics-container {
            margin-top: 20px;
            font-size: 20px;
            color: gray;
            font-weight: 500;
        }
        .score {
            font-size: 24px;
            font-weight: 500;
            color: green;
            margin-top: 20px;
        }
        .record-btn {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 18px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .highlight {
            color: red;
        }
    </style>
</head>
<body>
    <h1><?php echo htmlspecialchars($song["title"]); ?></h1>

    <form method="GET" class="mb-3">
        <select name="id" onchange="this.form.submit()">
            <?php foreach ($songs as $s): ?>
                <option value="<?php echo $s['id']; ?>" <?php echo ($s['id'] == $song_id) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($s['title']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <div id="mediaPlayer" class="mb-4">
        <?php if (!empty($song["video_file"])): ?>
            <?php
            function getYoutubeEmbedUrl($url) {
                if (strpos($url, "youtu.be") !== false) {
                    $parts = explode("/", $url);
                    $id = end($parts);
                    return "https://www.youtube.com/embed/" . $id;
                }
                if (strpos($url, "youtube.com/watch?v=") !== false) {
                    parse_str(parse_url($url, PHP_URL_QUERY), $query);
                    if (isset($query['v'])) {
                        return "https://www.youtube.com/embed/" . $query['v'];
                    }
                }
                return $url;
            }
            $embedUrl = getYoutubeEmbedUrl($song["video_file"]);
            echo '<iframe id="youtube-player" width="500" height="281" src="' . $embedUrl . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
            ?>
        <?php else: ?>
            <p>Không có video</p>
        <?php endif; ?>
    </div>

    <div class="lyrics-container" id="lyrics">
        <?php
        $lyrics = explode("\n", $song["lyrics"]);
        foreach ($lyrics as $index => $line) {
            $time = $index * 5; // Giả sử mỗi câu lời có thời gian khoảng 5 giây
            echo '<p class="lyric-line" data-time="' . $time . '">' . htmlspecialchars($line) . '</p>';
        }
        ?>
    </div>

    <button class="record-btn" id="recordBtn">Bắt đầu ghi âm</button>
    <button class="record-btn" id="stopBtn" style="display:none">Dừng ghi âm</button>
    <button class="record-btn" id="toggleMicBtn">Bật microphone</button>

    <div class="score" id="scoreDisplay"></div>

    <script src="https://www.youtube.com/iframe_api"></script>
    <script>
        let player;
        let lyrics = document.querySelectorAll(".lyric-line");
        let isRecording = false;
        let recorder;
        let isMicOn = false; // Trạng thái bật/tắt microphone

        function onYouTubeIframeAPIReady() {
            player = new YT.Player('youtube-player', {
                height: '281',
                width: '500',
                videoId: getYoutubeVideoId(),
                events: {
                    'onStateChange': onPlayerStateChange
                }
            });
        }

        function onPlayerStateChange(event) {
            if (event.data === YT.PlayerState.PLAYING) {
                console.log("Video đang chạy");
            }
        }

        function getYoutubeVideoId() {
            const embedUrl = document.getElementById('youtube-player').src;
            const urlParams = new URLSearchParams(new URL(embedUrl).search);
            return urlParams.get('v') || embedUrl.split('/').pop().split('?')[0];
        }

        function syncLyricsWithVideo() {
            if (player && player.getCurrentTime) {
                const currentTime = player.getCurrentTime();
                lyrics.forEach(lyric => {
                    const lyricTime = parseFloat(lyric.getAttribute("data-time"));
                    const lyricEndTime = lyricTime + 5; // Giả định mỗi dòng kéo dài 5 giây
                    if (currentTime >= lyricTime && currentTime < lyricEndTime) {
                        lyric.classList.add("highlight");
                    } else {
                        lyric.classList.remove("highlight");
                    }
                });
            }
        }

        setInterval(syncLyricsWithVideo, 100);

        navigator.mediaDevices.getUserMedia({ audio: true })
            .then(function(stream) {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)({
                    sampleRate: 44100 // Đặt tần số mẫu
                });
                const source = audioContext.createMediaStreamSource(stream);
                const gainNode = audioContext.createGain();
                source.connect(gainNode);
                gainNode.connect(audioContext.destination); // Kết nối đến đầu ra âm thanh

                recorder = RecordRTC(stream, {
                    type: 'audio',
                    mimeType: 'audio/wav',
                    sampleRate: 44100 // Đặt tần số mẫu ở đây
                });

                document.getElementById("toggleMicBtn").addEventListener("click", function() {
                    isMicOn = !isMicOn;
                    gainNode.gain.value = isMicOn ? 1 : 0; // Điều chỉnh âm lượng microphone
                    this.innerText = isMicOn ? "Tắt microphone" : "Bật microphone";
                });
            })
            .catch(function(error) {
                console.error('Không thể truy cập microphone:', error);
            });

        document.getElementById("recordBtn").addEventListener("click", function() {
            if (!isRecording && recorder) {
                player.playVideo(); // Bắt đầu phát video
                recorder.startRecording();
                isRecording = true;
                this.style.display = 'none';
                document.getElementById('stopBtn').style.display = 'inline-block';
            }
        });

        document.getElementById("stopBtn").addEventListener("click", async function() {
            if (isRecording && recorder) {
                recorder.stopRecording(async function() {
                    let blob = recorder.getBlob();
                    const formData = new FormData();
                    formData.append('audio', blob, 'recording.wav');

                    try {
                        const response = await fetch('upload.php', {
                            method: 'POST',
                            body: formData
                        });
                        const data = await response.json();
                        if (data.error) {
                            console.error("Lỗi server:", data.error);
                            alert("Lỗi server: " + data.error);
                            return;
                        }
                        document.getElementById("scoreDisplay").innerText = "Điểm: " + data.score;
                        displayErrors(data.errors);
                    } catch (error) {
                        console.error('Lỗi khi gửi âm thanh:', error);
                        alert("Lỗi khi gửi âm thanh: " + error.message);
                    }

                    isRecording = false;
                    document.getElementById("recordBtn").style.display = 'inline-block';
                    document.getElementById('stopBtn').style.display = 'none';
                });
            }
        });

        function displayErrors(errors) {
            let lyricsElement = document.getElementById('lyrics');
            let lyricsHTML = lyricsElement.innerHTML;

            errors.forEach(error => {
                let regex = new RegExp(`\\b${error.word}\\b`, 'gi');
                lyricsHTML = lyricsHTML.replace(regex, `<span style="color: red;" title="Expected: ${error.expected}, Actual: ${error.actual}">${error.word}</span>`);
            });

            lyricsElement.innerHTML = lyricsHTML;
        }
    </script>
</body>
</html>