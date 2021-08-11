<?php


namespace App\Services\Interfaces;


use App\Http\Requests\StoreRgbmRequest;
use Illuminate\Http\Request;

interface IRgbmService
{
    public function store(array $request);

    public function gerarRgbmFrente(string $num_rgbm);

    public function gerarRgbmVerso(string $num_rgbm);

}
