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

<div class="container h-auto flex flex-col lg:flex-row justify-between mt-8">
    <div class="w-full lg:w-[54%] mb-12 lg:mb-0">
        <div class="mb-8 lg:mb-12">
            <h3 class="text-2xl font-semibold text-gray-800 mb-2">Khóa học</h3>
            <div class="flex justify-between items-center">
                <h4 class="text-xl font-medium">Ngôn ngữ khóa học</h4>
                <div class="relative">
                    <div>
                        <div class="bg-gray-200 h-10 p-2 flex items-center justify-between w-40 text-md text-black rounded-full cursor-pointer hover:bg-gray-300 duration-100 ease-out">
                            <div class="flex h-full">
                                <img src="../public/images/icons/vi.png" alt="Tiếng Việt" class="h-full mr-2">
                                <span>Tiếng Việt</span>
                            </div>
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 320 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path d="M143 352.3L7 216.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0l96.4 96.4 96.4-96.4c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9l-136 136c-9.2 9.4-24.4 9.4-33.8 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute w-max z-50 hidden transition-opacity duration-120 ease-in-out">
                        <div class="bg-white w-48 shadow-lg border border-gray-300 rounded-md py-2">
                            <div class="px-4 py-2 flex items-center text-base hover:bg-gray-200 cursor-pointer">
                                <img src="../public/images/icons/ja.png" alt="Japanese" class="h-6 mr-2"><span>Japanese</span>
                            </div>
                            <div class="px-4 py-2 flex items-center text-base hover:bg-gray-200 cursor-pointer">
                                <img src="../public/images/icons/ko.png" alt="한국어" class="h-6 mr-2"><span>한국어</span>
                            </div>
                            <div class="px-4 py-2 flex items-center text-base hover:bg-gray-200 cursor-pointer">
                                <img src="../public/images/icons/th.png" alt="ภาษาไทย" class="h-6 mr-2"><span>ภาษาไทย</span>
                            </div>
                            <div class="px-4 py-2 flex items-center text-base bg-gray-200 hover:bg-gray-300 cursor-pointer">
                                <img src="../public/images/icons/vi.png" alt="Tiếng Việt" class="h-6 mr-2"><span>Tiếng Việt</span>
                            </div>
                            <div class="px-4 py-2 flex items-center text-base hover:bg-gray-200 cursor-pointer">
                                <img src="../public/images/icons/zh.png" alt="中文" class="h-6 mr-2"><span>中文</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-8 lg:mb-12">
            <h3 class="text-2xl font-semibold text-gray-800 mb-4">Âm thanh</h3>
            <div class="mb-6">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="text-xl font-medium">Hiệu ứng âm thanh</h4>
                    <div class="h-7 w-11 rounded-full flex items-center px-1 cursor-pointer duration-100 ease-out bg-primary">
                        <div class="h-5 w-5 bg-white rounded-full duration-100 ease-out translate-x-4"></div>
                    </div>
                </div>
            </div>
            <div class="mb-6">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="text-xl font-medium">Tự động phát âm thanh</h4>
                    <div class="h-7 w-11 rounded-full flex items-center px-1 cursor-pointer duration-100 ease-out bg-primary">
                        <div class="h-5 w-5 bg-white rounded-full duration-100 ease-out translate-x-4"></div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <button class="rounded-lg font-medium text-lg shadow hover:shadow-lg duration-100 h-11 w-full bg-gray-200 text-gray-500">
                <span>Lưu</span>
            </button>
        </div>
    </div>

    <div class="w-full lg:w-[36%]">
        <div>
            <h3 class="text-2xl font-semibold text-gray-800 mb-5">Phản hồi</h3>
            <h4 class="text-xl font-medium cursor-pointer">Gửi phản hồi</h4>
            <div class="w-full h-px bg-gray-300 my-2"></div>
            <h4 class="text-xl font-medium cursor-pointer">Chia sẻ Dino English</h4>
            <div class="w-full h-px bg-gray-300 my-2"></div>
            <a class="text-xl font-medium cursor-pointer" href="http://bkitsoftware.com/dinoenglish/" target="_blank">Chính sách bảo mật</a>
        </div>
        <div class="flex justify-center mt-16 mb-8 lg:mt-8 lg:mb-0">
            <img src="../public/images/icons/logo-dino-full-02.png" alt="Dino Image" class="h-44">
        </div>
    </div>
</div>

</body>
</html>