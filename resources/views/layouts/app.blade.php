<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionablyLate</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-[#8B7969] min-h-screen">

    <header class="relative border-b border-[#E0DFDE]">
        <div class="h-28 flex items-center justify-center">
            <h1 class="font-serif text-[48px]">
                FashionablyLate
            </h1>
        </div>

        <div class="absolute right-16 top-1/2 -translate-y-1/2">
            @yield('header-button')
        </div>
    </header>

    <main>
        @yield('content')
    </main>

</body>

</html>