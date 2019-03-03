<header class="mb-4">
    <nav class="navbar navbar-expand-sm navbar-light" style="background-color:#eeeeee;"> 
        <a class="navbar-brand" href="/"><img class="logo" src="{{ asset('images/logo.jpg') }}" alt="logo"></a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mx-auto"></ul>
            <ul class="navbar-nav">
                @if (Auth::check())
                    <li>{!! link_to_route('logout.get', 'Logout', [], ['class' => 'nav-link']) !!}</li>
                    <li class="nav-item"><a href="#" class="nav-link">Create List</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Edit List</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Shop w List</a></li>
                    <li>{!! link_to_route('users.index', 'Manage Family', [], ['class' => 'nav-link']) !!}</li>
                @else
                    <li>{!! link_to_route('signup.get', 'Signup', [], ['class' => 'nav-link']) !!}</li>
                    <li>{!! link_to_route('login', 'Login', [], ['class' => 'nav-link']) !!}</li>
                @endif
            </ul>
        </div>
    </nav>
</header>