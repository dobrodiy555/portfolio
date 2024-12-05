<header>
    <div class="header-container">
        <a href="/">
            <div class="logo-section">
                <img id="paw" src="images/Pawfect Pawtrails-3.png" alt="logo">
                <img id="paw2" src="images/Pawfect Pawtrails-5.png" alt="logo">
            </div>
        </a>
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="browse-pets">Browse Pets</a></li>
                <li><a href="adopt">Adopt</a></li>
                @auth
                <li><a href="put-pet">Put Pet</a></li>
                @endauth
                <li><a href="success-stories">Success Stories</a></li>
                <li><a href="pet-care">Pet Care</a></li>
                <li><a href="volunteer">Get Involved</a></li>
                <li><a href="donate">Donate</a></li>
                @guest
                    <li><a href="signup">Sign In</a></li>
                @else
                    <form action="/logout" method="post">
                        @csrf
                        <li><button class="logout-button">Log Out</button></li>
                    </form>
                @endguest
                @if (auth()->check() && auth()->user()->is_admin)
                    <li><a href="/admin">Admin</a></li>
                @endif

            </ul>
        </nav>
    </div>
</header>
