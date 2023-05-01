<tr style="font-size: 15px;" class="{{ $inscricao->data_final < now() ? 'evento-disabled' : '' }}">
    <td>{{ $inscricao->eventos_id }}</td>
    <td>{{ $inscricao->nome }}</td>
    <td>{{ Carbon\Carbon::parse($inscricao->data_inicial)->format('d/m/Y') }}</td>
    <td>{{ Carbon\Carbon::parse($inscricao->data_final)->format('d/m/Y') }}</td>
    <td class="text-center">
        <form method="POST" action="{{ route('inscricao.destroy', ['inscricao' => $inscricao->inscricao_id]) }}">
            @csrf
            @method('DELETE')
            <button type="submit" title="Desfazer Inscrição" class="btn btn-danger" style="font-size: smaller;" {{ $inscricao->data_final < now() ? 'disabled' : '' }}>
                <i class="fa-regular fa-calendar-minus"></i>
            </button>
        </form>
    </td>
</tr>

<style>
    .table td, .table th {
        padding: 0.25rem;
    }
    .evento-disabled {
        color: #212529;
        background-color: rgba(0,0,0,.075);
    }
</style>