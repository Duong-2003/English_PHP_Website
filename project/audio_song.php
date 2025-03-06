<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trình Phát Nhạc</title>
    <style>
        /* Căn chỉnh và thiết kế cho giao diện */
        .mediaItemContainer--3BwC2 {
            max-width: 600px;
            margin: 0 auto;
        }

        .waveformContainer--MJW1W {
            height: 50px;
            background: #f0f0f0;
            position: relative;
        }

        .progressBar--Qyz-N {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: #007bff;
        }

        .playButton--gXsLw button {
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 50%;
        }

        .volumeBar--ntZoi input {
            width: 100%;
        }

        .footerSection--DnzP7 {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .volumeBtn--ucfQI {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="mediaItemContainer--3BwC2">
        <div class="titleSection--OI1oP">
            <h2>Danh Sách Bài Hát</h2>
            <div id="songList"></div>
        </div>

        <div class="waveformSection--fmXE8">
            <div class="waveformContainer--MJW1W">
                <div class="trackBar--XcykU">
                    <div class="progressBar--Qyz-N" style="width: 0%;"></div>
                </div>
            </div>
            <div class="waveformNumbers--droUf">0:00</div>
        </div>

        <div class="playButtonSection--LVOxN">
            <div class="playButton--gXsLw">
                <button class="playPauseButton" aria-label="Chơi / Tạm dừng">
                    <span class="playIcon">▶️</span>
                </button>
            </div>
        </div>

        <hr>

        <div class="footerSection--DnzP7">
            <div class="container--Qs3az">
                <button class="volumeBtn--ucfQI" aria-label="Âm lượng">
                    <span class="icon--L+lBh volume--s7R+A">🔊</span>
                </button>
                <div class="volumeBar--ntZoi">
                    <input type="range" min="0" max="1" step="0.01" value="1" aria-label="Âm lượng" class="volumeControl">
                </div>
            </div>
        </div>
    </div>

    <audio id="audioPlayer" preload="auto"></audio>

    <script>
        // Lấy danh sách bài hát từ server
        fetch('../project/get_songs.php')
            .then(response => response.json())
            .then(songs => {
                const songListDiv = document.getElementById('songList');
                songs.forEach(song => {
                    const songItem = document.createElement('div');
                    songItem.innerHTML = `<button onclick="playSong('${song.audio_file}', '${song.title}')">${song.title}</button>`;
                    songListDiv.appendChild(songItem);
                });
            })
            .catch(error => {
                console.error('Lỗi khi lấy danh sách bài hát:', error);
            });

        // Lấy các phần tử DOM
        const audio = document.getElementById('audioPlayer');
        const playPauseButton = document.querySelector('.playPauseButton');
        const volumeControl = document.querySelector('.volumeControl');
        const progressBar = document.querySelector('.progressBar--Qyz-N');
        const waveformNumbers = document.querySelector('.waveformNumbers--droUf');

        // Thực hiện chức năng Play / Pause
        playPauseButton.addEventListener('click', () => {
            if (audio.paused) {
                audio.play().catch(error => {
                    console.error('Lỗi khi phát âm thanh:', error);
                });
                playPauseButton.innerHTML = "⏸️";  // Biểu tượng tạm dừng
            } else {
                audio.pause();
                playPauseButton.innerHTML = "▶️";  // Biểu tượng phát
            }
        });

        // Điều chỉnh âm lượng
        volumeControl.addEventListener('input', (event) => {
            audio.volume = event.target.value;
        });

        // Cập nhật thanh tiến trình
        audio.addEventListener('timeupdate', () => {
            const progress = (audio.currentTime / audio.duration) * 100;
            progressBar.style.width = `${progress}%`;

            // Cập nhật thời gian
            const minutes = Math.floor(audio.currentTime / 60);
            const seconds = Math.floor(audio.currentTime % 60);
            waveformNumbers.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        });

        // Đảm bảo thanh tiến trình được cập nhật khi hoàn thành bài hát
        audio.addEventListener('ended', () => {
            progressBar.style.width = '0%';
            waveformNumbers.textContent = '0:00';
            playPauseButton.innerHTML = "▶️";  // Biểu tượng phát khi kết thúc
        });

        // Chơi bài hát
        function playSong(audioUrl, title) {
            audio.src = audioUrl;
            audio.play()
                .catch(error => {
                    console.error('Lỗi khi phát âm thanh:', error);
                });
            playPauseButton.innerHTML = "⏸️";  // Biểu tượng tạm dừng
        }
    </script>
</body>
</html>
