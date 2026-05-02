<?php

namespace App\Http\Controllers;

use App\Models\Pagina;
use App\Models\Configuracao;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->get('busca');

        $paginas = Pagina::publicadas()
            ->artigos()
            ->when($busca, fn ($q) => $q->where('titulo', 'like', "%{$busca}%")
                                        ->orWhere('resumo', 'like', "%{$busca}%")
                                        ->orWhere('conteudo', 'like', "%{$busca}%"))
            ->orderByDesc('publicado_em')
            ->paginate(12)
            ->withQueryString();

        $recentes = Pagina::publicadas()->artigos()
            ->orderByDesc('publicado_em')
            ->limit(3)->get();

        return view('blog.index', compact('paginas', 'busca', 'recentes'));
    }

    public function show(string $slug)
    {
        $pagina = Pagina::publicadas()
            ->where('slug', $slug)
            ->firstOrFail();

        $pagina->incrementarVisualizacoes();

        $recentes = Pagina::publicadas()->artigos()
            ->where('id', '!=', $pagina->id)
            ->orderByDesc('publicado_em')
            ->limit(4)->get();

        return view('blog.show', compact('pagina', 'recentes'));
    }
}
