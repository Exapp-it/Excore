<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf() ?>">

    <title><ex-title /></title>
    <ex-assets />
    <ex-scripts />
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>


</head>

<body class="min-h-screen bg-stone-900">
    <ex-header />
    <main>
        <ex-content />
    </main>


    <ex-footer />
    <ex-login-modal />
    <script src="/public/js/store.js"></script>



</body>

</html>