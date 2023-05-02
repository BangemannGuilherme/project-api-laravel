<tr style="font-size: 15px;">
    <td>{{ $inscricao->eventos_id }}</td>
    <td>{{ $inscricao->nome }}</td>
    <td>{{ Carbon\Carbon::parse($inscricao->hora_checkin)->format('d/m/Y H:i:s') }}</td>
</tr>

<style>
    .table td, .table th {
        padding: 0.25rem;
    }
</style>