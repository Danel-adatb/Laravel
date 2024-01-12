<!DOCTYPE html>
<HTML>
    <HEAD>
        <TITLE>Laravel Project No. 1</TITLE>

        <script src="https://cdn.tailwindcss.com"></script>
        @yield('styles')
    </HEAD>

    <!-- Container: -- Centered container with max-width based on the screen size -->
    <!-- mx-auto: -- This horizontally centers the elements within the container -->
    <!-- max-w-lg: -- Maximum screen size is large (32 rem / 512 px) -->
    <BODY class="container mx-auto mt-10 mb-10 max-w-lg">
        <H1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">@yield('title')</H1>
        <div>
             <!-- Flash message -->
             @if (session()->has('success'))
                 <div>
                    {{ session('success') }}
                 </div>
             @endif

            @yield('content')
        </div>
    </BODY>
</HTML>
