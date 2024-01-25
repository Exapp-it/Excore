document.addEventListener('alpine:init', () => {
    Alpine.data('loginForm', function () {
        let timer;
        return {
            toast: Alpine.store('toast'),
            login: '',
            password: '',
            error: {},
            message: '',
            status: '',
            openToast() {
                this.toast.addMessage(this.message, this.status);
            },
            clearData: function () {
                this.error = {}
                this.message = ''
                this.status = ''
            },
            loginRequest: async function () {
                this.clearData()
                try {
                    const response = await axios.post('login', {
                        login: this.login,
                        password: this.password,
                    }, {
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Csrf-Token': csrfToken,
                        }
                    });

                    const data = response.data;
                    this.status = data.success ? 'success' : 'error';
                    this.message = data.message || '';

                    if (this.status === 'error' && data.errors) {
                        // Обработка ошибок
                        this.error = {};
                        for (const field in data.errors) {
                            if (Array.isArray(data.errors[field]) && data.errors[field].length > 0) {
                                this.error = {
                                    field: field,
                                    message: data.errors[field][0] || ''
                                };
                                break;
                            }
                        }
                        this.openToast();
                    } else if (this.status === 'success') {
                        if (data.redirect) {
                            // Обработка успешной авторизации с перенаправлением
                            window.location = data.redirect;
                        } else {
                            this.openToast();
                        }
                    }

                } catch (error) {
                    const data = error.response.data;
                    console.error(data);
                    this.status = 'error';
                    this.message = 'Ошибка сервера';
                    if (data.redirect) {
                        window.location = data.redirect;
                    } else {
                        this.openToast();
                    }
                }
            }
        };
    });
});