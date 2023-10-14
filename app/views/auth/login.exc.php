<div x-data="loginComponent">
    <div class="container mx-auto" id="content">
        <div class="w-1/3 md:w-1/2 sm:w-full mx-auto shadow-lg rounded-lg  mt-10 p-5">
            <h2 class="text-center text-2xl text-blue-600 my-5">Вход в аккаунт</h2>
            <div x-cloak x-show="message" x-text="message" x-transition class="py-2 px-5 mb-3 text-center rounded-md shadow bg-red-500 text-white mt-1 text-sm border-2 border-red-400"></div>
            <form class="text-center" action="/login" method="POST">
                <input type="hidden" x-model="csrfToken" x-init="csrfToken = '<?php echo $csrfToken ?>'">

                <div class="mb-4">
                    <label for="email" class="block text-gray-600 font-semibold">Email:</label>
                    <input name="email" x-model="email" x-bind:class="{'border-red-300': errors.email, 'border-gray-300': !errors.email,}" type="text" id="email" class="border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring focus:border-blue-400 focus:border-2 w-full">
                    <div x-show="errors.email" x-text="errors.email" x-transition class="text-red-500 mt-1 text-sm"></div>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-600 font-semibold">Пароль:</label>
                    <input name="password" x-model="password" x-bind:class="{'border-red-300': errors.password, 'border-gray-300': !errors.password,}" type="password" id="password" class="border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring focus:border-blue-400 focus:border-2 w-full">
                    <div x-show="errors.password" x-text="errors.password" x-transition class="text-red-500 mt-1 text-sm"></div>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring focus:ring-blue-300">Войти</button>
            </form>
        </div>
    </div>
</div>

<!-- @submit.prevent="sendRequest" -->



<script src="/public/js/auth/Login.exc.js"></script>