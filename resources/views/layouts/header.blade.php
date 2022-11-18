       <!-- Navbar -->
       <nav class="main-header navbar navbar-expand navbar-white navbar-light">
           <!-- Left navbar links -->
           <ul class="navbar-nav">
               <li class="nav-item">
                   <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
               </li>
               <li class="nav-item d-none d-sm-inline-block">
                   <a href="index3.html" class="nav-link">Home</a>
               </li>
               <li class="nav-item d-none d-sm-inline-block">
                   <a href="#" class="nav-link">Contact</a>
               </li>
           </ul>

           <!-- Right navbar links -->
           <ul class="navbar-nav ml-auto">
               <!-- Navbar Search -->
               <li class="nav-item">
                   <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                       <i class="fas fa-search"></i>
                   </a>
                   <div class="navbar-search-block">
                       <form class="form-inline">
                           <div class="input-group input-group-sm">
                               <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                   aria-label="Search">
                               <div class="input-group-append">
                                   <button class="btn btn-navbar" type="submit">
                                       <i class="fas fa-search"></i>
                                   </button>
                                   <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                       <i class="fas fa-times"></i>
                                   </button>
                               </div>
                           </div>
                       </form>
                   </div>
               </li>
               <li class="nav-item dropdown show">
                   <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="true" class="nav-link dropdown-toggle">{{ auth()->user()->name }}</a>
                   <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow "
                       style="left: 0px; right: inherit;">
                       <li class="dropdown-divider"></li>
                       <li><a href="#" onclick="document.getElementById('logout-form').submit()"
                               class="dropdown-item">Logout</a></li>
                   </ul>
               </li>
           </ul>
       </nav>
       <!-- /.navbar -->
       <form action="{{ route('logout') }}" method="post" id="logout-form" style="display: none">@csrf</form>
