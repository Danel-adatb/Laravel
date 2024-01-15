<!DOCTYPE html>
<HTML>
    <HEAD>
        <TITLE>Laravel Project No. 1</TITLE>

        <script src="https://cdn.tailwindcss.com"></script>
        <script src="//unpkg.com/alpinejs" defer></script>

        {{-- blade-formatter-disable --}}
        <style type="text/tailwindcss">
            .btn {
                @apply text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded text-sm px-2 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800
            }

            label {
                @apply block uppercase text-slate-700 mb-2
            }

            input, textarea {
                @apply shadow-sm appearance-none border w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none
            }

            .error {
                @apply text-red-500 text-sm
            }

            /*We are adding relative class because inside the relative container we will have an absolute container*/
            .flash-success {
                @apply relative mb-10 rounded border border-green-400 bg-green-100 px-4 py-3 text-lg text-green-700
            }
        </style>
        {{-- blade-formatter-disable --}}

        @yield('styles')
    </HEAD>

    <!-- Container: -- Centered container with max-width based on the screen size -->
    <!-- mx-auto: -- This horizontally centers the elements within the container -->
    <!-- max-w-lg: -- Maximum screen size is large (32 rem / 512 px) -->
    <BODY class="container mx-auto mt-10 mb-10 max-w-lg">
        <H1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">@yield('title')</H1>
        <div x-data="{ flash: true}">
             <!-- Flash message -->
             @if (session()->has('success'))
                 <div x-show="flash" class="flash-success" role="alert">
                    <strong class="font-bold">{{ session('success') }}</strong>

                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <!-- Event Listener adding  -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" @click="flash = false"
                            stroke="currentColor" class="h-6 w-6 cursor-pointer">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </span>
                 </div>
             @endif

            @yield('content')
        </div>
    </BODY>
</HTML>
