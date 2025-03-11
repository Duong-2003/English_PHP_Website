<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karaoke Học Hát và Chấm Điểm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f8ff;
        }

        .lyrics {
            font-size: 24px;
            text-align: center;
            margin-top: 20px;
        }

        .highlight {
            color: red;
            font-weight: bold;
        }

        .canvas-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        canvas {
            width: 100%;
            max-width: 600px;
            height: 200px;
            border: 1px solid #000;
        }

        video {
            width: 100%;
            max-width: 600px;
            height: 500px;
            object-fit: cover;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Karaoke Học Hát và Chấm Điểm</h1>
    <video id="video" controls>
        <source src="../../English_PHP_Website/admin/assets/audio/iLoveTik.com_TikTok_Media_001_5088ad13e10494070d6c90785e1d5005.mp4" type="video/mp4">
        Trình duyệt của bạn không hỗ trợ thẻ video.
    </video>

    <button id="startSinging" class="btn btn-primary mt-3">Bắt đầu hát</button>
    <button id="stopSinging" class="btn btn-danger mt-3" disabled>Ngừng hát</button>
    <button id="replay" class="btn btn-secondary mt-3" disabled>Hát lại</button>
    <div id="score" class="mt-3">Điểm: 0</div>
    <div id="detailedScore" class="mt-3"></div> <!-- Hiển thị điểm chi tiết -->
    <div id="feedback" class="mt-3"></div> <!-- Phản hồi cho người dùng -->

    <div class="canvas-container">
        <canvas id="musicCanvas"></canvas>
        <canvas id="voiceCanvas"></canvas>
    </div>

    <div class="lyrics" id="lyrics">
        <div class="line">
            <p id="line1">Nỗi nhớ em trong đêm thật dài</p>
            <button class="edit-btn" onclick="editLyrics('line1')">Sửa</button>
        </div>
        <div class="line">
            <p id="line2">Thêm lý do cho anh tồn tại</p>
            <button class="edit-btn" onclick="editLyrics('line2')">Sửa</button>
        </div>
        <div class="line">
            <p id="line3">Để lại chạm vào bờ môi ấy dịu dàng</p>
            <button class="edit-btn" onclick="editLyrics('line3')">Sửa</button>
        </div>
        <div class="line">
            <p id="line4">Lời thì thầm ngọt ngào bên tai</p>
            <button class="edit-btn" onclick="editLyrics('line4')">Sửa</button>
        </div>
        <div class="line">
            <p id="line5">Ta mất nhau thật rồi em ơi</p>
            <button class="edit-btn" onclick="editLyrics('line5')">Sửa</button>
        </div>
        <div class="line">
            <p id="line6">Tan vỡ hai cực đành chia đôi</p>
            <button class="edit-btn" onclick="editLyrics('line6')">Sửa</button>
        </div>
        <div class="line">
            <p id="line7">Anh sẽ luôn ghi nhớ em trong từng tế bào</p>
            <button class="edit-btn" onclick="editLyrics('line7')">Sửa</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const video = document.getElementById('video');
        const startSingingButton = document.getElementById('startSinging');
        const stopSingingButton = document.getElementById('stopSinging');
        const replayButton = document.getElementById('replay');
        const scoreDiv = document.getElementById('score');
        const detailedScoreDiv = document.getElementById('detailedScore');
        const feedbackDiv = document.getElementById('feedback');
        const musicCanvas = document.getElementById('musicCanvas');
        const voiceCanvas = document.getElementById('voiceCanvas');
        const ctxMusic = musicCanvas.getContext('2d');
        const ctxVoice = voiceCanvas.getContext('2d');

        let mediaRecorder;
        let audioChunks = [];
        let isSinging = false;
        let audioContext, analyser, musicAnalyser;
        let totalScore = 0; 
        const noteScores = { "A": 0, "B": 0, "C": 0, "D": 0, "E": 0, "F": 0, "G": 0 };
        const noteFrequencies = { "A": 440.00, "B": 493.88, "C": 261.63, "D": 293.66, "E": 329.63, "F": 349.23, "G": 392.00 };

        const lyricsTiming = [
            { text: "Nỗi nhớ em trong đêm thật dài", time: 0, note: "A" },
            { text: "Thêm lý do cho anh tồn tại", time: 3, note: "B" },
            { text: "Để lại chạm vào bờ môi ấy dịu dàng", time: 7, note: "C" },
            { text: "Lời thì thầm ngọt ngào bên tai", time: 11, note: "D" },
            { text: "Ta mất nhau thật rồi em ơi", time: 15, note: "E" },
            { text: "Tan vỡ hai cực đành chia đôi", time: 19, note: "F" },
            { text: "Anh sẽ luôn ghi nhớ em trong từng tế bào", time: 23, note: "G" }
        ];

        startSingingButton.addEventListener('click', async () => {
            const micStream = await navigator.mediaDevices.getUserMedia({ audio: true });
            mediaRecorder = new MediaRecorder(micStream);

            audioContext = new (window.AudioContext || window.webkitAudioContext)();
            analyser = audioContext.createAnalyser();
            const micSource = audioContext.createMediaStreamSource(micStream);
            micSource.connect(analyser);
            musicAnalyser = audioContext.createAnalyser();
            const musicSource = audioContext.createMediaElementSource(video);
            musicSource.connect(musicAnalyser);
            musicSource.connect(audioContext.destination);

            mediaRecorder.ondataavailable = event => {
                audioChunks.push(event.data);
            };

            mediaRecorder.onstop = () => {
                const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                audioChunks = [];
            };

            mediaRecorder.start();
            video.play();
            isSinging = true;
            startSingingButton.disabled = true;
            stopSingingButton.disabled = false;
            replayButton.disabled = true;

            requestAnimationFrame(update);
        });

        stopSingingButton.addEventListener('click', () => {
            mediaRecorder.stop();
            video.pause();
            isSinging = false;
            startSingingButton.disabled = false;
            stopSingingButton.disabled = true;
            replayButton.disabled = false;
            scoreDiv.innerText = `Điểm: ${totalScore.toFixed(2)}`;
            displayDetailedScore();
            provideFeedback();
        });

        replayButton.addEventListener('click', () => {
            video.currentTime = 0; 
            totalScore = 0; 
            scoreDiv.innerText = 'Điểm: 0'; 
            detailedScoreDiv.innerHTML = ''; // Reset detailed score display
            feedbackDiv.innerHTML = ''; // Reset feedback display
            replayButton.disabled = true; 
            startSingingButton.disabled = false; 
        });

        function update() {
            if (isSinging) {
                const currentTime = video.currentTime;
                lyricsTiming.forEach((line, index) => {
                    const lineElement = document.getElementById(`line${index + 1}`);
                    if (currentTime >= line.time && currentTime < (line.time + 4)) {
                        lineElement.classList.add('highlight');
                        const voiceFrequency = getAverageFrequency(analyser);
                        if (noteScores[line.note] === 0) { 
                            const score = calculateScoreForLine(line.note, voiceFrequency);
                            noteScores[line.note] = score; 
                            totalScore += score; 
                        }
                    } else {
                        lineElement.classList.remove('highlight');
                    }
                });

                const musicDataArray = new Uint8Array(musicAnalyser.frequencyBinCount);
                musicAnalyser.getByteFrequencyData(musicDataArray);
                drawFrequencyBars(ctxMusic, musicDataArray);

                const voiceDataArray = new Uint8Array(analyser.frequencyBinCount);
                analyser.getByteFrequencyData(voiceDataArray);
                drawFrequencyBars(ctxVoice, voiceDataArray);
            }
            requestAnimationFrame(update);
        }

        function getAverageFrequency(analyser) {
            const dataArray = new Uint8Array(analyser.frequencyBinCount);
            analyser.getByteFrequencyData(dataArray);
            const maxIndex = dataArray.indexOf(Math.max(...dataArray));
            const frequency = maxIndex * (audioContext.sampleRate / 2) / dataArray.length;
            return frequency.toFixed(2);
        }

        function drawFrequencyBars(ctx, dataArray) {
            ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
            const barWidth = (ctx.canvas.width / dataArray.length) * 2.5;
            for (let i = 0; i < dataArray.length; i++) {
                const barHeight = dataArray[i] / 2;
                ctx.fillStyle = `rgb(${barHeight + 100},50,50)`;
                ctx.fillRect(i * barWidth, ctx.canvas.height - barHeight, barWidth, barHeight);
            }
        }

        function calculateScoreForLine(note, voiceFrequency) {
            const targetFrequency = noteFrequencies[note];
            const range = 30;
            let lineScore = 0;

            if (voiceFrequency >= (targetFrequency - range) && voiceFrequency <= (targetFrequency + range)) {
                lineScore = 14.29; // Nốt hoàn hảo
            } else if (voiceFrequency >= (targetFrequency - 2 * range) && voiceFrequency < (targetFrequency - range)) {
                lineScore = 7.14; // Nốt yếu
            } else if (voiceFrequency > (targetFrequency + range) && voiceFrequency <= (targetFrequency + 2 * range)) {
                lineScore = -7.14; // Nốt vượt mức
            }

            return lineScore;
        }

        function displayDetailedScore() {
            detailedScoreDiv.innerHTML = ''; // Reset detailed score display
            for (const note in noteScores) {
                const score = noteScores[note];
                const scoreElement = document.createElement('p');
                scoreElement.innerText = `Nốt ${note}: ${score.toFixed(2)}`;
                detailedScoreDiv.appendChild(scoreElement);
            }
        }

        function provideFeedback() {
            feedbackDiv.innerHTML = ''; // Reset feedback display
            lyricsTiming.forEach((line, index) => {
                const lineElement = document.getElementById(`line${index + 1}`);
                const voiceFrequency = getAverageFrequency(analyser); // Tính tần số giọng hát
                const expectedFrequency = noteFrequencies[line.note];

                if (Math.abs(voiceFrequency - expectedFrequency) > 30) { // Nếu sai sót lớn
                    const feedbackElement = document.createElement('p');
                    feedbackElement.innerText = `Dòng '${line.text}' hát chưa chính xác. Cố gắng điều chỉnh tần số gần ${expectedFrequency}Hz.`;
                    feedbackDiv.appendChild(feedbackElement);
                }
            });
        }

        // Hàm chỉnh sửa lời bài hát
        window.editLyrics = function(lineId) {
            const lineElement = document.getElementById(lineId);
            const originalText = lineElement.innerText;
            const newText = prompt("Nhập lại lời bài hát:", originalText);
            if (newText !== null) {
                lineElement.innerText = newText; // Cập nhật lời bài hát
            }
        }
    });
</script>

</body>
</html>