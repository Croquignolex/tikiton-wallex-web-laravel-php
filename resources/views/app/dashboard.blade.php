<a class="nav-link" href="javascript: void(0);"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="fa fa-power-off"></i>
    Deconnexion
</a>
<form id="logout-form" action="{{ locale_route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>