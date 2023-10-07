<div x-data="registerComponent">
    <div class="container mx-auto" id="content">
        <div class="w-1/3 md:w-1/2 sm:w-full mx-auto shadow-lg rounded-lg  mt-10 p-5">
            <h2 class="text-center text-2xl text-blue-600 my-5">Вход в аккаунт</h2>
            <form class="text-center" @submit.prevent="register">
                <div class="mb-4">
                    <label for="username" class="block text-gray-600 font-semibold">Имя пользователя:</label>
                    <input x-model="username" x-bind:class="{'border-red-300': errors.username, 'border-gray-300': !errors.username,}" type="text" id="username" class="border rounded-md py-2 px-3 focus:outline-none focus:ring focus:border-blue-400 focus:border-2 w-full">
                    <div x-show="errors.username" x-text="errors.username" x-transition class="text-red-500 mt-1 text-sm"></div>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-600 font-semibold">Email:</label>
                    <input x-model="email" x-bind:class="{'border-red-300': errors.email, 'border-gray-300': !errors.email,}" type="text" id="email" class="border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring focus:border-blue-400 focus:border-2 w-full">
                    <div x-show="errors.email" x-text="errors.email" x-transition class="text-red-500 mt-1 text-sm"></div>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-600 font-semibold">Пароль:</label>
                    <input x-model="password" x-bind:class="{'border-red-300': errors.password, 'border-gray-300': !errors.password,}" type="password" id="password" class="border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring focus:border-blue-400 focus:border-2 w-full">
                    <div x-show="errors.password" x-text="errors.password" x-transition class="text-red-500 mt-1 text-sm"></div>
                </div>
                <div class="mb-4">
                    <label for="passwordConfirm" class="block text-gray-600 font-semibold">Подтверждение пароля:</label>
                    <input x-model="passwordConfirm" x-bind:class="{'border-red-300': errors.passwordConfirm, 'border-gray-300': !errors.passwordConfirm,}" type="password" id="passwordConfirm" class="border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring focus:border-blue-400 focus:border-2 w-full">
                    <div x-show="errors.passwordConfirm" x-text="errors.passwordConfirm" x-transition class="text-red-500 mt-1 text-sm"></div>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring focus:ring-blue-300">Войти</button>
            </form>
        </div>
    </div>
</div>

<script>
    const registerComponent = {
        username: '',
        email: '',
        password: '',
        passwordConfirm: '',
        errors: {},
        message: '',
        register() {
            this.errors = {}
            const data = new URLSearchParams();
            data.append('username', this.username);
            data.append('email', this.email);
            data.append('password', this.password);
            data.append('passwordConfirm', this.passwordConfirm);

            fetch('/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: data
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Ошибка при отправке данных. Код статуса: ' + response.status);
                    }
                    return response.json();
                })
                .then(responseData => {
                    if (responseData.success) {
                        this.message = responseData.message;

                        if (responseData.redirect) {
                            // Добавляем класс .fade-out для плавного исчезновения элемента
                            const elementToFadeOut = document.getElementById('content'); // Замените 'your-element-id' на реальный идентификатор элемента
                            if (elementToFadeOut) {
                                elementToFadeOut.classList.add('fade-out');
                                setTimeout(() => {
                                    window.location.href = responseData.redirect; // После завершения анимации, переход на другую страницу
                                }, 500); // Используйте тот же период, что и в CSS для анимации
                            }
                        }
                    } else {
                        this.errors = responseData.errors;
                    }
                })

                .catch(error => {
                    console.error(error);
                });
        }
    }
</script>