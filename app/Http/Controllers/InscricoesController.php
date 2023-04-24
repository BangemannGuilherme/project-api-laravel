<?php

namespace App\Http\Controllers;

use App\Models\Eventos;
use App\Models\Inscricoes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $inscricoes = Inscricoes::select('inscricoes.id as inscricao_id', 'inscricoes.eventos_id as eventos_id', 'eventos.*')
            ->join('eventos', 'eventos.id', '=', 'inscricoes.eventos_id')
            ->whereIn('eventos.id', $eventos_id)
            ->get();

        return view('inscricoes.index', compact('inscricoes'));
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
        $inscricao->delete();
        return back()->with('success', 'Inscrição removida com sucesso!');
    }
}
