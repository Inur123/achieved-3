<style>
    .small-icon {
        font-size: 8px;
        /* Perkecil ukuran ikon */
    }
</style>
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="./index.html" class="text-nowrap logo-img">
                <img src="{{ asset('template/assets/images/logos/logo-3.svg') }}"
                style="width: 200px; height: auto;"
                alt="">
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">

                @if (auth()->check() && auth()->user()->role_id === 1)
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.dashboard') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Blog</span>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('blog.posts.*') ? 'active' : '' }}">
                        <a class="sidebar-link {{ request()->routeIs('blog.posts.*') ? 'active' : '' }}"
                            href="{{ route('blog.posts.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-box-multiple"></i>
                            </span>
                            <span class="hide-menu">Posts</span>
                        </a>
                    </li>


                    <li class="sidebar-item {{ Request::is('blog.categories*') ? 'active' : '' }}">
                        <a class="sidebar-link {{ request()->routeIs('blog.categories.*') ? 'active' : '' }}"
                            href="{{ route('blog.categories.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-list-details"></i>
                            </span>
                            <span class="hide-menu">Categories</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ Request::is('blog.authors*') ? 'active' : '' }}">
                        <a class="sidebar-link {{ request()->routeIs('blog.authors.*') ? 'active' : '' }} "
                            href="{{ route('blog.authors.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-user-circle"></i>
                            </span>
                            <span class="hide-menu">authors</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ Request::is('blog.tags.index') ? 'active' : '' }}">
                        <a class="sidebar-link {{ request()->routeIs('blog.tags.*') ? 'active' : '' }}"
                            href="{{ route('blog.tags.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-tag"></i> <!-- Icon for Tag -->
                            </span>
                            <span class="hide-menu">Tags</span>
                        </a>
                    </li>
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Layanan</span>
                    </li>
                    <li class="sidebar-item {{ Request::is('products.index') ? 'active' : '' }}">
                        <a class="sidebar-link {{ request()->routeIs('products.*') ? 'active' : '' }}"
                            href="{{ route('products.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-package"></i> <!-- Icon for Product -->
                            </span>
                            <span class="hide-menu">Products</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ Request::is('admin/approved-transactions') ? 'active' : '' }}">
                        <a class="sidebar-link {{ request()->routeIs('approved_transactions.*') ? 'active' : '' }}"
                            href="{{ route('approved_transactions.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-credit-card"></i> <!-- Icon for Approved Transaction -->
                            </span>
                            <span class="hide-menu">Approved Transaksi</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ Request::is('admin/transaksi*') ? 'active' : '' }}">
                        <a class="sidebar-link {{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}"
                            href="{{ route('admin.transaksi.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-credit-card"></i> <!-- Icon for Admin Transaksi -->
                            </span>
                            <span class="hide-menu">Admin Transaksi</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ Request::is('admin/product-sales') ? 'active' : '' }}">
                        <a class="sidebar-link {{ request()->routeIs('admin.product.sales') ? 'active' : '' }}"
                            href="{{ route('product.sales') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-shopping-cart"></i> <!-- Icon for Product Sales -->
                            </span>
                            <span class="hide-menu">Product Sales</span>
                        </a>
                    </li>
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Pengguna</span>
                    </li>
                    <li class="sidebar-item {{ Request::is('admin/user*') ? 'active' : '' }}">
                        <a class="sidebar-link {{ Request::is('admin/user*') ? 'active' : '' }}"
                            href="{{ route('admin.user.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-user"></i> <!-- Icon for Admin User -->
                            </span>
                            <span class="hide-menu">Admin User</span>
                        </a>
                    </li>


                @endif
                @if (auth()->check() && auth()->user()->role_id === 2)
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item {{ Request::routeIs('user.dashboard') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('user.dashboard') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Transaksi</span>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('transactions.create') ? 'active' : '' }}">
                        <a class="sidebar-link {{ request()->routeIs('transactions.create') ? 'active' : '' }}"
                            href="{{ route('transactions.create') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-credit-card"></i> <!-- Icon for Transaction -->
                            </span>
                            <span class="hide-menu">Buat Transaksi</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('transactions.index') ? 'active' : '' }}">
                        <a class="sidebar-link {{ request()->routeIs('transactions.index') ? 'active' : '' }}"
                            href="{{ route('transactions.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-history"></i> <!-- Icon for Transaction History -->
                            </span>
                            <span class="hide-menu">Riwayat Transaksi</span>
                        </a>
                    </li>
                @endif

            </ul>

        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
