@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Gestion des Compétences</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Catégorie</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($competences as $competence)
                            <tr>
                                <td>{{ $competence->nom }}</td>
                                <td>{{ $competence->categorie ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge badge-{{ $competence->is_validated ? 'success' : 'warning' }}">
                                        {{ $competence->is_validated ? 'Validée' : 'En attente' }}
                                    </span>
                                </td>
                                <td>
                                    @if(!$competence->is_validated)
                                        <form action="{{ route('admin.competences.validate', $competence) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Valider</button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.competences.destroy', $competence) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            {{ $competences->links() }}
        </div>
    </div>
</div>
@endsection