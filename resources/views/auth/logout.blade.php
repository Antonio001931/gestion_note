<form action="{{ route('auth.logout')}}" method="post">
                    @method("delete")
                    @csrf
                    <button class="nav-link">Se deconnecte</button>
                 </form>