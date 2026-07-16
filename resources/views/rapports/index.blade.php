@extends('layouts.app') {{-- Remplace par ton layout principal si différent (ex: layouts.master) --}}

@section('content')
<div class="pagetitle">
    <h1>Module Rapports & Statistiques</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
            <li class="breadcrumb-item active">Rapports</li>
        </ol>
    </nav>
</div>

<section class="section dashboard">
    <!-- Barre d'actions d'exportation -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="card-title m-0">Vue d'ensemble des performances</h5>
        <div>
            <button onclick="window.print()" class="btn btn-danger me-2">
                <i class="bi bi-file-earmark-pdf"></i> Exporter en PDF
            </button>
            
<a href="{{ route('rapports.excel') }}" class="btn btn-success">
    <i class="bi bi-file-earmark-excel"></i> Exporter en Excel
</a>
        </div>
    </div>

    <!-- 1. Cartes d'indicateurs (KPIs) -->
    <div class="row">
        <!-- Chiffre d'affaires Mensuel -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Chiffre d'Affaires <span>| Ce mois</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-currency-dollar text-primary"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ number_format($caMois, 0, ',', ' ') }} FCFA</h6>
                            <span class="text-muted small">Aujourd'hui : </span>
                            <span class="text-success small pt-1 fw-bold">{{ number_format($caJour, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Marge & Bénéfices -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card revenue-card">
                <div class="card-body">
                    <h5 class="card-title">Marge brute estimée <span>| Ce mois</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-graph-up-arrow text-success"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ number_format($margeGlobale, 0, ',', ' ') }} FCFA</h6>
                            <span class="text-muted small">Marge nette sur ventes</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Achats Fournisseurs -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">Achats Fournisseurs <span>| Ce mois</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-cart-check text-danger"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ number_format($achatsMois, 0, ',', ' ') }} FCFA</h6>
                            <span class="text-muted small">Investissement stock</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Valeur totale du Stock -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Valeur du Stock <span>| Actuel</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-box-seam text-warning"></i>
                        </div>
                        <div class="ps-3">
                            <h6 class="text-warning">{{ number_format($valeurStock, 0, ',', ' ') }} FCFA</h6>
                            <span class="text-muted small">Total produits : </span>
                            <span class="fw-bold">{{ $totalProduits }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- 2. Graphique de l'évolution des ventes -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Rapport de Ventes <span>/ 7 derniers jours</span></h5>
                    <!-- Div où le graphique ApexCharts s'affichera -->
                    <div id="salesChart"></div>
                </div>
            </div>
        </div>

        <!-- 3. Classement Top Ventes -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Top 5 - Produits les plus vendus</h5>
                    <div class="activity">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th class="text-center">Quantité vendue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topProduits as $top)
                                    <tr>
                                        <td>
                                            <span class="fw-bold text-dark">{{ $top->produit->nom ?? 'Produit inconnu' }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success">{{ $top->total_vendu }} unités</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">Aucune vente enregistrée.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Onglets des rapports de Stock -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body pt-3">
                    <!-- Titres des Onglets -->
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#alertes-stock">
                                Alertes de Stock ({{ $alertesStock->count() }})
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link text-danger" data-bs-toggle="tab" data-bs-target="#produits-epuises">
                                Produits Épuisés ({{ $produitsEpuises->count() }})
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content pt-2">
                        <!-- Onglet Alertes Stock -->
                        <div class="tab-pane fade show active profile-overview" id="alertes-stock">
                            <h5 class="card-title">Médicaments bientôt en rupture</h5>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Nom du médicament</th>
                                        <th>Stock actuel</th>
                                        <th>Prix Vente</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($alertesStock as $produit)
                                        <tr class="table-warning">
                                            <td>{{ $produit->code ?? 'N/A' }}</td>
                                            <td><strong>{{ $produit->nom }}</strong></td>
                                            <td><span class="badge bg-warning text-dark">{{ $produit->stock_max }} restants</span></td>
                                            <td>{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-primary">Réapprovisionner</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-success py-3">Aucune alerte de stock. Tout est sous contrôle !</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Onglet Produits Épuisés -->
                        <div class="tab-pane fade" id="produits-epuises">
                            <h5 class="card-title text-danger">Médicaments en rupture totale</h5>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Nom du médicament</th>
                                        <th>Stock</th>
                                        <th>Prix Vente</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($produitsEpuises as $produit)
                                        <tr class="table-danger">
                                            <td>{{ $produit->code ?? 'N/A' }}</td>
                                            <td><strong>{{ $produit->nom }}</strong></td>
                                            <td><span class="badge bg-danger">0 restants</span></td>
                                            <td>{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-danger">Commander en urgence</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-success py-3">Aucun produit en rupture de stock. Félicitations !</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Script pour le graphique ApexCharts (intégré à NiceAdmin) -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        new ApexCharts(document.querySelector("#salesChart"), {
            series: [{
                name: 'Chiffre d\'Affaires (FCFA)',
                data: {!! json_encode($ventesParJour) !!}
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false
                },
            },
            markers: {
                size: 4
            },
            colors: ['#4154f1'],
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
                    opacityTo: 0.4,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                categories: {!! json_encode($jours) !!}
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + " FCFA"
                    }
                }
            }
        }).render();
    });
</script>
@endsection