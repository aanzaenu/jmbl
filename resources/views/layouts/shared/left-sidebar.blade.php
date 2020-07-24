<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li class="menu-title">Navigasi</li>

                <li>
                    <a href="{{route('dashboard')}}">
                        <i data-feather="airplay"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
                <?php
                if(request()->segment(1) == 'rubrik' && request()->segment(3) == 'edit' || request()->segment(1) == 'rubrik' && request()->segment(2) == 'create' || request()->segment(1) == 'rubrik' && request()->segment(2) == 'show' || request()->segment(1) == 'post' && request()->segment(3) == 'edit' || request()->segment(1) == 'post' && request()->segment(2) == 'create' || request()->segment(1) == 'post' && request()->segment(2) == 'show'){
                    $show = 'show';
                    $parent = 'class="menuitem-active"';
                }else{
                    $show = '';
                    $parent = '';
                };?>
                <li {{ $parent }}>
                    <a href="#post" data-toggle="collapse">
                        <i data-feather="book"></i>
                        <span> Post </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse {{ $show }}" id="post">
                        <ul class="nav-second-level">
                            <li @if(request()->segment(1) == 'post' && request()->segment(2) == 'show' || request()->segment(1) == 'post' && request()->segment(3) == 'edit') class="menuitem-active" @endif >
                                <a @if(request()->segment(1) == 'post' && request()->segment(2) == 'show') class="active" @endif href="{{route('post.index')}}">Semua Artikel</a>
                            </li>
                            <li @if(request()->segment(1) == 'post' && request()->segment(2) == 'create') class="menuitem-active" @endif >
                                <a @if(request()->segment(1) == 'post' && request()->segment(2) == 'create') class="active" @endif href="{{route('post.create')}}">Tambah Artikel</a>
                            </li>
                            <li @if(request()->segment(1) == 'rubrik' && request()->segment(2) == 'show' || request()->segment(1) == 'rubrik' && request()->segment(3) == 'edit') class="menuitem-active" @endif >
                                <a @if(request()->segment(1) == 'rubrik' && request()->segment(2) == 'show' || request()->segment(1) == 'rubrik' && request()->segment(3) == 'edit') class="active" @endif href="{{route('rubrik.index')}}">Semua Rubrik</a>
                            </li>
                            <li @if(request()->segment(1) == 'rubrik' && request()->segment(2) == 'create') class="menuitem-active" @endif >
                                <a @if(request()->segment(1) == 'rubrik' && request()->segment(2) == 'create') class="active" @endif href="{{route('rubrik.create')}}">Tambah Rubrik</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <?php
                if(request()->segment(1) == 'infografik' && request()->segment(3) == 'edit' || request()->segment(1) == 'infografik' && request()->segment(2) == 'create' || request()->segment(1) == 'infografik' && request()->segment(2) == 'show'){
                    $show = 'show';
                    $parent = 'class="menuitem-active"';
                }else{
                    $show = '';
                    $parent = '';
                };?>
                <li {{ $parent }}>
                    <a href="#infogragik" data-toggle="collapse">
                        <i data-feather="monitor"></i>
                        <span> Infografik </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse {{ $show }}" id="infogragik">
                        <ul class="nav-second-level">
                            <li @if(request()->segment(1) == 'infografik' && request()->segment(2) == 'show' || request()->segment(1) == 'infografik' && request()->segment(3) == 'edit') class="menuitem-active" @endif >
                                <a @if(request()->segment(1) == 'infografik' && request()->segment(2) == 'show') class="active" @endif href="{{route('infografik.index')}}">Semua Infografik</a>
                            </li>
                            <li @if(request()->segment(1) == 'infografik' && request()->segment(2) == 'create') class="menuitem-active" @endif >
                                <a @if(request()->segment(1) == 'infografik' && request()->segment(2) == 'create') class="active" @endif href="{{route('infografik.create')}}">Tambah Infgrafik</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <?php
                if(request()->segment(1) == 'userlist' && request()->segment(3) == 'edit' || request()->segment(1) == 'userlist' && request()->segment(2) == 'create' || request()->segment(1) == 'userlist' && request()->segment(2) == 'show'){
                    $show = 'show';
                    $parent = 'class="menuitem-active"';
                }else{
                    $show = '';
                    $parent = '';
                };?>
                <li {{ $parent }}>
                    <a href="#user" data-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> User </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse {{ $show }}" id="user">
                        <ul class="nav-second-level">
                            <li @if(request()->segment(1) == 'userlist' && request()->segment(2) == 'show' || request()->segment(1) == 'userlist' && request()->segment(3) == 'edit') class="menuitem-active" @endif >
                                <a @if(request()->segment(1) == 'userlist' && request()->segment(2) == 'show') class="active" @endif href="{{route('userlist.index')}}">Semua User</a>
                            </li>
                            <li @if(request()->segment(1) == 'userlist' && request()->segment(2) == 'create') class="menuitem-active" @endif >
                                <a @if(request()->segment(1) == 'userlist' && request()->segment(2) == 'create') class="active" @endif href="{{route('userlist.create')}}">Tambah User</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="{{route('logout')}}">
                        <i data-feather="log-out"></i>
                        <span> Keluar </span>
                    </a>
                </li>
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->