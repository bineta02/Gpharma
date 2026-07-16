<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="#" class="logopharma d-flex align-items-center text-decoration-none">
        <img src="{{ asset('assets/img/logo.jpeg') }}" alt="" width="50px" class="me-2">
        <span class="d-none d-lg-block fs-4 fw-bold text-success">G-Pharma</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Rechercher..." title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div>

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <!-- Reste du Header (Profil & Déconnexion) inchangé -->
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
<!-- Remplace l'ancienne ligne du genre : -->
<!-- <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle"> -->

<!-- Par celle-ci : -->
<img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">            <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name ?? 'K. Anderson' }}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ Auth::user()->name ?? 'Bineta Ndoye' }}</h6>
              <span>Pharmacienne</span>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Se déconnecter</span>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </header>

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
  <a class="nav-link" href="{{ route('dashboard') }}">
    <i class="bi bi-grid"></i>
    <span>Tableau de bord</span>
  </a>
</li>

      @if(Auth::user()->hasRole(['admin', 'manager']))
      
      <!-- Module 1 : Catégories -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#categories-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-tags"></i><span>Catégories</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="categories-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <!-- Dans votre aside #sidebar -->
<li>
  <a href="{{ route('categories.index') }}">
    <i class="bi bi-circle"></i><span>Liste des catégories</span>
  </a>
</li>
          <li>
            <a href="{{ route('categories.create') }}">
              <i class="bi bi-circle"></i><span>Créer une catégorie</span>
            </a>
          </li>
        </ul>
      </li>

      <!-- Module 2 : Produits -->
      <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('produits.*') ? '' : 'collapsed' }}" data-bs-target="#produits-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-box"></i><span>Produits</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="produits-nav" class="nav-content collapse {{ request()->routeIs('produits.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        <li>
            <a href="{{ route('produits.index') }}" class="{{ request()->routeIs('produits.index') ? 'active' : '' }}">
                <i class="bi bi-circle"></i><span>Liste des médicaments</span>
            </a>
        </li>
        <li>
            <a href="{{ route('produits.create') }}" class="{{ request()->routeIs('produits.create') ? 'active' : '' }}">
                <i class="bi bi-circle"></i><span>Ajouter un produit</span>
            </a>
        </li>
    </ul>
</li>

      <!-- Module 3 : Achats -->
      <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('achats.*') ? '' : 'collapsed' }}" data-bs-target="#achats-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-cart"></i><span>Achats</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="achats-nav" class="nav-content collapse {{ request()->routeIs('achats.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        <li>
            <a href="{{ route('achats.index') }}" class="{{ request()->routeIs('achats.index') ? 'active' : '' }}">
                <i class="bi bi-circle"></i><span>Liste des achats</span>
            </a>
        </li>
        <li>
            <a href="{{ route('achats.create') }}" class="{{ request()->routeIs('achats.create') ? 'active' : '' }}">
                <i class="bi bi-circle"></i><span>Enregistrer un achat</span>
            </a>
        </li>
    </ul>
</li>
      <!-- Module 4 : Ventes -->
      <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('ventes.*') ? '' : 'collapsed' }}" data-bs-target="#ventes-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-cart"></i><span>Ventes</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="ventes-nav" class="nav-content collapse {{ request()->routeIs('ventes.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        <li>
            <a href="{{ route('ventes.index') }}" class="{{ request()->routeIs('ventes.index') ? 'active' : '' }}">
                <i class="bi bi-circle"></i><span>Liste des ventes</span>
            </a>
        </li>
        <li>
            <a href="{{ route('ventes.create') }}" class="{{ request()->routeIs('ventes.create') ? 'active' : '' }}">
                <i class="bi bi-circle"></i><span>Ajouter une vente</span>
            </a>
        </li>
    </ul>
</li>

      <!-- Module 5 : Fournisseurs -->
      <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('fournisseurs.*') ? '' : 'collapsed' }}" data-bs-target="#fournisseurs-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-gem"></i><span>Fournisseurs</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="fournisseurs-nav" class="nav-content collapse {{ request()->routeIs('fournisseurs.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        <li>
            <a href="{{ route('fournisseurs.index') }}" class="{{ request()->routeIs('fournisseurs.index') ? 'active' : '' }}">
                <i class="bi bi-circle"></i><span>Liste des fournisseurs</span>
            </a>
        </li>
        <li>
            <a href="{{ route('fournisseurs.create') }}" class="{{ request()->routeIs('fournisseurs.create') ? 'active' : '' }}">
                <i class="bi bi-circle"></i><span>Ajouter un fournisseur</span>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
  <a class="nav-link collapsed" data-bs-target="#clients-nav" data-bs-toggle="collapse" href="#">
    <i class="bi bi-people"></i><span>Clients</span><i class="bi bi-chevron-down ms-auto"></i>
  </a>
  <ul id="clients-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
    <li>
      <a href="{{ route('clients.index') }}">
        <i class="bi bi-circle"></i><span>Liste des clients</span>
      </a>
    </li>
    <li>
      <a href="{{ route('clients.create') }}">
        <i class="bi bi-circle"></i><span>Ajouter un client</span>
      </a>
    </li>
  </ul>
</li><!-- End Clients Nav -->
      @endif

      <li class="nav-heading">Pages</li>
     
      <li class="nav-item">
    <a class="nav-link {{ Route::is('rapports.index') ? '' : 'collapsed' }}" href="{{ route('rapports.index') }}">
        <i class="bi bi-bar-chart"></i>
        <span>Rapports</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ Route::is('profil.show') ? '' : 'collapsed' }}" href="{{ route('profil.show') }}">
        <i class="bi bi-person"></i>
        <span>Mon Profil</span>
    </a>
</li>
     
      @if(Auth::user()->isAdmin())
      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-shield-lock"></i>
          <span>Contrôle d'accès</span>
        </a>
      </li>

      <li class="nav-item">
        <li class="nav-item">
    <a class="nav-link {{ Route::is('users.*') ? '' : 'collapsed' }}" href="{{ route('users.index') }}">
        <i class="bi bi-people"></i>
        <span>Utilisateurs</span>
    </a>
</li>
      </li>

      <!-- Onglet Journal d'activité -->
<li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('logs.index') }}">
        <i class="bi bi-file-earmark-text"></i>
        <span>Journal d'activité</span>
    </a>
</li><!-- End Activity Logs Nav -->

      

      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-gear"></i>
          <span>Paramètres</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-save"></i>
          <span>Sauvegarder</span>
        </a>
      </li>
      @endif

    </ul>
  </aside><!-- End Sidebar-->

  <!-- Section principale dynamique Laravel -->
  @yield('content')
 
  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Binette</span></strong>. Tous droits réservés
    </div>
  </footer>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/chart.js/chart.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
  <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

</body>
</html>