<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dino English Translate</title>
    <link rel="icon" type="image/x-icon" href="images/icons/dino.png">

    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<?php 
session_start(); // Bắt đầu session
ob_start(); // Start output buffering
include('../config/conn.php'); // Kết nối database
include('../src/font/learn_english/header_english.php');
?>
<body class="bg-gray-100">

<div class="container mt-10">
    <div class="bg-white p-6 rounded-xl shadow-md w-full max-w-xl mx-auto">
        <h2 class="text-center text-2xl font-semibold text-gray-700">🌍 Dino English Translate</h2>
        
        <!-- Input & Button -->
        <div class="mt-5">
            <div class="flex border border-gray-300 rounded-full p-2 shadow-sm">
                <input id="inputText" type="text" class="w-full outline-none px-4 text-lg" placeholder="Nhập văn bản...">
                <button id="translateButton" class="bg-blue-500 text-white px-5 py-2 rounded-full hover:bg-blue-600">Dịch</button>
            </div>
        </div>

        <!-- Kết quả dịch -->
        <div id="translationResult" class="mt-5 text-lg text-gray-700 font-medium p-3 bg-gray-200 rounded-lg min-h-[50px]">
            Kết quả sẽ hiển thị ở đây...
        </div>

        <!-- Button Lưu từ -->
        <div class="mt-3 text-center">
            <button id="saveWordButton" class="bg-green-500 text-white px-5 py-2 rounded-full hover:bg-green-600">
                Lưu từ <i class="fa fa-save"></i>
            </button>
        </div>
        
        <!-- Button Nghe từ -->
        <div class="mt-3 text-center">
            <button id="listenButton" class="bg-yellow-500 text-white px-5 py-2 rounded-full hover:bg-yellow-600">
                Nghe từ <i class="fa fa-volume-up"></i>
            </button>
        </div>

        <div class="mt-3 text-center">
            <button id="" class="bg-green-500 text-white px-5 py-2 rounded-full hover:bg-green-600">
             <a href="../project/save_word.php" class=" text-white px-4 py-2 rounded-lg ">🔙 Sang trang lưu từ</a>
            </button>
        </div>

        <!-- Logo -->
        <div class="flex justify-center mt-6">
            <img src="../public/images/icons/logo-dino-full-01.png" alt="Dino Image" class="h-32">
        </div>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("translateButton").addEventListener("click", async function () {
        const textToTranslate = document.getElementById("inputText").value.trim();

        if (!textToTranslate) {
            document.getElementById("translationResult").innerText = "⚠️ Vui lòng nhập văn bản để dịch!";
            return;
        }

        try {
            const response = await fetch("https://translate.googleapis.com/translate_a/single?client=gtx&sl=vi&tl=en&dt=t&q=" + encodeURIComponent(textToTranslate));
            const data = await response.json();
            
            // Lấy kết quả dịch
            const translatedText = data[0].map(item => item[0]).join("");
            document.getElementById("translationResult").innerText = translatedText;
        } catch (error) {
            document.getElementById("translationResult").innerText = "⚠️ Có lỗi xảy ra trong quá trình dịch.";
        }
    });

    // Lưu từ vào save_word.php
    document.getElementById("saveWordButton").addEventListener("click", async function () {
        const originalText = document.getElementById("inputText").value.trim();
        const translatedText = document.getElementById("translationResult").innerText.trim();

        if (!originalText || !translatedText) {
            alert("⚠️ Không có dữ liệu để lưu!");
            return;
        }

        try {
            const response = await fetch("save_word.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `original=${encodeURIComponent(originalText)}&translated=${encodeURIComponent(translatedText)}`
            });

            if (response.ok) {
                alert("✅ Từ đã được lưu thành công!");
            } else {
                alert("⚠️ Có lỗi khi lưu từ!");
            }
        } catch (error) {
            alert("⚠️ Không thể kết nối đến máy chủ!");
        }
    });

    // Nghe từ đã dịch bằng Web Speech API
    document.getElementById("listenButton").addEventListener("click", function () {
        const translatedText = document.getElementById("translationResult").innerText.trim();

        if (!translatedText) {
            alert("⚠️ Không có từ nào để phát âm!");
            return;
        }

        const utterance = new SpeechSynthesisUtterance(translatedText);
        utterance.lang = 'en-US'; // Ngôn ngữ phát âm
        speechSynthesis.speak(utterance);
    });
});
</script>

</body>
</html>