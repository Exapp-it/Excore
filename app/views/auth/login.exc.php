<div x-data="{
    username: '',
    password: '',
    error: false,
    success: false,
    message: '',
    async sendRequest() {
    try {
        const formData = new FormData();
        formData.append('username', this.username);
        formData.append('password', this.password);

        const response = await fetch('/login', {
            method: 'POST',
            body: formData
        });

        if (response.ok) {
            const data = await response.json();
            this.success = true
            this.message = data.message
            console.log(data.message);
        } else {
            console.error('Ошибка при отправке данных. Код статуса:', response.status);
            const errorResponse = await response.text();
            console.log('Ответ сервера:', errorResponse);
        }
    } catch (error) {
        console.error(error);
    }
}


}">
    <div class="form-container">
        <h2>Вход в аккаунт</h2>
        <form @submit.prevent="sendRequest">
            <label for="username">Имя пользователя:</label>
            <input type="text" id="username" x-model="username">
            <label for="password">Пароль:</label>
            <input type="password" id="password" x-model="password">
            <button type="submit">Войти</button>
        </form>
        <span x-show="success" x-text="message"></span>
    </div>
</div>