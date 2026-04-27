<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Http\Requests\ProdutoRequest;
use App\Http\Resources\ProdutoResource;
use Illuminate\Support\Facades\Cache;

class ProdutoController extends ApiController
{
    public function index(Request $request) {
        $cacheKey = 'produtos_' . md5(json_encode($request->all()));

        $produtos = Cache::remember($cacheKey, 60, function () use ($request) {

            $produto = Produto::query();

            $produto->when($request->nome, function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->nome . '%');
            });

            $produto->when($request->preco_min, function ($q) use ($request) {
                $q->where('preco', '>=', $request->preco_min);
            });

            $produto->when($request->preco_max, function ($q) use ($request) {
                $q->where('preco', '<=', $request->preco_max);
            });

            $produto->when($request->quantidade_min, function ($q) use ($request) {
                $q->where('quantidade_estoque', '>=', $request->quantidade_min);
            });

            $produto->when($request->quantidade_max, function ($q) use ($request) {
                $q->where('quantidade_estoque', '<=', $request->quantidade_max);
            });

            return ProdutoResource::collection($produto->get())->resolve();
        });

        return $this->success($produtos, 'Lista de produtos');
    }

    public function store(ProdutoRequest $request) {
        $produto = Produto::create($request->all());

        // Limpar cache
        Cache::flush();

        return $this->success(new ProdutoResource($produto), 'Produto criado com sucesso', 201);
    }

    public function show($id) {
        $produto = Produto::find($id);

        if (!$produto) {
            return $this->error('Produto não encontrado', 404);
        }

        return $this->success(new ProdutoResource($produto), 'Produto encontrado');
    }

    public function update(ProdutoRequest $request, $id) {
        $produto = Produto::find($id);

        if (!$produto) {
            return $this->error('Produto não encontrado', 404);
        }

        $produto->update($request->all());

        // Limpar cache
        Cache::flush();

        return $this->success(new ProdutoResource($produto), 'Produto atualizado com sucesso');
    }

    public function destroy($id) {
        $produto = Produto::find($id);

        if (!$produto) {
            return $this->error('Produto não encontrado', 404);
        }

        $produto->delete();

        // Limpar cache
        Cache::flush();

        return $this->success(null, 'Produto deletado com sucesso');
    }
}