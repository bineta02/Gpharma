@extends('layouts.app')

@section('content')
<main id="main" class="main">

  <div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
      <h1>Nouvelle Vente (Caisse)</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('ventes.index') }}">Ventes</a></li>
          <li class="breadcrumb-item active">Ajouter</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('ventes.index') }}" class="btn btn-secondary">
      <i class="bi bi-arrow-left me-1"></i> Liste des ventes
    </a>
  </div>

  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-octagon me-1"></i>
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <section class="section">
    <form action="{{ route('ventes.store') }}" method="POST" id="form-vente">
      @csrf
      <div class="row">
        
      <div class="row mb-4">
  <label for="id_client" class="col-sm-2 col-form-label fw-bold">Client</label>
  <div class="col-sm-10">
    <select name="id_client" id="id_client" class="form-select">
      <option value="">-- Client anonyme (Comptoir) --</option>
      @foreach($clients as $client)
        <option value="{{ $client->id }}">
          {{ $client->prenom }} {{ $client->nom }} {{ $client->telephone ? '('.$client->telephone.')' : '' }}
        </option>
      @endforeach
    </select>
  </div>
</div>
        <!-- SELECTION PRODUITS -->
        <div class="col-lg-7">
          <div class="card">
            <div class="card-body pt-3">
              <h5 class="card-title">Sélectionner les Médicaments</h5>
              
              <div class="mb-3">
                <div class="input-group">
                  <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                  <input type="text" id="search-pos" class="form-control" placeholder="Rechercher par nom ou code...">
                </div>
              </div>

              <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                <table class="table table-hover align-middle" id="table-produits">
                  <thead class="table-light sticky-top">
                    <tr>
                      <th>Désignation</th>
                      <th class="text-end">Prix</th>
                      <th class="text-center">Stock</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($produits as $produit)
                      <tr class="produit-row" data-id="{{ $produit->id }}" data-nom="{{ $produit->nom }}" data-prix="{{ $produit->prix }}" data-stock="{{ $produit->stock_max }}">
                        <td>
                          <span class="fw-bold text-dark">{{ $produit->nom }}</span>
                          <br><small class="text-muted">Code: {{ $produit->code ?? 'N/A' }}</small>
                        </td>
                        <td class="text-end fw-bold text-primary">{{ number_format($produit->prix, 0, ',', ' ') }} F</td>
                        <td class="text-center">
                          <span class="badge {{ $produit->stock_max < 10 ? 'bg-danger' : 'bg-light text-dark' }}">
                            {{ $produit->stock_max }}
                          </span>
                        </td>
                        <td class="text-center">
                          <button type="button" class="btn btn-success btn-sm btn-add-panier">
                            <i class="bi bi-plus-lg"></i>
                          </button>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

            </div>
          </div>
        </div>

        <!-- PANIER (POS) -->
        <div class="col-lg-5">
          <div class="card">
            <div class="card-body pt-3">
              <h5 class="card-title">Panier de Caisse</h5>

              <div class="table-responsive mb-3" style="max-height: 250px; overflow-y: auto;">
                <table class="table align-middle" id="table-panier">
                  <thead class="table-light">
                    <tr>
                      <th>Produit</th>
                      <th class="text-center" style="width: 30%;">Qté</th>
                      <th class="text-end">Total</th>
                      <th class="text-center"></th>
                    </tr>
                  </thead>
                  <tbody id="panier-items">
                    <tr id="panier-vide">
                      <td colspan="4" class="text-center py-4 text-muted">
                        <i class="bi bi-cart-x fs-4 d-block mb-1"></i> Panier vide
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="bg-light p-3 rounded mb-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="fw-bold text-secondary">TOTAL À PAYER :</span>
                  <span class="fs-4 fw-bold text-dark" id="total-brut">0 F</span>
                </div>
                <hr class="my-2">
                <div class="mb-2">
                  <label for="montant_recu" class="form-label fw-bold text-muted small mb-1">MONTANT REÇU (F) :</label>
                  <input type="number" name="montant_recu" id="montant_recu" class="form-control form-control-lg fw-bold text-end" placeholder="0" min="0" required disabled>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2">
                  <span class="fw-bold text-secondary">RENDU MONNAIE :</span>
                  <span class="fs-4 fw-bold text-success" id="rendu-monnaie">0 F</span>
                </div>
              </div>

              <button type="submit" class="btn btn-primary btn-lg w-100" id="btn-valider-vente" disabled>
                <i class="bi bi-check-circle me-1"></i> Valider et Facturer
              </button>

            </div>
          </div>
        </div>

      </div>
    </form>
  </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-pos');
    const rows = document.querySelectorAll('.produit-row');
    const panierItems = document.getElementById('panier-items');
    const panierVide = document.getElementById('panier-vide');
    const totalBrutText = document.getElementById('total-brut');
    const montantRecuInput = document.getElementById('montant_recu');
    const renduMonnaieText = document.getElementById('rendu-monnaie');
    const btnValider = document.getElementById('btn-valider-vente');

    let panier = {};

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        rows.forEach(row => {
            const nom = row.getAttribute('data-nom').toLowerCase();
            row.style.display = nom.includes(query) ? '' : 'none';
        });
    });

    document.querySelectorAll('.btn-add-panier').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('.produit-row');
            const id = row.getAttribute('data-id');
            const nom = row.getAttribute('data-nom');
            const prix = parseFloat(row.getAttribute('data-prix'));
            const stock = parseInt(row.getAttribute('data-stock'));

            if (panier[id]) {
                if (panier[id].quantite < stock) {
                    panier[id].quantite++;
                } else {
                    alert('Quantité maximale en stock atteinte !');
                }
            } else {
                panier[id] = { id, nom, prix, stock, quantite: 1 };
            }

            renderPanier();
        });
    });

    function renderPanier() {
        panierItems.innerHTML = '';
        const keys = Object.keys(panier);

        if (keys.length === 0) {
            panierItems.appendChild(panierVide);
            totalBrutText.innerText = '0 F';
            montantRecuInput.value = '';
            montantRecuInput.disabled = true;
            renduMonnaieText.innerText = '0 F';
            btnValider.disabled = true;
            return;
        }

        let totalGlobal = 0;
        let index = 0;

        keys.forEach(id => {
            const item = panier[id];
            const totalItem = item.prix * item.quantite;
            totalGlobal += totalItem;

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>
                    <span class="small fw-bold">${item.nom}</span>
                    <br><small class="text-muted">${item.prix.toLocaleString()} F / u</small>
                    <input type="hidden" name="produits[${index}][id]" value="${item.id}">
                </td>
                <td>
                    <input type="number" name="produits[${index}][quantite]" class="form-control form-control-sm text-center input-qte" data-id="${item.id}" value="${item.quantite}" min="1" max="${item.stock}">
                </td>
                <td class="text-end small fw-bold">${totalItem.toLocaleString()} F</td>
                <td class="text-center">
                    <button type="button" class="btn btn-link text-danger p-0 btn-remove" data-id="${item.id}"><i class="bi bi-x-circle"></i></button>
                </td>
            `;
            panierItems.appendChild(tr);
            index++;
        });

        totalBrutText.innerText = totalGlobal.toLocaleString() + ' F';
        montantRecuInput.disabled = false;
        
        calculerRendu(totalGlobal);
        ecouterEvenementsPanier();
    }

    function ecouterEvenementsPanier() {
        document.querySelectorAll('.input-qte').forEach(input => {
            input.addEventListener('change', function() {
                const id = this.getAttribute('data-id');
                let val = parseInt(this.value);
                const stock = panier[id].stock;

                if (isNaN(val) || val < 1) val = 1;
                if (val > stock) {
                    alert('Stock insuffisant !');
                    val = stock;
                }

                panier[id].quantite = val;
                renderPanier();
            });
        });

        document.querySelectorAll('.btn-remove').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                delete panier[id];
                renderPanier();
            });
        });
    }

    function calculerRendu(total = null) {
        if (total === null) {
            const txt = totalBrutText.innerText.replace(/[^0-9]/g, '');
            total = parseFloat(txt) || 0;
        }

        const recu = parseFloat(montantRecuInput.value) || 0;

        if (recu >= total && total > 0) {
            renduMonnaieText.innerText = (recu - total).toLocaleString() + ' F';
            btnValider.disabled = false;
        } else {
            renduMonnaieText.innerText = '0 F';
            btnValider.disabled = true;
        }
    }

    montantRecuInput.addEventListener('input', () => calculerRendu());
});
</script>
@endsection