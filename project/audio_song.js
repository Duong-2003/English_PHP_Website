class SpeechRecognitionApi {
    constructor(options) {
        const SpeechToText = window.SpeechRecognition || window.webkitSpeechRecognition;
        this.speechApi = new SpeechToText();
        this.speechApi.continuous = true;
        this.speechApi.interimResults = true;
        this.speechApi.lang = 'en-US';
        this.output = options.output;
        this.comparisonLyrics = options.comparisonLyrics.toLowerCase().split('. '); // Chia lời bài hát theo câu
        this.transcripts = "";
        this.recognizedSentences = []; // Lưu trữ các câu đã nhận dạng
        this.score = 0;
        this.errors = [];
        this.currentSentenceIndex = 0;
    }

    init() {
        this.transcripts = "";
        this.recognizedSentences = [];
        this.score = 0;
        this.errors = [];
        this.currentSentenceIndex = 0;
        this.speechApi.start();
    }

    stop() {
        this.speechApi.stop();
        this.evaluatePerformance();
    }

    onResult(event) {
        for (let i = event.resultIndex; i < event.results.length; i++) {
            let transcript = event.results[i][0].transcript.toLowerCase();
            let isFinal = event.results[i].isFinal;

            if (isFinal) {
                this.transcripts += transcript + ". ";
                this.output.value = this.transcripts;
                this.recognizedSentences.push(transcript); // Lưu trữ câu đã nhận dạng
            }
        }
    }

    onError(event) {
        console.error("Lỗi: ", event.error);
        this.output.value = "Lỗi nhận diện giọng nói: " + event.error;
    }

    onEnd() {
        console.log("Nhận diện đã dừng.");
    }

    evaluatePerformance() {
        for (let i = 0; i < this.comparisonLyrics.length; i++) {
            if (this.recognizedSentences[i] && this.recognizedSentences[i].includes(this.comparisonLyrics[i])) {
                this.score++;
            } else {
                this.errors.push(this.comparisonLyrics[i]);
            }
        }
        this.updateScoreDisplay();
    }

    updateScoreDisplay() {
        const scoreDisplay = document.getElementById('score');
        if (scoreDisplay) {
            const percentage = Math.round((this.score / this.comparisonLyrics.length) * 100);
            scoreDisplay.innerHTML = `
                <strong>⭐ Điểm của bạn: ${percentage}%</strong><br>
                ${this.errors.length > 0 ? `❌ Sai câu: ${this.errors.map(err => `<span class="error">${err}</span>`).join(', ')}` : '✅ Không có lỗi!'}
            `;
        }
    }
}

window.onload = function() {
    const speech = new SpeechRecognitionApi({
        output: document.getElementById('textarea'),
        comparisonLyrics: document.getElementById('lyrics').getAttribute('data-lyrics')
    });

    speech.speechApi.onresult = (event) => speech.onResult(event);
    speech.speechApi.onerror = (event) => speech.onError(event);
    speech.speechApi.onend = () => speech.onEnd();

    document.querySelector('.btn-start').addEventListener('click', () => speech.init());
    document.querySelector('.btn-stop').addEventListener('click', () => speech.stop());
};