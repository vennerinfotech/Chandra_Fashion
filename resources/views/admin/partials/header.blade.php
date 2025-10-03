<div class="menu-bar">
    <div class="header-top">
        <div class="header-top-toggle">
            <a class="sidebar-toggle" href="#"><i class="fa-solid fa-bars-staggered"></i></a>
        </div>

        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-user-tie"></i>
            </button>

            @if($newInquiryCount > 0)
                 <span class="badge bg-danger">{{ $newInquiryCount }}</span>
            @endif
            <ul class="dropdown-menu">

                <li>
                    <a href="{{ route('admin.inquiries.index') }}">
                        <i class="fas fa-bell"></i>
                        <span class="text nav-text">Notification</span>

                        @if($newInquiryCount > 0)
                            <span class="badge bg-danger">{{ $newInquiryCount }}</span>
                        @endif
                    </a>
                </li>

                <li>
                    <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-link p-0" style="border: none; background: none;">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <span class="text nav-text">Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
