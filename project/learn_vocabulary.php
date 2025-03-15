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
<?php
session_start(); // Bắt đầu session
ob_start(); // Start output buffering
include('../config/conn.php'); // Kết nối database
include('../src/font/learn_english/header_english.php');
?>

<?php
include('../config/conn.php');

$topic = isset($_GET['topic']) ? $_GET['topic'] : 'default_topic';

$query = $conn->prepare("SELECT * FROM vocabulary WHERE topic = ?");
$query->bind_param("s", $topic);
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trò Chơi Từ Vựng - <?php echo htmlspecialchars($topic); ?></title>

    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; color: #333; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .card { background-color: #fff; border-radius: 8px; padding: 20px; transition: transform 0.2s; }
        .card:hover { transform: scale(1.05); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); }
        .choices { margin-top: 15px; display: flex; flex-wrap: wrap; justify-content: center; } /* Thay đổi tại đây */
        .choice-img { margin: 5px; cursor: pointer; border: 2px solid transparent; border-radius: 8px; transition: border-color 0.3s; width: 100px; height: 100px; object-fit: cover; } /* Thay đổi tại đây */
        .choice-img:hover { border-color: #007bff; }
        .correct-answer { display: none; margin-top: 10px; font-weight: bold; color: green; }
        .choice-correct { border-color: green; }
        .choice-wrong { border-color: red; }
        .result-message { margin-top: 10px; font-weight: bold; }
        .result-correct { color: green; }
        .result-wrong { color: red; }
    </style>
</head>
<body>
    <div class="container my-6">
        <h2 class="text-center">Trò Chơi Từ Vựng - <?php echo htmlspecialchars($topic); ?></h2>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-6 mb-6">
                    <div class="card p-4 border border-colorGrey3/70 shadow-sm">
                        <h3 class="font-medium text-xl"><?php echo htmlspecialchars($row['word']); ?></h3>
                        <div class="choices">
                            <?php
                            $imageDirectory = '../admin/assets/images/';
                            $images = glob($imageDirectory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

                            if ($images) {
                                shuffle($images);
                                $choices = array_slice($images, 0, 4);
                                $correct_image = $row['correct_choice'];

                                foreach ($choices as $image) {
                                    $imageName = basename($image);
                                    echo '<img src="' . htmlspecialchars($image) . '" alt="' . htmlspecialchars($imageName) . '" class="choice-img" data-choice="' . htmlspecialchars($imageName) . '">';
                                }
                            } else {
                                echo '<p>Không có hình ảnh nào trong thư mục.</p>';
                            }
                            ?>
                        </div>
                        <span class="correct-answer" data-answer="<?php echo htmlspecialchars($row['correct_choice']); ?>">Đáp án đúng là: <?php echo htmlspecialchars($row['correct_choice']); ?></span>
                        <span class="result-message"></span>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script>
        document.querySelectorAll('.choice-img').forEach(button => {
            button.addEventListener('click', function() {
                const correctAnswerSpan = this.closest('.card').querySelector('.correct-answer');
                const correctAnswer = correctAnswerSpan.dataset.answer;
                const userChoice = this.dataset.choice;
                const choices = this.closest('.choices').querySelectorAll('.choice-img');
                const resultMessage = this.closest('.card').querySelector('.result-message');

                choices.forEach(choice => {
                    choice.classList.remove('choice-correct', 'choice-wrong');
                });

                if (userChoice === correctAnswer) {
                    this.classList.add('choice-correct');
                    resultMessage.textContent = 'Đúng rồi!';
                    resultMessage.classList.add('result-correct');
                    resultMessage.classList.remove('result-wrong');
                } else {
                    this.classList.add('choice-wrong');
                    resultMessage.textContent = 'Sai rồi!';
                    resultMessage.classList.add('result-wrong');
                    resultMessage.classList.remove('result-correct');
                }

                correctAnswerSpan.style.display = 'block';
            });
        });
    </script>
</body>
</html>