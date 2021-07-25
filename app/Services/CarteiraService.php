<?php


namespace App\Services;


use App\Services\Interfaces\ICarteiraService;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class CarteiraService implements ICarteiraService
{
    private string $nome;
    private string $cargo;
    private string $cpf;
    private string $matricula;
    private Carbon $dataValidade;
    private string $tipoSanguineo;
    private int $numero;
    private string $rg;
    private Carbon $nascimento;
    private string $siape;
    private string $naturalidade;
    private string $nacionalidade;
    private Carbon $dataExpedicao;

    public function gerarCarteiraFrente()
    {
        $img = Image::make(storage_path('app/public/templates/carteira-digital-bombeiros-frente.jpg'))
            ->resize(638, 1011);

        $fotoPerfil = Image::make(storage_path('app/public/images/fotografia cel alexandre.jpg'))->resize(240,298);
        $foto = $img->insert($fotoPerfil, 'bottom-left', 47,500);

        $assinatura = Image::make(storage_path('app/public/images/assinatura.png'))->resize(200,91);
        $ass = $img->insert($assinatura, 'bottom-center',50, 80);

        $nome = $img->text('ALEXANDRE JOSE ALVES SILVA', 45, 600, function ($font) {
            $font->size(24);
            $font->color('#000000');
        });

        $cargo = $img->text('CORONEL', 45, 700, function ($font) {
            $font->size(24);
            $font->color('#e21f27');
        });

        $cpf = $img->text('000.000.000-00', 45, 780, function ($font) {
            $font->size(24);
            $font->color('#000000');
        });

        $matricula = $img->text('00.000-0', 45, 840, function ($font) {
            $font->size(24);
            $font->color('#000000');
        });

        $tipoSanguineo = $img->text('A+', 370, 840, function ($font) {
            $font->size(24);
            $font->color('#000000');
        });

        $validade = $img->text('14/08/2090', 370, 780, function ($font) {
            $font->size(24);
            $font->color('#000000');
        });

        return $img->response("png");

    }




}


