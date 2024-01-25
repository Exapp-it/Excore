document.addEventListener('alpine:init', () => {
    Alpine.store('toast', {
        messages: [],
        addMessage(message, status) {
            this.messages.push({
                message,
                status
            });
            setTimeout(() => {
                this.messages.shift();
            }, 5000);
        },
    });

    Alpine.store('modal', {
        login: {
            isOpen: false,
            open() {
                console.log('Login modal opened');
                this.isOpen = true;
            },
            close() {
                console.log('Login modal closed');
                this.isOpen = false;
            }
        }
    });
});
