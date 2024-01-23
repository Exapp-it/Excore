<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= Excore\Core\Helpers\Hash::generateCsrfToken() ?>">


    <title><ex-title /></title>
    <ex-assets />
    <ex-scripts />


</head>

<body>
    <div class="w-full">
        <ul class="flex space-x-4">
            <li><a href="/">Home</a></li>
            <li><a href="/login">Login</a></li>
            <li><a href="/register">Register</a></li>
        </ul>
    </div>

    <ex-header />
    <main>
        <ex-content />
    </main>



    <script>
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
    </script>

</body>

</html>