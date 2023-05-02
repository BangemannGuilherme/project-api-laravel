@extends('master')

@section('breadcrumb', 'Checkins')

@section('title', 'Checkins')

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
                <table id="inscricao_table" class="table table-bordered table-datatable" role="grid">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Checkin realizado em</th>
                        </tr>
                    </thead>
                    <tbody>
                        @each('inscricoes.checkin', $inscricoes, 'inscricao')
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection