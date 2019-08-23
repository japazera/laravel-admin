<li class="nav-item {{(Request::routeIs('home')) ? 'active' : ''}}">
	<a class="nav-link" href="{{route('home')}}">
		<i class="fas fa-fw fa-tachometer-alt"></i>
		<span>Dashboard</span>
	</a>
</li>

<li class="nav-item {{ (Request::routeIs('user.index')) ? 'active' : '' }}">
	<a class="nav-link" href="{{route('user.index')}}">
		<i class="fas fa-fw fa-users"></i>
		<span>Usuários</span>
	</a>
</li>
