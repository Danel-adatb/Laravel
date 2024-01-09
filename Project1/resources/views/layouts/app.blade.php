<!DOCTYPE html>
<HTML>
    <HEAD>
        <TITLE>Laravel Project No. 1</TITLE>
        @yield('styles')
    </HEAD>

    <BODY>
        <H1>@yield('title')</H1>
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
