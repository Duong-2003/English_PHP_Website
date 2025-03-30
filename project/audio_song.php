<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Karaoke Speech to Text</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        .output {
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 20px;
            width: 300px;
            height: 150px;
            overflow-y: auto;
            margin-left: auto;
            margin-right: auto;
            background: #f9f9f9;
        }
        .btn-start, .btn-stop {
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
    </style>
</head>
<body>
    <h1>Karaoke Speech to Text</h1>
    <button class="btn-start">Bắt đầu</button>
    <button class="btn-stop">Dừng</button>
    <textarea class="output" id="textarea" cols="30" rows="10" readonly></textarea>
    <div id="score"></div>
    <div id="lyrics" data-lyrics="  Head, shoulders, knees and toes, knees and toes
                                    Head, shoulders, knees and toes, knees and toes
                                    And eyes and ears and mouth and nose
                                    Head, shoulders, knees and toes, knees and toes"></div>
    <script src="./audio_song.js"></script>
</body>
</html>