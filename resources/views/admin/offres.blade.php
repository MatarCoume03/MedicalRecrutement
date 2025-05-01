@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Gestion des Offres d'Emploi</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Recruteur</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($offres as $offre)
                            <tr>
                                <td>{{ $offre->titre }}</td>
                                <td>{{ $offre->user->recruteurProfil->entreprise ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge badge-{{ $offre->statut === 'approuve' ? 'success' : ($offre->statut === 'rejete' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($offre->statut) }}
                                    </span>
                                </td>
                                <td>{{ $offre->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info">Voir</a>
                                    @if($offre->statut === 'en_attente')
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
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            {{ $offres->links() }}
        </div>
    </div>
</div>
@endsection