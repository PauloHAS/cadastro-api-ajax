<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="/">API</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-auto">
        <li @if($current == "home")class="nav-item active" @else class="nav-item" @endif>
          <a class="nav-link" href="/">Home </a>
        </li>
        <li @if ($current == "produtos") class="nav-item active" @else class="nav-item" @endif>
          <a class="nav-link" href="/produtos">Produtos</a>
        </li>
        <li @if ($current == "categorias") class="nav-item active" @else class="nav-item" @endif>
          <a class="nav-link" href="/categorias">Categorias</a>
        </li>

      </ul>

    </div>
  </nav>