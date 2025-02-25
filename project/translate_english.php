<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Learning English</title>
    <link rel="icon" type="image/x-icon" href="images/icons/dino.png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <?php include('../src/font/learn_english/header_english.php'); ?>
</head>

<body>

<div class="container mt-8">
    <div class="h-14 relative bg-white rounded-full z-0">
        <div class="w-full h-full border-2 flex items-center text-gray-600 box-border relative group rounded-full border-black/10 hover:border-black/20">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="text-2xl min-w-10 shrink-0 w-12 text-gray-400" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"></path>
            </svg>
            <div class="h-full grow relative">
                <input class="h-full w-full bg-transparent text-md outline-0 font-medium pr-2" spellcheck="false" placeholder="Nhập gì đó…" value="">
            </div>
            <div class="h-9 w-0.5 bg-black/10 group-hover:bg-black/20"></div>
            <div class="flex items-center mr-1 h-12">
                <div class="relative">
                    <div class="w-24 text-sm flex-center h-11 hover:bg-gray-200 duration-100 cursor-pointer">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 320 512" class="mb-1.5" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path d="M41 288h238c21.4 0 32.1 25.9 17 41L177 448c-9.4 9.4-24.6 9.4-33.9 0L24 329c-15.1-15.1-4.4-41 17-41z"></path>
                        </svg>
                        <span class="ml-1">Tiếng Anh</span>
                    </div>
                    <div class="absolute hidden group-hover:block w-auto h-auto text-sm bg-white border-2 border-gray-300 shadow-lg rounded-md">
                        <div class="p-2 hover:bg-gray-200 duration-100 cursor-pointer relative rounded-t-md">
                            <span>Tiếng Anh</span>
                            <div class="absolute inset-y-0 left-0 w-1 bg-blue-500 rounded-tl-md"></div>
                        </div>
                        <div class="p-2 hover:bg-gray-200 duration-100 cursor-pointer relative"><span>Tiếng Nhật</span></div>
                        <div class="p-2 hover:bg-gray-200 duration-100 cursor-pointer relative"><span>Tiếng Hàn</span></div>
                        <div class="p-2 hover:bg-gray-200 duration-100 cursor-pointer relative"><span>Tiếng Thái</span></div>
                        <div class="p-2 hover:bg-gray-200 duration-100 cursor-pointer relative"><span>Tiếng Việt</span></div>
                        <div class="p-2 hover:bg-gray-200 duration-100 cursor-pointer relative rounded-b-md"><span>Tiếng Trung</span></div>
                    </div>
                </div>
                <div class="h-11 px-1.5 text-sm flex-center md:text-lg hover:bg-gray-200 duration-100 cursor-pointer">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 168v-16c0-13.255 10.745-24 24-24h360V80c0-21.367 25.899-32.042 40.971-16.971l80 80c9.372 9.373 9.372 24.569 0 33.941l-80 80C409.956 271.982 384 261.456 384 240v-48H24c-13.255 0-24-10.745-24-24zm488 152H128v-48c0-21.314-25.862-32.08-40.971-16.971l-80 80c-9.372 9.373-9.372 24.569 0 33.941l80 80C102.057 463.997 128 453.437 128 432v-48h360c13.255 0 24-10.745 24-24v-16c0-13.255-10.745-24-24-24z"></path>
                    </svg>
                </div>
                <div class="relative">
                    <div class="w-24 text-sm flex-center h-11 hover:bg-gray-200 duration-100 cursor-pointer">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 320 512" class="mb-1.5" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path d="M41 288h238c21.4 0 32.1 25.9 17 41L177 448c-9.4 9.4-24.6 9.4-33.9 0L24 329c-15.1-15.1-4.4-41 17-41z"></path>
                        </svg>
                        <span class="ml-1">Tiếng Việt</span>
                    </div>
                    <div class="absolute hidden group-hover:block w-auto h-auto text-sm bg-white border-2 border-gray-300 shadow-lg rounded-md">
                        <div class="p-2 hover:bg-gray-200 duration-100 cursor-pointer relative rounded-t-md">
                            <span>Tiếng Anh</span>
                        </div>
                        <div class="p-2 hover:bg-gray-200 duration-100 cursor-pointer relative"><span>Tiếng Nhật</span></div>
                        <div class="p-2 hover:bg-gray-200 duration-100 cursor-pointer relative"><span>Tiếng Hàn</span></div>
                        <div class="p-2 hover:bg-gray-200 duration-100 cursor-pointer relative"><span>Tiếng Thái</span></div>
                        <div class="p-2 hover:bg-gray-200 duration-100 cursor-pointer relative bg-gray-200">
                            <span>Tiếng Việt</span>
                            <div class="absolute inset-y-0 left-0 w-1 bg-blue-500"></div>
                        </div>
                        <div class="p-2 hover:bg-gray-200 duration-100 cursor-pointer relative rounded-b-md"><span>Tiếng Trung</span></div>
                    </div>
                </div>
            </div>
            <button class="bg-blue-500 text-white text-sm md:text-base px-4 md:px-6 h-11 rounded-full mr-1 hover:bg-blue-600">Dịch</button>
        </div>
    </div>

    <div class="flex flex-col items-center pt-16">
        <img src="../public/images/icons/logo-dino-full-01.png" alt="Dino Image" class="h-52">
        <div class="text-xl mt-4 text-gray-600">Dino English Translate</div>
    </div>
</div>

</body>
</html>