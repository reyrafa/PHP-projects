<!DOCTYPE>
<html>
<title>Task Manager</title>

<body>
    <header>Task Manager</header>
    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif
    <main>
        @yield('content')
    </main>

</body>

</html>
