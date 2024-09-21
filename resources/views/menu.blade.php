<div class="app-menu navbar-menu">
    <div class="navbar-brand-box">
        <a href="{{ route('dashboard')  }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('') }}assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('') }}assets/images/logo-dark.png" alt="" height="17">
            </span>
        </a>
        <a href="{{ route('dashboard')  }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('') }}assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('') }}assets/images/logo-light.png" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('dashboard')  }}">
                        <i class="ri-dashboard-2-line"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarSample" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarSample">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-sample">Samaple</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarSample">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-analytics"> Analytics </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>
<div class="vertical-overlay"></div>
