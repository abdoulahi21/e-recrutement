@extends('layouts.admin.template')
@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Listes des offres</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Offre</th>
                                    <th>Candidat</th>
                                    <th>Message</th>
                                    <th>Cv</th>
                                    <th>Status</th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Offre</th>
                                    <th>Candidat</th>
                                    <th>Message</th>
                                    <th>Cv</th>
                                    <th>Status</th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <tbody>
                                @foreach($offers as $offer)
                                    @forelse($offer->candidates as $candidate)
                                        <tr>
                                            <td>{{ $offer->title }}</td>
                                            <td>{{ $candidate->name }}</td>
                                            <td>{{ $candidate->pivot->message ?? '—' }}</td>
                                            <td>
                                                @if($candidate->pivot->cv)
                                                    <a href="{{ asset('storage/cv/'.$candidate->pivot->cv) }}" target="_blank">Voir le CV</a>
                                                @else
                                                    Aucun CV
                                                @endif
                                            </td>
                                            <td>
                                            <span class="badge badge-{{ $candidate->pivot->status == 'accepté' ? 'success' : ($candidate->pivot->status == 'refusé' ? 'danger' : 'secondary') }}">
                                                {{ ucfirst($candidate->pivot->status ?? 'en attente') }}
                                            </span>
                                            </td>
                                            <td class="text-right">
                                                <!-- Boutons actions ici si besoin -->
                                                <a href="#" class="btn btn-sm btn-success">Accepter</a>
                                                <a href="#" class="btn btn-sm btn-danger">Refuser</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">Aucune candidature reçue pour l'offre : {{ $offer->title }}</td>
                                        </tr>
                                    @endforelse
                                @endforeach
                                </tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


