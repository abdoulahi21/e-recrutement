@extends('layouts.admin.template')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="col-lg-8 col-md-10 col-sm-12 mx-auto">
                <div class="card card-profile">
                    <div class="card-avatar">
                        <a href="#">
                            <i class="material-icons" style="font-size: 64px; color: #e91e63;">work_outline</i>
                        </a>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title text-rose">{{ $offer->title }}</h4>
                        <h6 class="card-category text-gray">{{ ucfirst($offer->type) }}</h6>
                        <p class="card-description mt-3">
                            {{ $offer->description }}
                        </p>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <strong>Date de création :</strong><br>
                                {{ $offer->created_at->format('d/m/Y') }}
                            </div>
                            <div class="col-md-6">
                                <strong>Date de fin :</strong><br>
                                {{ \Carbon\Carbon::parse($offer->end_date)->format('d/m/Y') }}
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <strong>Statut :</strong><br>
                                <span class="badge badge-{{ $offer->status == 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($offer->status) }}
                            </span>
                            </div>
                            <div class="col-md-6">
                                <strong>Créée par:</strong><br>
                                {{ $offer->user->last_name }} {{ $offer->user->first_name }}
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('rh.edit', $offer->id) }}" class="btn btn-fill btn-warning ">Modifier</a>
                            <a href="{{ route('rh.index') }}" class="btn btn-fill btn-default ">Retour</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
