<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf() ?>">

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




    <script src="/public/js/store.js"></script>
</body>

</html>