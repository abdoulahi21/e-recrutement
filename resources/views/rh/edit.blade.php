@extends('layouts.admin.template')

@section('content')
<div class="content">
    <div class="container-fluid">
        <a class="btn" href="{{ route('rh.index') }}">
        <span class="btn-label">
            <i class="material-icons">keyboard_arrow_left</i>
        </span>
            Retour
        </a>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">mail_outline</i>
                        </div>
                        <h4 class="card-title">Modifier l'offre</h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('rh.update', $offers->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputName" class="bmd-label-floating">Titre *</label>
                                    <input type="text" name="title" class="form-control" id="inputName" value="{{ $offers->title}}" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputType" class="bmd-label-floating">Type *</label>
                                    <select name="type" class="form-control" id="inputType" required>
                                        <option></option>
                                        <option value="stage" {{ $offers->type == 'stage' ? 'selected' : '' }}>Stage</option>
                                        <option value="emploi" {{ $offers->type == 'emploi' ? 'selected' : '' }}>Emploi</option>
                                        <option value="alternance" {{ $offers->type == 'alternance' ? 'selected' : '' }}>Alternance</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="exampleEmail" class="bmd-label-floating">Description *</label>
                                    <input type="text" class="form-control" name="description" id="exampleEmail" value="{{ $offers->description}}" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="examplePass" class="bmd-label-floating">Date de fin</label>
                                    <input type="date" name="end_date" class="form-control datepicker" value="{{  \Carbon\Carbon::parse($offers->end_date)->format('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-check ml-3">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="status" value="active" {{ $offers->status == 'active' ? 'checked' : '' }}>
                                        Publier
                                        <span class="form-check-sign"><span class="check"></span></span>
                                    </label>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-fill btn-rose">Mettre à jour</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

