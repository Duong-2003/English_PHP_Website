
<style>
        .bg-colorLandingTextLight {
            background-color: #e0f7fa; /* Thay đổi màu sắc theo yêu cầu */
        }
        .text-colorLandingTextLight {
            color: #555; /* Thay đổi màu sắc theo yêu cầu */
        }
        .bg-colorLandingAqua {
            background-color: #00bcd4; /* Thay đổi màu sắc theo yêu cầu */
        }
        .bg-colorLandingBlue {
            background-color: #2196f3; /* Thay đổi màu sắc theo yêu cầu */
        }
        .landing-hover-btn {
            transition: background-color 0.3s ease;
        }.highlight {
            color: #38a169; /* Màu chữ nổi bật */
            font-weight: bold; /* Bolding text */
        }
    </style>

<div class="container">
    <main style="height: auto !important;">
        <section class="flex flex-col-reverse lg:flex-row items-start landing-section pt-8 md:pt-10 lg:pt-12 xl:pt-14 2xl:pt-16 pb-14 md:pb-16 lg:pb-20 xl:pb-22 2xl:pb-24">
            <div class="w-full lg:grow flex flex-col items-center ">
                <h1 class="mb-8 text-center lg:text-left">
                    <div class="font-bold highlight text-colorLandingTextBold text-[36px] md:text-[44px] xl:text-[48px] 2xl:text-[54px] leading-tight">
                        LEARING ENGLISH ONLINE  
                    </div>
                   
                </h1>
                <div class="flex flex-col gap-6 2xl:gap-8 mb-12 w-full md:max-w-[650px] md:mx-auto lg:mx-0 lg:max-w-none lg:w-3/4">
                    <div class="flex items-start">
                        <div class="w-2.5 h-2.5 mt-1.5 shrink-0 rounded-full bg-colorLandingTextLight mr-4"></div>
                        <div class="text-colorLandingTextLight">Learn basic English for beginners or advanced levels for those who have lost their roots.</div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-2.5 h-2.5 mt-1.5 shrink-0 rounded-full bg-colorLandingTextLight mr-4"></div>
                        <div class="text-colorLandingTextLight">Learn English for students, students, and working people.</div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-2.5 h-2.5 mt-1.5 shrink-0 rounded-full bg-colorLandingTextLight mr-4"></div>
                        <div class="text-colorLandingTextLight">Learn English for communication, academic English, and learn English online every day.</div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-2.5 h-2.5 mt-1.5 shrink-0 rounded-full bg-colorLandingTextLight mr-4"></div>
                        <div class="text-colorLandingTextLight">Easy to use, learn while playing, sync on any device, ...</div>
                    </div>
                </div>
                <button class="landing-hover-btn font-semibold outline-none text-white bg-gradient-to-r from-green-400 to-green-700 hover:from-green-300 hover:to-green-600 rounded-lg w-full lg:w-auto h-12 px-6 text-sm transition duration-300">
                VIEW DOCUMENT
                </button>
            </div>
            <div class="shrink-0 mx-auto mb-8 lg:mb-0 lg:self-center relative w-80 h-80 md:w-[350px] md:h-[350px] lg:w-[375px] lg:h-[375px] 2xl:w-[450px] 2xl:h-[450px] flex justify-center">
                <img src="<?= '../public/images/icons/dino-img-1.png' ?>" alt="Logo" class="h-full w-full object-contain">
            </div>
            <div class="hidden lg:block absolute w-56 h-56 top-44 right-24 bg-colorLandingAqua blur-[130px] rounded-full -z-10"></div>
            <div class="hidden lg:block absolute w-56 h-56 top-12 right-0 bg-colorLandingBlue blur-[130px] rounded-full -z-10"></div>
        </section>

        <hr class="w-[90%] mx-auto max-w-[1600px] bg-colorLandingDivider border-0 h-px">
    </main>
