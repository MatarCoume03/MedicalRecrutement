@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Statistiques</h1>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Offres par spécialité</h5>
                </div>
                <div class="card-body">
                    <canvas id="offresChart" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Candidats par ville</h5>
                </div>
                <div class="card-body">
                    <canvas id="candidatsChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Offres par spécialité
    const offresCtx = document.getElementById('offresChart').getContext('2d');
    const offresChart = new Chart(offresCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($offresParSpecialite->pluck('specialite_requise')) !!},
            datasets: [{
                label: 'Nombre d\'offres',
                data: {!! json_encode($offresParSpecialite->pluck('total')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Candidats par ville
    const candidatsCtx = document.getElementById('candidatsChart').getContext('2d');
    const candidatsChart = new Chart(candidatsCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($candidatsParVille->pluck('ville')) !!},
            datasets: [{
                data: {!! json_encode($candidatsParVille->pluck('total')) !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });
</script>
@endsection
@endsection