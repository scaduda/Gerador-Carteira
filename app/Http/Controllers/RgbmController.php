<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRgbmRequest;
use App\Http\Resources\RgbmResource;
use App\Services\RgbmService;
use App\Services\Interfaces\IRgbmService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Intervention\Image\Exception\NotFoundException;


class RgbmController extends Controller
{
    private IRgbmService $service;

    public function __construct()
    {
        $this->service = new RgbmService();
    }

    public function index()
    {
        try {
            return $this->service->index();
        } catch (NotFoundException $e) {
            return response()->json(['mensagem' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            return response()->json(['mensagem' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function store(StoreRgbmRequest $request)
    {
        try {
            return $this->service->store($request->all());
        } catch (NotFoundException $e) {
            return response()->json(['mensagem' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            return response()->json(['mensagem' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function gerarRgbmFrente(string $num_rgbm)
    {
        try {
            return $this->service->gerarRgbmFrente($num_rgbm);
        } catch (NotFoundException $e) {
            return response()->json(['mensagem' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            return response()->json(['mensagem' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function gerarRgbmVerso(string $num_rgbm)
    {
        try {
            return $this->service->gerarRgbmVerso($num_rgbm);
        } catch (NotFoundException $e) {
            return response()->json(['mensagem' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            return response()->json(['mensagem' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
