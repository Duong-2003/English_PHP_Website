<?php
session_start();
include '../config/conn.php';

// Lấy danh sách bài hát từ CSDL (ví dụ bảng songs có các trường: id, title, video_file, lyrics)
$sql = "SELECT * FROM songs";
$result = $conn->query($sql);
$songs = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $songs[] = $row;
    }
}

// Xác định bài hát cần phát theo tham số GET, nếu không chọn thì mặc định bài hát đầu tiên
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
    <title>Play Karaoke – Video</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
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
            color: red; /* Highlight the current lyric */
        }
    </style>
</head>
<body>
    <h1><?php echo htmlspecialchars($song["title"]); ?></h1>
    
    <!-- Chọn bài hát -->
    <form method="GET" class="mb-3">
        <select name="id" onchange="this.form.submit()">
            <?php foreach ($songs as $s): ?>
                <option value="<?php echo $s['id']; ?>" <?php echo ($s['id'] == $song_id) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($s['title']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>
    
    <!-- Nhúng video (nếu có) -->
    <div id="mediaPlayer" class="mb-4">
        <?php if (!empty($song["video_file"])): ?>
            <?php 
                // Chuyển đổi URL video thành dạng nhúng (giả sử video_file chứa URL YouTube)
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
                echo '<iframe width="500" height="281" src="' . $embedUrl . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
            ?>
        <?php else: ?>
            <p>Không có video</p>
        <?php endif; ?>
    </div>
    
    <!-- Hiển thị lời bài hát -->
    <div class="lyrics-container" id="lyrics">
        <?php 
        // Tạo các phần lời với data-time
        $lyrics = explode("\n", $song["lyrics"]); 
        foreach ($lyrics as $index => $line) {
            $time = $index * 5; // Giả sử mỗi câu lời có thời gian khoảng 5s
            echo '<p data-time="' . $time . '">' . htmlspecialchars($line) . '</p>';
        }
        ?>
    </div>
    
    <!-- Nút ghi âm và chấm điểm -->
    <button class="record-btn" id="recordBtn">Bắt đầu ghi âm & Chấm điểm</button>
    
    <!-- Hiển thị điểm -->
    <div class="score" id="scoreDisplay"></div>
    
    <script src="https://www.youtube.com/iframe_api"></script>
    <script>
        let player; // Đối tượng YouTube Player
        let lyrics = document.getElementById("lyrics").children;

        function onYouTubeIframeAPIReady() {
            player = new YT.Player('mediaPlayer', {
                height: '281',
                width: '500',
                videoId: getYoutubeVideoId(), // ID của video YouTube, bạn có thể lấy từ CSDL
                events: {
                    'onStateChange': onPlayerStateChange
                }
            });
        }

        // Khi video thay đổi trạng thái (ví dụ như video đang chạy)
        function onPlayerStateChange(event) {
            if (event.data == YT.PlayerState.PLAYING) {
                console.log("Video đang chạy");
            }
        }

        // Chạy video từ đầu
        function playVideo() {
            player.seekTo(0); // Quay lại từ đầu
            player.playVideo();
        }

        // Đồng bộ lời bài hát với video
        function syncLyricsWithVideo() {
            const currentTime = player.getCurrentTime(); // Lấy thời gian hiện tại trong video

            for (let i = 0; i < lyrics.length; i++) {
                const lyricTime = parseFloat(lyrics[i].getAttribute("data-time"));
                if (currentTime >= lyricTime) {
                    lyrics[i].classList.add("highlight"); // Hiển thị lời đang hát
                } else {
                    lyrics[i].classList.remove("highlight");
                }
            }
        }

        // Hàm thực hiện đồng bộ lyrics với video mỗi 100ms
        setInterval(syncLyricsWithVideo, 100);

        let isRecording = false;

        // Hàm xử lý bắt đầu ghi âm
        document.getElementById("recordBtn").addEventListener("click", function() {
            if (!isRecording) {
                // Bắt đầu ghi âm
                recorder.start();
                isRecording = true;
                document.getElementById("recordBtn").textContent = "Đang ghi âm...";

                // Sau 5 giây, dừng ghi âm và bắt đầu phân tích
                setTimeout(function() {
                    recorder.stop();
                    isRecording = false;
                    document.getElementById("recordBtn").textContent = "Bắt đầu ghi âm lại";
                }, 5000); // Ghi âm trong 5 giây
            }
        });
    </script>
</body>
</html>
