<tr style="font-size: 15px;" class="{{ $evento->data_final < now() ? 'evento-disabled' : '' }}">
    <td>{{ $evento->id }}</td>
    <td>{{ $evento->nome }}</td>
    <td>{{ $evento->descricao }}</td>
    <td>{{ Carbon\Carbon::parse($evento->data_inicial)->format('d/m/Y') }}</td>
    <td>{{ Carbon\Carbon::parse($evento->data_final)->format('d/m/Y') }}</td>
    {{-- <td>{{ Carbon\Carbon::parse($evento->created_at)->format('d/m/Y H:i') }}</td> --}}
    <td class="text-center">
        {{-- <a title="Fazer Inscrição" class="btn btn-success" onclick="realizarInscricao({{ $evento->id }})" style="font-size: smaller;"><i class="fa fa-eye fa-fw"></i></a> --}}
        <form method="POST" action="{{ route('inscricao.store', ['id' => $evento->id]) }}">
            @csrf
            <button type="submit" title="{{ $evento->data_final < now() ? 'Evento já ocorreu!' : 'Fazer Inscrição' }}" class="btn btn-success" style="font-size: smaller;" {{ $evento->data_final < now() ? 'disabled' : '' }}>
                <i class="fa-regular fa-calendar-check"></i>
            </button>
        </form>
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
    .evento-disabled {
        color: #212529;
        background-color: rgba(0,0,0,.075);
    }
</style>