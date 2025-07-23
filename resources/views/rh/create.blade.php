@extends('layouts.admin.template')
@section('content')
    <div class="container-fluid">
        <a class="btn" href="{{route('rh.index')}}">
                      <span class="btn-label">
                        <i class="material-icons">keyboard_arrow_left</i>
                      </span>
            Retour
        </a>
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">mail_outline</i>
                        </div>
                        <h4 class="card-title">Formulaire</h4>
                    </div>
                    <div class="card-body ">
                        <form method="post" action="{{route('rh.store')}}" >
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputName" class="bmd-label-floating">Title *</label>
                                    <input type="text" name="title" class="form-control" id="inputName" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputType" class="bmd-label-floating">Type *</label>
                                    <select type="text" name="type" class="form-control" id="inputType" required>
                                        <option></option>
                                        <option value="stage">Stage</option>
                                        <option value="emploi">Emploi</option>
                                        <option value="alternance">Alternance</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="exampleEmail" class="bmd-label-floating">Description *</label>
                                    <input type="text" class="form-control" name="description" id="exampleEmail" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="examplePass" class="bmd-label-floating"></label>
                                    <input type="date" name="end_date" class="form-control datepicker" value="10/06/2018">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="examplePass" class="bmd-label-floating">Status</label>
                                        <select type="text" name="status" class="form-control" id="inputType" required>
                                            <option></option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>

                                </div>
                            </div>
                            <div class="card-footer ">
                                <button type="submit" class="btn btn-fill btn-rose" >Valider</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
