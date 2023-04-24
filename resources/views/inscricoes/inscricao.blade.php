<tr style="font-size: 15px;">
    <td>{{ $inscricao->eventos_id }}</td>
    <td>{{ $inscricao->nome }}</td>
    <td>{{ Carbon\Carbon::parse($inscricao->data_inicial)->format('d/m/Y H:i') }}</td>
    <td>{{ Carbon\Carbon::parse($inscricao->data_final)->format('d/m/Y H:i') }}</td>
    <td class="text-center">
        <form method="POST" action="{{ route('inscricao.destroy', ['inscricao' => $inscricao->inscricao_id]) }}">
            @csrf
            @method('DELETE')
            <button type="submit" title="Desfazer Inscrição" class="btn btn-danger" style="font-size: smaller;">
                <i class="fa fa-trash-alt"></i>
            </button>
        </form>
    </td>
</tr>

<style>
    .table td, .table th {
        padding: 0.25rem;
    }
</style>