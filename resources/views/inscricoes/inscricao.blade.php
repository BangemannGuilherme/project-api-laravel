<tr style="font-size: 15px;" class="{{ $inscricao->data_final < now() ? 'evento-disabled' : '' }}">
    <td>{{ $inscricao->eventos_id }}</td>
    <td>{{ $inscricao->nome }}</td>
    <td>{{ Carbon\Carbon::parse($inscricao->data_inicial)->format('d/m/Y') }}</td>
    <td>{{ Carbon\Carbon::parse($inscricao->data_final)->format('d/m/Y') }}</td>
    @if (!$inscricao->checkin)
        <td class="text-center" id="act_check_{{ $inscricao->inscricao_id }}" style="display: flex;justify-content: center;">
            <form method="POST" action="{{ route('inscricao.destroy', ['inscricao' => $inscricao->inscricao_id]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" title="Desfazer Inscrição" class="btn btn-danger" style="font-size: smaller;" {{ $inscricao->data_final < now() ? 'disabled' : '' }}>
                    <i class="fa-regular fa-calendar-minus"></i>
                </button>
            </form>
            <button type="button" title="Realizar Checkin" onclick="realizarCheckin({{ $inscricao->inscricao_id }})" class="btn btn-success ml-2" style="font-size: smaller;" {{ $inscricao->data_final < now() ? 'disabled' : '' }}>
                <i class="fa-regular fa-calendar-check"></i>
            </button>
        </td>
    @else
        <td class="text-center"><button type="button" class="btn btn-primary btn-sm">Checkin OK!</button></td>
    @endif
</tr>

<script>
    function realizarCheckin(id) {
        let inscricao_id = id;

        $('.loading').show();

        $.ajax ({
            url: "{{ route('api.checkin', ['inscricao' => " + inscricao_id + "]) }}",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                "inscricao": inscricao_id
            },
            success: function(result)
            {
                if (result.success) {
                    Swal.fire({
                        title: result.message,
                        html: 'Parabéns! Você realizou o checkin no evento <b>' + result.evento + '</b>!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (localStorage.getItem("myObject_" + inscricao_id) !== null) {
                                localStorage.removeItem("myObject_" + inscricao_id);
                            } else {
                                window.location.reload(true);
                            }
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                if (!navigator.onLine) {
                    alert('Parece que você está sem conexão com a internet.\nSuas informações serão salvas.\nPor favor, quando sua conexão voltar, recarregue a página e sincronize suas informações.');

                    // Armazena as informações em um objeto
                    const myObject = {
                        "_token": "{{ csrf_token() }}",
                        "inscricao": inscricao_id
                    };

                    // Serializa o objeto para JSON
                    const serializedObject = JSON.stringify(myObject);
                    // Armazena o objeto serializado no localStorage
                    localStorage.setItem("myObject_" + inscricao_id, serializedObject);
                }
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