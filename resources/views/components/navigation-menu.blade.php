<nav class="navbar navbar-expand-lg bg-light">
    <div class="container">
      <a class="navbar-brand" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <x-nav-link :active="request()->routeIs('home')" href="{{ route('home') }}">Home</x-nav-link>
            <x-nav-link :active="request()->routeIs('category')" href="{{ route('category') }}">Category</x-nav-link>
            <x-nav-link :active="request()->routeIs('article')" href="{{ route('article') }}">Article</x-nav-link>
        </ul>
      </div>
    </div>
</nav>

  
{{-- <form class="d-flex" role="search">
    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-outline-success" type="submit">Search</button>
</form> --}}