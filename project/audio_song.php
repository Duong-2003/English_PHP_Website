<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karaoke App with Accurate Scoring</title>
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
            justify-content: center;
            margin-top: 20px;
        }
        canvas {
            width: 100%;
            max-width: 600px;
            height: 200px;
            border: 1px solid #000;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Karaoke App with Accurate Scoring</h1>
    <audio id="audio" controls>
        <source src="../admin/assets/audio/Pienso Viento - Casa Rosa.mp3" type="audio/mpeg">
        Your browser does not support the audio tag.
    </audio>

    <button id="startSinging" class="btn btn-primary mt-3">Bắt đầu hát</button>
    <button id="stopSinging" class="btn btn-danger mt-3" disabled>Ngừng hát</button>
    <div id="score" class="mt-3"></div>

    <div class="frequency-display">
        <div id="musicFrequency">Tần số nhạc: 0 Hz</div>
        <div id="voiceFrequency">Tần số giọng: 0 Hz</div>
    </div>

    <div class="canvas-container">
        <canvas id="frequencyCanvas"></canvas>
    </div>

    <div class="lyrics" id="lyrics">
        <p id="line1">Lời bài hát 1</p>
        <p id="line2">Lời bài hát 2</p>
        <p id="line3">Lời bài hát 3</p>
        <p id="line4">Lời bài hát 4</p>
    </div>
</div>

<script>
const audio = document.getElementById('audio');
const startSingingButton = document.getElementById('startSinging');
const stopSingingButton = document.getElementById('stopSinging');
const scoreDiv = document.getElementById('score');
const musicFrequencyDiv = document.getElementById('musicFrequency');
const voiceFrequencyDiv = document.getElementById('voiceFrequency');
const canvas = document.getElementById('frequencyCanvas');
const ctx = canvas.getContext('2d');

let mediaRecorder;
let audioChunks = [];
let isSinging = false;
let audioContext, analyser, micStream, musicAnalyser;

// Tần số âm tiết của bài hát (cần thay đổi cho đúng)
const noteFrequencies = [
    { note: "Lời bài hát 1", frequency: 440 }, // Tần số cho âm tiết 1
    { note: "Lời bài hát 2", frequency: 494 }, // Tần số cho âm tiết 2
    { note: "Lời bài hát 3", frequency: 523 }, // Tần số cho âm tiết 3
    { note: "Lời bài hát 4", frequency: 587 }  // Tần số cho âm tiết 4
];

startSingingButton.addEventListener('click', async () => {
    micStream = await navigator.mediaDevices.getUserMedia({ audio: true });
    mediaRecorder = new MediaRecorder(micStream);
    
    audioContext = new (window.AudioContext || window.webkitAudioContext)();
    
    // Analyser cho micro
    analyser = audioContext.createAnalyser();
    const micSource = audioContext.createMediaStreamSource(micStream);
    micSource.connect(analyser);
    
    // Analyser cho nhạc
    musicAnalyser = audioContext.createAnalyser();
    const musicSource = audioContext.createMediaElementSource(audio);
    musicSource.connect(musicAnalyser);
    musicSource.connect(audioContext.destination);

    mediaRecorder.ondataavailable = event => {
        audioChunks.push(event.data);
    };

    mediaRecorder.onstop = () => {
        const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
        const audioUrl = URL.createObjectURL(audioBlob);
        const audioElement = new Audio(audioUrl);
        audioElement.play();
        audioChunks = [];
        calculateScore();
    };

    mediaRecorder.start();
    audio.play();
    isSinging = true;
    startSingingButton.disabled = true;
    stopSingingButton.disabled = false;

    requestAnimationFrame(update);
});

stopSingingButton.addEventListener('click', () => {
    mediaRecorder.stop();
    audio.pause();
    isSinging = false;
    startSingingButton.disabled = false;
    stopSingingButton.disabled = true;
});

const lyrics = [
    { text: "Lời bài hát 1", time: 0 },
    { text: "Lời bài hát 2", time: 3 },
    { text: "Lời bài hát 3", time: 6 },
    { text: "Lời bài hát 4", time: 9 }
];

function update() {
    if (isSinging) {
        const currentTime = audio.currentTime;
        lyrics.forEach((line, index) => {
            const lineElement = document.getElementById(`line${index + 1}`);
            if (currentTime >= line.time && currentTime < (line.time + 3)) {
                lineElement.classList.add('highlight');
            } else {
                lineElement.classList.remove('highlight');
            }
        });
        
        // Phân tích tần số âm thanh từ nhạc
        const musicDataArray = new Uint8Array(musicAnalyser.frequencyBinCount);
        musicAnalyser.getByteFrequencyData(musicDataArray);
        const musicFrequency = getAverageFrequency(musicDataArray);
        musicFrequencyDiv.innerText = `Tần số nhạc: ${musicFrequency} Hz`;

        // Phân tích tần số âm thanh từ micro
        const voiceDataArray = new Uint8Array(analyser.frequencyBinCount);
        analyser.getByteFrequencyData(voiceDataArray);
        const voiceFrequency = getAverageFrequency(voiceDataArray);
        voiceFrequencyDiv.innerText = `Tần số giọng: ${voiceFrequency} Hz`;

        // Vẽ biểu đồ tần số
        drawFrequencyBars(voiceDataArray);

        // Tính điểm dựa trên tần số giọng hát và âm tiết
        const score = calculateScore(voiceFrequency);
        scoreDiv.innerText = `Điểm hát: ${score}`;
    }
    requestAnimationFrame(update);
}

function getAverageFrequency(dataArray) {
    const sum = dataArray.reduce((acc, val) => acc + val, 0);
    return (sum / dataArray.length).toFixed(2);
}

function drawFrequencyBars(dataArray) {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    const barWidth = (canvas.width / dataArray.length) * 2.5;
    let barHeight;

    for (let i = 0; i < dataArray.length; i++) {
        barHeight = dataArray[i] / 2; // Tỉ lệ để bar không quá cao
        ctx.fillStyle = `rgb(${barHeight + 100},50,50)`;
        ctx.fillRect(i * barWidth, canvas.height - barHeight, barWidth, barHeight);
    }
}

function calculateScore(voiceFrequency) {
    let score = 0;
    const threshold = 50; // Ngưỡng để tính điểm

    noteFrequencies.forEach(note => {
        // So sánh tần số giọng hát với tần số của âm tiết
        if (Math.abs(note.frequency - voiceFrequency) < threshold) {
            score += 25; // Tăng điểm cho mỗi âm tiết gần nhau
        }
    });

    return Math.min(score, 100); // Giới hạn điểm số tối đa là 100
}
</script>

</body>
</html>