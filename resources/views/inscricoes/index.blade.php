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
        <div class="text-right col-md-12 mb-2" id="sync_checkins" style="display: none;">
            <button type="button" title="Sincronizar Checkins" onclick="sincronizarCheckin()" class="btn btn-warning btn-sm"><i class="fa fa-sync"></i> Sincronizar checkins</button>
        </div>
        <div class="table-responsive no-padding">
            <div class="dataTables_wrapper no-footer">
                <table id="inscricao_table" class="table table-bordered table-datatable" role="grid">
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

<script>
    window.onload = function() {
        verificarCheckins();
    };

    function verificarCheckins() {
        let inscricoes = {{ $inscricoes->pluck('inscricao_id') }};
        inscricoes.forEach(function(item) {
            // Verifica se existe um objeto no localStorage com a chave "myObject"
            if (localStorage.getItem("myObject_" + item) !== null) {
                $('#sync_checkins').show();
                $('#act_check_' + item).replaceWith('<td class="text-center"><button type="button" title="Sincronizar checkins" class="btn btn-warning btn-sm"><i class="fa fa-exclamation-triangle"></i> Sincronize seus checkins!</button></td>')
            }
        });
    }

    function sincronizarCheckin() {
        let inscricoes = {{ $inscricoes->pluck('inscricao_id') }};

        inscricoes.forEach(function(item) {
            if (localStorage.getItem("myObject_" + item) !== null) {
                const myObject = JSON.parse(localStorage.getItem("myObject_" + item));
                realizarCheckin(myObject.inscricao);

                localStorage.removeItem("myObject_" + item);
            }
        });

        window.location.reload(true);
    }
</script>
@endsection