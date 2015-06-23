Dear {{ $user->name }},<br><br>

@yield('mail')

<br><br>If you have any question, feel free to contact us on <a href="{{ url('/') }}">Koolbeans</a>!
