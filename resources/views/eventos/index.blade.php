@extends('master')

@section('breadcrumb', 'Eventos')

@section('title', 'Eventos')

@section('content')

<div class="row">
    <div class="col-md-12">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="table-responsive no-padding">
            <div class="dataTables_wrapper no-footer">
                <table id="evento_table" class="table table-hover table-bordered table-datatable table-striped" role="grid">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Criado em</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @each('eventos.evento', $eventos, 'evento')
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection