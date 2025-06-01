<?php

namespace App\Http\Controllers\Empresas;

use App\Models\Empresa;
use App\Models\Segmento;
use App\Http\Requests\Empresas\StoreEmpresaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Exception;
use Inertia\Inertia;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empresas = Empresa::whereNull('deleted_at')
            ->orderBy('updated_at', 'desc')
            ->with('segmento')
            ->get();

        $segmentos = Segmento::whereNull('deleted_at')
            ->orderBy('nome', 'desc')
            ->get();

        return Inertia::render('Empresas/Index', [
            'empresas' => $empresas,
            'segmentos' => $segmentos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmpresaRequest $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validated();

            $validatedData = $this->validateSegmento($validatedData);

            Empresa::create($validatedData);

            DB::commit();

            $segmentos = Segmento::whereNull('deleted_at')
                ->orderBy('nome', 'desc')
                ->get();

            return redirect()->route('empresas.index')->with('flash', [
                'type' => 'success',
                'message' => 'Empresa criada com sucesso!',
                'segmentos' => $segmentos,
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();

            $message_error = 'Erro ao criar empresa: ' . $exception->getMessage();
            Log::error($message_error);

            return redirect()->route('empresas.index')->with('flash', [
                'type' => 'error',
                'message' => $message_error,
            ]);
        }
    }

    private function validateSegmento($validatedData)
    {
        if (empty($validatedData['segmento_id']) && empty($validatedData['segmento'])) {
            return redirect()->route('empresas.index')->with('flash', [
                'type' => 'error',
                'message' => 'É necessário informar o segmento.',
            ]);
        }

        if (!empty($validatedData['segmento_id'])) {
            $segmento = Segmento::find($validatedData['segmento_id']);
            if (!$segmento) {
                throw new Exception("Segmento não encontrado.");
            }
        } elseif (!empty($validatedData['segmento']) && empty($validatedData['segmento_id'])) {
            $segmento = Segmento::firstOrCreate(
                ['nome' => $validatedData['segmento']],
            );
            $validatedData['segmento_id'] = $segmento->id;
        }

        return $validatedData;
    }

    /**
     * Display the specified resource.
     */
    public function show(Empresa $empresa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empresa $empresa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empresa $empresa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empresa $empresa)
    {
        //
    }

}
