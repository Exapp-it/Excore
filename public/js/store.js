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
});