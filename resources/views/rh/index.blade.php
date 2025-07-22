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
                    <a class="btn btn-info float-right" href="{{route('rh.create')}}">Nouvelle offre</a>
                </div>
    <div class="material-datatables">
    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
        <thead>
        <tr>
            <th>Numero</th>
            <th>Titre</th>
            <th>Description</th>
            <th>Type</th>
            <th>Date de publication</th>
            <th>Date de fin</th>
            <th class="disabled-sorting text-right">Actions</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Numero</th>
            <th>Titre</th>
            <th>Description</th>
            <th>Type</th>
            <th>Date de publication</th>
            <th>Date de fin</th>
            <th class="disabled-sorting text-right">Actions</th>
        </tr>
        </tfoot>
        <tbody>
        @foreach($offers as $offer)
            <tr>
                <td>{{ $offer->id }}</td>
                <td>{{ $offer->title }}</td>
                <td>{{ $offer->description }}</td>
                <td>{{ $offer->type}}</td>
                <td>{{$offer->created_at}}</td>
                <td>{{$offer->end_date}}</td>
                <td class="text-right">
                    <form action="{{route('rh.destroy',$offer->id)}}" method="post" class="delete-form d-inline">
                        @csrf
                        @method('DELETE')
                    <a href="{{route('rh.show',$offer->id)}}" class="btn btn-link btn-info btn-just-icon like"><i class="material-icons">favorite</i></a>
                    <a href="{{route('rh.edit',$offer->id)}}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">dvr</i></a>
                    <button type="submit" class="btn btn-link btn-danger btn-just-icon remove btn-delete"><i class="material-icons">close</i></button>
                    </form>
                </td>
            </tr>
        @endforeach
        @section('scripts')
            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Succès',
                        text: '{{ session('success') }}',
                        confirmButtonColor: '#e91e63'
                    });
                </script>
            @endif
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const deleteButtons = document.querySelectorAll('.btn-delete');

                    deleteButtons.forEach(button => {
                        button.addEventListener('click', function (e) {
                            e.preventDefault();

                            const form = this.closest('form');

                            Swal.fire({
                                title: 'Êtes-vous sûr ?',
                                text: "Cette action est irréversible !",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#e91e63',
                                cancelButtonColor: '#aaa',
                                confirmButtonText: 'Oui, supprimer !',
                                cancelButtonText: 'Annuler'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    form.submit();
                                }
                            });
                        });
                    });
                });
            </script>
        @endsection
        </tbody>
    </table>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection
