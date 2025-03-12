<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dino English Translate</title>
    <link rel="icon" type="image/x-icon" href="images/icons/dino.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

    <style>        
      

        .flashcard {
            width: 300px;
            height: 200px;
            perspective: 1000px;
            margin: 0 auto;
            margin-bottom: 20px;
        }

        .front, .back {
            width: 100%;
            height: 100%;
            position: absolute;
            backface-visibility: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: white;
        }

        .front {
            background-color: #007bff;
            color: white;
            font-size: 24px;
        }

        .back {
            transform: rotateY(180deg);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .flashcard.show-back .front {
            transform: rotateY(180deg);
        }

        .flashcard.show-back .back {
            transform: rotateY(0deg);
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }

        img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 8px;
        }
    </style>
</head>

<?php
session_start(); // Bắt đầu session
ob_start(); // Start output buffering
include('../config/conn.php'); // Kết nối database
include('../src/font/learn_english/header_english.php');


$sql = "SELECT * FROM flashcards"; 
$result = $conn->query($sql);
$flashcards = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $flashcards[] = $row;
    }
}

$conn->close();
?>

<body>
    <div class="container">
        <div class="flashcard" id="flashcard">
            <div class="front">
                <h2 id="word">Từ</h2>
            </div>
            <div class="back">
                <img id="image" src="" alt="Hình ảnh" />
            </div>
        </div>
        <button id="nextButton" class="btn btn-primary">Tiếp theo</button>
    </div>

    <script>
        const flashcards = <?php echo json_encode($flashcards); ?>;
        let currentCard = 0;
        const imageDirectory = '../admin/assets/images/'; // Đường dẫn đến thư mục hình ảnh

        const wordElement = document.getElementById("word");
        const imageElement = document.getElementById("image");
        const flashcard = document.getElementById("flashcard");
        const nextButton = document.getElementById("nextButton");

        function showCard() {
            if (flashcards.length > 0) {
                wordElement.textContent = flashcards[currentCard].word;
                imageElement.src = imageDirectory + flashcards[currentCard].image; // Sử dụng đường dẫn ảnh
                flashcard.classList.remove("show-back");
            } else {
                wordElement.textContent = "Không có từ nào để hiển thị.";
                imageElement.src = "";
            }
        }

        function showBack() {
            flashcard.classList.add("show-back");
        }

        nextButton.addEventListener("click", function() {
            if (flashcard.classList.contains("show-back")) {
                currentCard = (currentCard + 1) % flashcards.length;
                showCard();
            } else {
                showBack();
            }
        });

        flashcard.addEventListener("click", function() {
            if (flashcard.classList.contains("show-back")) {
                flashcard.classList.remove("show-back");
            } else {
                showBack();
            }
        });

        // Hiển thị thẻ đầu tiên
        showCard();
    </script>
</body>
</html>