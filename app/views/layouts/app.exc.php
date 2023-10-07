<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><ex-title></title>
    <ex-assets>
        <?php echo \Excore\Core\Helpers\Assets::alpineCDN(); ?>

</head>

<body>
    <div x-data="{ progress: 0 }" x-init="startProgress()" class="relative pt-1">
        <div class="flex mb-2 items-center justify-between">
            <div>
                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-teal-600 bg-teal-200">
                    Выполнение задачи
                </span>
            </div>
            <div class="text-right">
                <span class="text-xs font-semibold inline-block text-teal-600" x-text="progress + '%'"></span>
            </div>
        </div>
        <div class="flex">
            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-teal-200">
                <div :style="'width:' + progress + '%'" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-teal-500"></div>
            </div>
        </div>
    </div>



    <div x-data="{ isLoading: true }" x-init="setTimeout(() => isLoading = false, 500)">
        <div x-show="isLoading" class="fixed top-0 left-0 w-screen h-screen bg-opacity-50 bg-gray-900 flex items-center justify-center z-50">
            <!-- Прелоадер с использованием Tailwind CSS классов -->
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500 border-solid"></div>
        </div>

        <main x-show="!isLoading">
            <ul class="flex text-center">
                <li class="pl-5"><a href="/">HOME</a></li>
                <li class="pl-5"><a href="/login">LOGIN</a></li>
                <li class="pl-5"><a href="/register">REGISTER</a></li>
            </ul>
            <ex-content>
        </main>
    </div>


    <ex-scripts>
        <script>
            function startProgress() {
                let width = 0;
                const interval = setInterval(() => {
                    if (width >= 100) {
                        clearInterval(interval);
                    } else {
                        width++;
                        Alpine.store('progress', width); // Обновляем значение в хранилище Alpine.js
                    }
                }, 50);
            }
        </script>

</body>

</html>