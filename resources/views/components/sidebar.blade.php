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
            <a href="#"><i class="fas fa-file-contract"></i>Subscription</a>
            <i class="fas fa-chevron-left"></i>
        </li>
        <ul class="dropdown collapse" id="subs">
            <li><a href="{{ route('subs-add-form') }}"><i class="fas fa-user-plus"></i>Add</a></li>
            <li><a href="{{ route('subs-select-view') }}"><i class="fas fa-cog"></i>Manage</a></li>
        </ul>
        <li class="dropdown-btn" data-toggle="collapse" data-target="#user-subs" role="button" aria-expanded="false" aria-controls="properties">
            <a href="#"><i class="fas fa-archive"></i>User Subscription</a>
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
            <a href="#"><i class="fas fa-thumbs-up"></i>Approval</a>
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
            <a href="{{ route('tenants-view') }}"><i class="fas fa-handshake"></i>Tenant</a>
        </li>
        <li class="title">Teritories</li>
        <li class="dropdown-btn" data-toggle="collapse" data-target="#country" role="button" aria-expanded="false" aria-controls="properties">
            <a href="#"><i class="fas fa-map"></i>Country</a>
            <i class="fas fa-chevron-left"></i>
        </li>
        <ul class="dropdown collapse" id="country">
            <li><a href="{{ route('Country.index') }}"><i class="fas fa-plus"></i>Add</a></li>
            <li><a href="{{ route('Country.select') }}"><i class="fas fa-cog"></i>Manage</a></li>
        </ul>
        <li class="dropdown-btn" data-toggle="collapse" data-target="#states" role="button" aria-expanded="false" aria-controls="properties">
            <a href="#"><i class="fas fa-map"></i>States</a>
            <i class="fas fa-chevron-left"></i>
        </li>
        <ul class="dropdown collapse" id="states">
            <li><a href="{{ route('stateIndex') }}"><i class="fas fa-plus"></i>Add</a></li>
            <li><a href="{{ route('stateManage') }}"><i class="fas fa-cog"></i>Manage</a></li>
        </ul>
        <li class="dropdown-btn" data-toggle="collapse" data-target="#city" role="button" aria-expanded="false" aria-controls="properties">
            <a href="#"><i class="fas fa-city"></i>City</a>
            <i class="fas fa-chevron-left"></i>
        </li>
        <ul class="dropdown collapse" id="city">
            <li><a href="{{ route('cityIndex') }}"><i class="fas fa-plus"></i>Add</a></li>
            <li><a href="{{ route('cityManage') }}"><i class="fas fa-cog"></i>Manage</a></li>
        </ul>
        <li class="title">Currency</li>
        <li class="dropdown-btn" data-toggle="collapse" data-target="#currency" role="button" aria-expanded="false" aria-controls="properties">
            <a href="#"><i class="fas fa-dollar-sign"></i>Curreny</a>
            <i class="fas fa-chevron-left"></i>
        </li>
        <ul class="dropdown collapse" id="currency">
            <li><a href="{{ route('currencyIndex') }}"><i class="fas fa-plus"></i>Add</a></li>
            <li><a href="{{ route('currencyManage') }}"><i class="fas fa-cog"></i>Manage</a></li>
        </ul>
        <li class="dropdown-btn" data-toggle="collapse" data-target="#tendent" role="button" aria-expanded="false" aria-controls="tendent">
            <a href="{{ route('SocialManage') }}"><i class="fas fa-link"></i>Social Links</a>
        </li>
        <li class="title">Advertisement</li>
        <li class="dropdown-btn" data-toggle="collapse" data-target="#ads" role="button" aria-expanded="false" aria-controls="properties">
            <a href="#"><i class="fas fa-home"></i> Ads</a>
            <i class="fas fa-chevron-left"></i>
        </li>
        <ul class="dropdown collapse" id="ads">
            <li><a href="{{ route('adds.index') }}"><i class="fas fa-user-plus"></i>Add</a></li>
            <li><a href="{{ route('add.manage') }}"><i class="fas fa-users-cog"></i>Manage</a></li>
        </ul>
    </ul>
</div>
