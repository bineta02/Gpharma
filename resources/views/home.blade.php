@extends('layouts.app')

@section('content')
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card (Médicaments) -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Médicaments <span>| Global</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-capsule"></i>
                    </div>
                    <div class="ps-3">
                      <!-- Reçoit $totalProduits du contrôleur -->
<h6>{{ $totalProduits ?? 0 }}</h6>                      <span class="text-success small pt-1 fw-bold">En stock</span>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card (Ventes) -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Ventes du jour</h6>
                    </li>
                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Ventes <span>| Cumulé</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-exchange"></i>
                    </div>
                    <div class="ps-3">
                      <!-- Reçoit $totalVentes du contrôleur, formaté en FCFA -->
                      <h6>{{ isset($totalVentes) ? number_format($totalVentes, 0, ',', ' ') : '0' }} FCFA</h6>
                      <span class="text-success small pt-1 fw-bold">Chiffre d'affaires</span>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card (Fournisseurs) -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Fournisseurs <span>| Partenaires</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-truck"></i>
                    </div>
                    <div class="ps-3">
                      <!-- Reçoit $totalFournisseurs du contrôleur -->
                      <h6>{{ $totalFournisseurs ?? 0 }}</h6>
                      <span class="text-success small pt-1 fw-bold">Actifs</span>
                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

            <!-- Reports -->
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Reports <span>/Today</span></h5>
                  <div id="reportsChart"></div>
                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                          name: 'Sales',
                          data: [31, 40, 28, 51, 42, 82, 56],
                        }, {
                          name: 'Revenue',
                          data: [11, 32, 45, 32, 34, 52, 41]
                        }, {
                          name: 'Customers',
                          data: [15, 11, 32, 18, 9, 24, 11]
                        }],
                        chart: {
                          height: 350,
                          type: 'area',
                          toolbar: { show: false },
                        },
                        markers: { size: 4 },
                        colors: ['#4154f1', '#2eca6a', '#ff771d'],
                        fill: {
                          type: "gradient",
                          gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                          }
                        },
                        dataLabels: { enabled: false },
                        stroke: { curve: 'smooth', width: 2 },
                        xaxis: {
                          type: 'datetime',
                          categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
                        },
                        tooltip: { x: { format: 'dd/MM/yy HH:mm' }, }
                      }).render();
                    });
                  </script>
                </div>
              </div>
            </div><!-- End Reports -->

            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">
                <div class="card-body">
                  <h5 class="card-title">Recent Sales <span>| Today</span></h5>
                  <table class="table table-borderless datatable">
  <thead>
    <tr>
      <th scope="col"># N° Facture</th>
      <th scope="col">Client</th>
      <th scope="col">Montant</th>
      <th scope="col">Statut</th>
    </tr>
  </thead>
  <tbody>
    @forelse($recentSales as $vente)
      <tr>
        <th scope="row"><a href="#">#{{ $vente->numero_facture }}</a></th>
        <!-- Correction de l'affichage du client -->
        <td>{{ $vente->id_client ? 'Client #' . $vente->id_client : 'Passant' }}</td>
        <td>{{ number_format($vente->montant_total, 0, ',', ' ') }} FCFA</td>
        <td>
          @if($vente->statut == 'complete' || $vente->statut == 'paye')
            <span class="badge bg-success">Payé</span>
          @elseif($vente->statut == 'annule')
            <span class="badge bg-danger">Annulé</span>
          @else
            <span class="badge bg-warning">{{ $vente->statut }}</span>
          @endif
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="4" class="text-center">Aucune vente enregistrée.</td>
      </tr>
    @endforelse
  </tbody>
</table>
                </div>
              </div>
            </div><!-- End Recent Sales -->

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

          <!-- Recent Activity -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Recent Activity <span>| Today</span></h5>
              <div class="activity">
                <div class="activity-item d-flex">
                  <div class="activite-label">32 min</div>
                  <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                  <div class="activity-content">
                    Vente validée par le pharmacien
                  </div>
                </div>
                <div class="activity-item d-flex">
                  <div class="activite-label">56 min</div>
                  <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                  <div class="activity-content">
                    Alerte rupture de stock Doliprane
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Recent Activity -->

          <!-- Website Traffic -->
          <div class="card">
            <div class="card-body pb-0">
              <h5 class="card-title">Website Traffic <span>| Today</span></h5>
              <div id="trafficChart" style="min-height: 400px;" class="echart"></div>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  echarts.init(document.querySelector("#trafficChart")).setOption({
                    tooltip: { trigger: 'item' },
                    legend: { top: '5%', left: 'center' },
                    series: [{
                      name: 'Access From',
                      type: 'pie',
                      radius: ['40%', '70%'],
                      avoidLabelOverlap: false,
                      label: { show: false, position: 'center' },
                      emphasis: { label: { show: true, fontSize: '18', fontWeight: 'bold' } },
                      labelLine: { show: false },
                      data: [
                        { value: 1048, name: 'Ventes Directes' },
                        { value: 735, name: 'Commandes' }
                      ]
                    }]
                  });
                });
              </script>
            </div>
          </div><!-- End Website Traffic -->

        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->
@endsection