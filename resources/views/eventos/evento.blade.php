<tr style="font-size: 15px;">
    <td>{{ $evento->id }}</td>
    <td>{{ $evento->nome }}</td>
    <td>{{ $evento->descricao }}</td>
    <td>{{ Carbon\Carbon::parse($evento->created_at)->format('d/m/Y H:i') }}</td>
    <td class="text-center">
        {{-- <a title="Fazer Inscrição" class="btn btn-success" onclick="realizarInscricao({{ $evento->id }})" style="font-size: smaller;"><i class="fa fa-eye fa-fw"></i></a> --}}
        <form method="POST" action="{{ route('inscricao.store', ['id' => $evento->id]) }}">
            @csrf
            <button type="submit" title="Fazer Inscrição" class="btn btn-success" style="font-size: smaller;">
                <i class="fa fa-eye fa-fw"></i>
            </button>
        </form>
        <a title="Editar evento" class="btn btn-info" href="" style="font-size: smaller;"><i class="fa fa-edit fa-fw"></i></a>
    </td>
</tr>

<script>
    function realizarInscricao(id) {
        let evento_id = id;

        $.ajax ({
            url: {{ route('api.inscricao') }},
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                "id": evento_id
            },
            success: function(result)
            {
                console.log(result);
                // window.location.reload(true);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
</script>

<style>
    .table td, .table th {
        padding: 0.25rem;
    }
</style>