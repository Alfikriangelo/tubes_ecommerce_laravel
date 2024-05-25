<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand ml-5" href="{{url('/')}}">Lakuna </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            
        </ul>
        <form class="form-inline my-2 my-lg-0" action="{{ url('home_search') }}" method="get">
            @csrf
            <div class="input-group">
                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Nama produk..." aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="submit">Cari</button>
                    @if(isset($search))
                        <a href="{{ url('/') }}" class="btn btn-outline-danger" role="button">
                            <i class="fa fa-times"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
        <div class="user_option">
            @if (Route::has('login'))
                @auth
                    <a href="{{url('mycart')}}">
                        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                        @isset($count)
                            {{$count}}
                        @endisset
                    </a>
                    <p class="navbar-brand" style="margin-right: 20px">{{ Auth::user()->name }}</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <input class="btn btn-outline-danger my-2 my-sm-0" type="submit" value="logout">
                    </form>
                @else
                    <a href="/login">
                        <span>Masuk</span>
                    </a>
                    <a href="/register">
                        <span>Daftar</span>
                    </a>
                @endauth
            @endif
        </div>
    </div>
</nav>
