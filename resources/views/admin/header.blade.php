<header class="header">   
      <nav class="navbar navbar-expand-lg">
        <div class="container-fluid d-flex align-items-center justify-content-between">
          <div class="navbar-header">
            <!-- Navbar Header-->
            <a href="{{url('/admin')}}" class="navbar-brand">
              <div class="brand-text brand-big visible text-uppercase"><strong class="text-primary">Dark</strong><strong>Admin</strong></div>
              <div class="brand-text brand-sm"><strong class="text-primary">D</strong><strong>A</strong></div>
            </a>
            <!-- Sidebar Toggle Btn-->
            <button class="sidebar-toggle"><i class="fas fa-long-arrow-alt-left"></i></button>

          </div>
          
            <!-- Log out -->
            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                @csrf
            </form>
            <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('logout-form').submit();">Keluar</button>

          </div>
        </div>
      </nav>
    </header>