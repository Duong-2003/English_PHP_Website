<!DOCTYPE html>

<body>

    <header class="w-full border-b-2  border-gray-100 shadow-lg bg-white ">
        <div class="max-w-screen-xl mx-auto h-20 py-2 flex  items-center justify-evenly">
            <a href="/" class="flex items-center h-full cursor-pointer">
                <div class="relative h-12 w-12 mr-1">
                    <img src="<?= '../public/images/icons/dino.png' ?>" alt="Logo" class="h-full w-full object-contain">
                </div>
                <div class="relative w-36 h-full">
                    <img src="<?= '../public/images/icons/dino_name.png' ?>" alt="Logo"
                        class="h-full w-full object-contain">
                </div>
            </a>

            <nav class="hidden lg:flex gap-12">
                <a href="http://localhost/Learning%20English/project/website.php"
                    class="text-base font-normal text-black cursor-pointer">Trang chủ</a>
                <a href="#" class="text-base font-normal text-black cursor-pointer">Download</a>
                <a href="#" class="text-base font-normal text-black cursor-pointer">Giới thiệu</a>
                <a href="#" class="text-base font-normal text-black cursor-pointer">Blog</a>
            </nav>

            <button
                class="font-semibold outline-none text-white bg-gradient-to-r from-green-400 to-green-700 hover:from-green-300 hover:to-green-600 rounded-lg w-full lg:w-auto h-12 px-6 text-sm transition duration-300">BẮT
                ĐẦU NGAY</button>

            <!-- Menu cho thiết bị di động -->
            <div class="lg:hidden">
                <button id="menu-btn"
                    class="text-3xl text-green-600 hover:text-green-800 focus:outline-none transition duration-300">
                    <i class="fas fa-bars"></i>
                </button>
                <div id="mobile-menu" class="hidden absolute right-0 bg-white shadow-lg mt-2 rounded-md w-48">
                    <div class="flex flex-col p-4">
                        <a href="http://localhost/Learning%20English/project/website.php" class="py-2 text-black">Trang
                            chủ</a>
                        <a href="#" class="py-2 text-black">Download</a>
                        <a href="#" class="py-2 text-black">Giới thiệu</a>
                        <a href="#" class="py-2 text-black">Blog</a>
                        <button
                            class="font-semibold outline-none text-white bg-gradient-to-r from-green-400 to-green-700 hover:from-green-300 hover:to-green-600 rounded-lg w-full lg:w-auto h-12 px-6 text-sm transition duration-300">BẮT
                            ĐẦU NGAY</button>
                    </div>
                </div>
            </div>
        </div>
    </header>



    <script>
        // JavaScript để điều khiển menu di động
        document.getElementById('menu-btn').onclick = function () {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        };
    </script>
</body>

</html>