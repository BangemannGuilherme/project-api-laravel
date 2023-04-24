@extends('master')

@section('breadcrumb', 'Inscrições')

@section('title', 'Inscrições')

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
                <table id="inscricao_table" class="table table-hover table-bordered table-datatable table-striped" role="grid">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Data inicial</th>
                            <th>Data final</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @each('inscricoes.inscricao', $inscricoes, 'inscricao')
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection