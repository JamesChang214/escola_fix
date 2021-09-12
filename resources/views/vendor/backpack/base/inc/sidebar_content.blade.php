<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> Dashboard</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('student?status=Active') }}'><i class='nav-icon la la-users'></i> Students</a></li>
<!-- Finance -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-dollar"></i> Finance</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('invoicepayment') }}'><i class='nav-icon la la-money'></i> Payments</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ route('reconciliation-transaction') }}'><i class='nav-icon la la-check-circle-o'></i> Reconciliation</a></li>
    </ul>
</li>
<!-- Finance Administration -->
@role('super')
<li class="nav-item nav-dropdown">
	<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Finance Admin</a>
	<ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('paymenttype') }}'><i class='nav-icon la la-question'></i> Payment Types</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('invoicepaymentvoid') }}'><i class='nav-icon la la-question'></i> Payment Voids</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('financedeposit') }}'><i class='nav-icon la la-question'></i> Finance Deposits</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('financereconciliation') }}'><i class='nav-icon la la-check-circle-o'></i> Reconciliation Records</a></li>
	</ul>
</li>
@endrole
<!-- Configuration -->
<li class="nav-item nav-dropdown">
	<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Setup</a>
	<ul class="nav-dropdown-items">
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('centre') }}'><i class='nav-icon la la-question'></i> Centres</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('profile') }}'><i class='nav-icon la la-question'></i> Profiles</a></li>
	</ul>
</li>
<!-- Users, Roles, Permissions -->
<li class="nav-item nav-dropdown">
	<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Authentication</a>
	<ul class="nav-dropdown-items">
	  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Users</span></a></li>
	  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
	  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
	</ul>
</li>