<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="width: 15rem !important; position: relative;">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-vote-yea"></i> <!-- Assuming this is the election icon -->
            </div>
            <div class="sidebar-brand-text mx-3">Elections</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link text-right" href="{{ route('home') }}">
                <i class="fas fa-fw fa-tachometer-alt" style="font-size: 1.1rem; margin-right: 0.5rem;"></i>
                <span style="font-size: 1.1rem;">لوحة التحكم</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        {{-- <!-- Heading -->
        <div class="sidebar-heading text-right text-white h3" style="font-size: 1.3rem">
            الموظفين
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed text-right" href="#" data-toggle="collapse" data-target="#taTpDropDown"
                aria-expanded="true" aria-controls="taTpDropDown">
                <span>تحكم بالموظفين</span>
                <i class="fas fa-user-alt"></i>
            </a>
            <div id="taTpDropDown" class="collapse text-right" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">تحكم بالموظفين:</h6>
                    <a class="collapse-item" href="{{ route('users.index') }}">بيانات</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider"> --}}

        <!-- Heading -->
        {{-- <div class="sidebar-heading text-right text-right text-white" style="font-size: 1.3rem">
            الإنتخابات
        </div> --}}

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item text-right">
            <a class="nav-link collapsed text-right" href="#" data-toggle="collapse" data-target="#election"
                aria-expanded="true" aria-controls="taTpDropDown">
                <span style="font-size: 1.1rem">الإنتخابات</span>
                <i class="fas fa-user-alt"></i>
            </a>
            <div id="election" class="collapse text-right" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">تحكم بالإنتخابات:</h6>
                    <a class="collapse-item" href="{{ route('teamLeaders.index') }}">المسئولين</a>
                    <a class="collapse-item" href="{{ route('electoralCenters.index') }}">مراكز اللإقتراع</a>
                    <a class="collapse-item" href="{{ route('individuals.index') }}">الأفراد</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

{{--
        @hasrole('Admin')
        <!-- Heading -->
        <div class="sidebar-heading text-right text-right text-white" style="font-size: 1.3rem">
            قسم المدير
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed text-right" href="#" data-toggle="collapse" data-target="#collapsePages"
                aria-expanded="true" aria-controls="collapsePages">
                <span>سيد</span>
                <i class="fas fa-fw fa-folder"></i>
            </a>
            <div id="collapsePages" class="collapse text-right" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">وظائف و الصلاحيات</h6>
                    <a class="collapse-item" href="{{ route('roles.index') }}">الوظائف</a>
                    <a class="collapse-item" href="{{ route('permissions.index') }}">الصلاحيات</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
        @endhasrole --}}

        <li class="nav-item">
            <a class="nav-link text-right" href="#" data-toggle="modal" data-target="#logoutModal">
                <span>تسجيل خروج</span>
                <i class="fas fa-sign-out-alt"></i>

            </a>
        </li>
</ul>
