<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Learning English</title>
    <link rel="icon" type="image/x-icon" href="images/icons/dino.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<?php 
include('../src/font/learn_english/header_english.php');
?>
<body>

<div class="container mt-4 lg:mt-10">
    <div class="flex flex-col lg:flex-row lg:justify-between lg:gap-20 items-start">
        <div class="w-full lg:basis-1/4 shrink-0 mb-6 lg:mb-0 flex flex-col items-center pt-8">
            <div class="relative mb-4">
                <div class="h-24 w-24 rounded-full overflow-hidden">
                    <img alt="Guest Avatar" src="../public/images/icons/ic_default_ava_male.png" class="rounded-full w-full h-full object-cover">
                </div>
            </div>
            <div class="font-normal text-lg text-center text-gray-600 mb-3">Hãy đăng nhập để lưu tiến trình học của bạn</div>
        </div>

        <div class="overflow-hidden w-full lg:w-auto flex flex-col lg:grow">
            <div class="mb-6">
                <h3 class="text-2xl font-semibold text-gray-800 mb-2">Gần đây</h3>
                <div class="w-full flex flex-nowrap gap-3 my-4 overflow-auto profile-recent-scrollbar">
                    <div class="h-18 w-18 mb-2 aspect-square shrink-0 relative cursor-pointer">
                        <!-- <img alt="Chào hỏi" src="/_next/image?url=%2Fassets%2Fmedia%2Ftopic%2Fimage%2Fgreeting.png&amp;w=3840&amp;q=75" class="aspect-square shrink-0 w-full h-full object-cover"> -->
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-2xl font-semibold text-gray-800 mb-2">Tiến độ học</h3>
                <div class="text-xl flex justify-between items-center my-4">
                    <h4 class="font-medium">Tổng kinh nghiệm</h4>
                    <div class="text-yellow-500">0 exp</div>
                </div>
                <div class="h-px bg-gray-300"></div>
                <div class="text-xl flex justify-between items-center my-4">
                    <h4 class="font-medium">Chủ đề đã hoàn thành</h4>
                    <div class="text-blue-500">0<span>/30</span></div>
                </div>
                <div class="h-px bg-gray-300"></div>
                <div class="text-xl flex justify-between items-center my-4">
                    <h4 class="font-medium">Bài kiểm tra đã hoàn thành</h4>
                    <div class="text-red-500">0<span>/3</span></div>
                </div>
            </div>

            <div>
                <h3 class="text-2xl font-semibold text-gray-800 mb-2">Tài khoản</h3>
                <a href="https://accounts.google.com/o/oauth2/v2/auth/oauthchooseaccount?client_id=802722291334-lv4icb1pt0ooua8nhp5d0oldl0rh7953.apps.googleusercontent.com&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fdrive.appdata%20https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fdrive.file&response_type=code&redirect_uri=https%3A%2F%2Fdinoenglish.app%2Fapi%2Fauth%2Fcallback%2Fgoogle&prompt=consent&access_type=offline&state=WnAQwcBTbe7_i4LTwUwUgolgm6xTSaOosoBt5IrDn7I&code_challenge=ZpGic01x-XuBFjPnAIPy5WsnnQ_1YCfzpQ_zkK5ZDL0&code_challenge_method=S256&service=lso&o2v=2&ddm=1&flowName=GeneralOAuthFlow"><button class="text-xl font-medium my-4">Đăng nhập bằng Email/Tài khoản MXH</button></a>
            </div>
        </div>
    </div>
</div>

</body>
</html>