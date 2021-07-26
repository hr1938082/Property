<div  class="col-lg-2 col-md-3 bg-dark" id="sidebar">
    <ul>
        <li class="profile justify-content-center text-center d-block d-lg-none">
            <div >
                <span id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"class="dropdown">
                    {{-- <img src="{{ asset('storage/images/model.jpg') }}" alt="profile"> --}}
                </span>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Profile</a>
                    <a class="dropdown-item" href="#">Logout</a>
                </div>
            </div>

        </li>
        <li><a href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
        <li class="title">User</li>
        <li class="dropdown-btn" data-toggle="collapse" data-target="#user" role="button" aria-expanded="false" aria-controls="user">
            <a href="#"><i class="fas fa-users"></i>Users</a>
            <i class="fas fa-chevron-left"></i>
        </li>
        <ul class="dropdown collapse" id="user">
            <li><a href="{{ route('userform') }}"><i class="fas fa-user-plus"></i>Add</a></li>
            <li><a href="{{ route('manageuser') }}"><i class="fas fa-users-cog"></i>Manage</a></li>
        </ul>
        <li class="title">Subscription</li>
        <li class="dropdown-btn" data-toggle="collapse" data-target="#subs" role="button" aria-expanded="false" aria-controls="properties">
            <a href="#"><i class="fas fa-archive"></i>Subscription</a>
            <i class="fas fa-chevron-left"></i>
        </li>
        <ul class="dropdown collapse" id="subs">
            <li><a href="{{ route('subs-add-form') }}"><i class="fas fa-user-plus"></i>Add</a></li>
            <li><a href="{{ route('subs-select-view') }}"><i class="fas fa-cog"></i>Manage</a></li>
        </ul>
        <li class="dropdown-btn" data-toggle="collapse" data-target="#user-subs" role="button" aria-expanded="false" aria-controls="properties">
            <a href="#"><i class="fas fa-archive"></i>User</a>
            <i class="fas fa-chevron-left"></i>
        </li>
        <ul class="dropdown collapse" id="user-subs">
            <li><a href="{{ route('user-subs-view') }}"><i class="fas fa-cog"></i>Manage</a></li>
        </ul>
        <li class="dropdown-btn" data-toggle="collapse" data-target="#pay-met" role="button" aria-expanded="false" aria-controls="properties">
            <a href="#"><i class="fas fa-money-bill-alt"></i>Pay Methods</a>
            <i class="fas fa-chevron-left"></i>
        </li>
        <ul class="dropdown collapse" id="pay-met">
            <li><a href="{{ route('pay-met-view') }}"><i class="fas fa-cog"></i>Manage</a></li>
        </ul>
        <li class="dropdown-btn" data-toggle="collapse" data-target="#approval" role="button" aria-expanded="false" aria-controls="properties">
            <a href="#"><i class="fas fa-money-bill-alt"></i>Approval</a>
            <i class="fas fa-chevron-left"></i>
        </li>
        <ul class="dropdown collapse" id="approval">
            <li><a href="{{ route('user-subs-approval-view') }}"><i class="fas fa-cog"></i>Manage</a></li>
        </ul>
        <li class="title">Property</li>
        <li class="dropdown-btn" data-toggle="collapse" data-target="#properties" role="button" aria-expanded="false" aria-controls="properties">
            <a href="#"><i class="fas fa-home"></i>Properties</a>
            <i class="fas fa-chevron-left"></i>
        </li>
        <ul class="dropdown collapse" id="properties">
            <li><a href="{{ route('add-properties') }}"><i class="fas fa-user-plus"></i>Add</a></li>
            <li><a href="{{ route('manage-properties') }}"><i class="fas fa-users-cog"></i>Manage</a></li>
        </ul>
        <li class="dropdown-btn" data-toggle="collapse" data-target="#tendent" role="button" aria-expanded="false" aria-controls="tendent">
            <a href="{{ route('tenants-view') }}"><i class="fas fa-handshake"></i>Tendent</a>
        </li>
    </ul>
</div>
