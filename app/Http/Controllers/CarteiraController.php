<?php

namespace App\Http\Controllers;

use App\Services\CarteiraService;
use App\Services\Interfaces\ICarteiraService;
use Illuminate\Http\Response;
use Intervention\Image\Exception\NotFoundException;


class CarteiraController extends Controller
{
    private ICarteiraService $service;

    public function __construct()
    {
        $this->service = new CarteiraService();
    }

    public function gerarCarteiraFrente()
    {
        try{
            return $this->service->gerarCarteiraFrente();
        } catch (NotFoundException $e) {
            return response()->json(['mensagem' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            return response()->json(['mensagem' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function gerarCarteiraVerso()
    {
        try{
            return $this->service->gerarCarteiraVerso();
        } catch (NotFoundException $e) {
            return response()->json(['mensagem' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            return response()->json(['mensagem' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
