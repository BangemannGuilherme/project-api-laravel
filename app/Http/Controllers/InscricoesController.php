<?php

namespace App\Http\Controllers;

use App\Mail\MailSender;
use App\Models\Eventos;
use App\Models\Inscricoes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class InscricoesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $eventos_id = $user->inscricoes->pluck('eventos_id')->toArray();
        $inscricoes = Inscricoes::select('inscricoes.id as inscricao_id', 'inscricoes.eventos_id as eventos_id', 'inscricoes.checkin as checkin', 'eventos.*')
            ->join('eventos', 'eventos.id', '=', 'inscricoes.eventos_id')
            ->whereIn('eventos.id', $eventos_id)
            ->get();

        return view('inscricoes.index', compact('inscricoes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = $request->user()->id;
        $evento_id = $request->input('id');

        Inscricoes::create([
            'users_id' => $user_id,
            'eventos_id' => $evento_id,
        ]);

        $evento = Eventos::find($evento_id);

        $details = [
            'title' => 'Inscrição efetuada com sucesso!',
            'body' => "Você realizou a inscrição no seguinte evento:<br><h3>$evento->nome</h3><br>Você pode acompanhar as suas inscrições em <a href=\"http://177.44.248.74/inscricao\">Minhas inscrições</a>."
        ];

        // Envia e-mail
        $this->sendMail($details);

        return back()->with('success', 'Inscrição realizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inscricoes  $inscricoes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inscricoes $inscricao)
    {
        $evento = Eventos::find($inscricao->eventos_id);

        $inscricao->delete();

        $details = [
            'title' => 'Inscrição removida com sucesso!',
            'body' => "Você removeu a sua inscrição do seguinte evento:<br><h3>$evento->nome</h3><br>Você pode acompanhar as suas inscrições em <a href=\"http://177.44.248.74/inscricao\">Minhas inscrições</a>."
        ];

        // Envia e-mail
        $this->sendMail($details);

        return back()->with('success', 'Inscrição removida com sucesso!');
    }

    /**
     * Get checkins.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCheckin()
    {
        $user = Auth::user();
        $eventos_id = $user->inscricoes->pluck('eventos_id')->toArray();
        $inscricoes = Inscricoes::select('inscricoes.id as inscricao_id', 'inscricoes.eventos_id as eventos_id', 'inscricoes.updated_at as hora_checkin', 'eventos.*')
            ->join('eventos', 'eventos.id', '=', 'inscricoes.eventos_id')
            ->where('inscricoes.checkin', true)
            ->whereIn('eventos.id', $eventos_id)
            ->get();

        return view('inscricoes.index_checkin', compact('inscricoes'));
    }

    /**
     * Set checkin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkin(Request  $request)
    {
        $inscricao = Inscricoes::find($request->input('inscricao'));
        $inscricao->checkin = true;
        $inscricao->save();

        $evento = Eventos::find($inscricao->eventos_id);

        $details = [
            'title' => 'Checkin realizado com sucesso!',
            'body' => "Você realizou o checkin no seguinte evento:<br><h3>$evento->nome</h3><br>Você pode acompanhar os seus checkins em <a href=\"http://177.44.248.74/checkin\">Meus checkins</a>."
        ];

        // Envia e-mail
        $this->sendMail($details);

        return [
            'success' => true,
            'message' => 'Checkin realizado com sucesso!',
            'evento' => $evento->nome
        ];
    }

    private function sendMail(Array $details)
    {
        Mail::to('user_receiver_email@gmail.com')->send(new MailSender($details));
    }
}
