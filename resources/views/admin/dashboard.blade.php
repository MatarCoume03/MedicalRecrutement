@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Tableau de Bord Administrateur</h1>
    
    <div class="row mb-4">
        <!-- Statistiques -->
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Candidats</h5>
                    <p class="card-text display-4">{{ $stats['candidats'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Recruteurs</h5>
                    <p class="card-text display-4">{{ $stats['recruteurs'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Offres</h5>
                    <p class="card-text display-4">{{ $stats['offres'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title">Offres en attente</h5>
                    <p class="card-text display-4">{{ $stats['offres_en_attente'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Offres en attente -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Offres en attente de validation</h5>
        </div>
        <div class="card-body">
            @if($offresEnAttente->isEmpty())
                <p>Aucune offre en attente de validation.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Recruteur</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($offresEnAttente as $offre)
                                <tr>
                                    <td>{{ $offre->titre }}</td>
                                    <td>{{ $offre->user->recruteurProfil->entreprise ?? 'N/A' }}</td>
                                    <td>{{ $offre->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.offres.validate', $offre) }}" class="btn btn-sm btn-success">Valider</a>
                                        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#rejectModal{{ $offre->id }}">Rejeter</button>
                                        
                                        <!-- Modal pour rejet -->
                                        <div class="modal fade" id="rejectModal{{ $offre->id }}" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin.offres.reject', $offre) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Rejeter l'offre</h5>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label>Raison du rejet</label>
                                                                <textarea name="raison" class="form-control" required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                            <button type="submit" class="btn btn-danger">Confirmer</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection