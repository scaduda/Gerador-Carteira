<?php


namespace App\Services;


use App\Services\Interfaces\ICarteiraService;
use Barryvdh\DomPDF\PDF;
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
        $img = Image::make(public_path('images/templates/carteira-digital-bombeiros-frente.jpg'))
            ->resize(638, 1011);

        $fotoPerfil = Image::make(public_path('images/images/fotografia cel alexandre.jpg'))->resize(240,298);
        $foto = $img->insert($fotoPerfil, 'bottom-left', 47,500);

        $assinatura = Image::make(public_path('images/images/assinatura.png'))->resize(200,91);
        $ass = $img->insert($assinatura, 'bottom-center',50, 80);

        $nome = $img->text('ALEXANDRE JOSE ALVES SILVA', 45, 600, function ($font) {
            $font->size(24);
            $font->file(public_path('fonts/CRYSRG__.TTF'));
            $font->color('#000000');
        });

        $cargo = $img->text('CORONEL', 45, 700, function ($font) {
            $font->size(24);
            $font->file(public_path('fonts/CRYSRG__.TTF'));
            $font->color('#e21f27');
        });

        $cpf = $img->text('000.000.000-00', 45, 780, function ($font) {
            $font->size(24);
            $font->file(public_path('fonts/CRYSRG__.TTF'));
            $font->color('#000000');
        });

        $matricula = $img->text('00.000-0', 45, 840, function ($font) {
            $font->size(24);
            $font->file(public_path('fonts/CRYSRG__.TTF'));
            $font->color('#000000');
        });

        $tipoSanguineo = $img->text('A+', 370, 840, function ($font) {
            $font->size(24);
            $font->color('#000000');
        });

        $dataValidade = $img->text('14/08/2090', 370, 780, function ($font) {
            $font->size(24);
            $font->file(public_path('fonts/CRYSRG__.TTF'));
            $font->color('#000000');
        });

        return $img->response("png");

    }

    public function gerarCarteiraVerso()
    {
        $img = Image::make(public_path('images/templates/carteira-digital-bombeiros-verso.jpg'))
            ->resize(638, 1011);

        $numero = $img->text('000000', 20, 200, function ($font) {
            $font->file(public_path('fonts/CRYSRG__.TTF'));
            $font->size(24);
            $font->color('#000000');
        });

        $rg = $img->text('000000-0', 195, 200, function ($font) {
            $font->file(public_path('fonts/CRYSRG__.TTF'));
            $font->size(24);
            $font->color('#000000');
        });

        $nascimento = $img->text('00/00/0000', 20, 258, function ($font) {
            $font->file(public_path('fonts/CRYSRG__.TTF'));
            $font->size(24);
            $font->color('#000000');
        });

        $siape = $img->text('00.000.000-00', 215, 258, function ($font) {
            $font->file(public_path('fonts/CRYSRG__.TTF'));
            $font->size(24);
            $font->color('#000000');
        });

        $naturalidade = $img->text('ARACAJU/SE', 20, 315, function ($font) {
            $font->file(public_path('fonts/CRYSRG__.TTF'));
            $font->size(24);
            $font->color('#000000');
        });

        $nacionalidade = $img->text('BRASILEIRO', 20, 370, function ($font) {
            $font->file(public_path('fonts/CRYSRG__.TTF'));
            $font->size(24);
            $font->color('#000000');
        });

        $dataExpedicao = $img->text('00/00/0000', 215, 370, function ($font) {
            $font->file(public_path('fonts/CRYSRG__.TTF'));
            $font->size(24);
            $font->color('#000000');
        });
        $miniaturaPerfil = Image::make(public_path('images/images/fotografia cel alexandre.jpg'))->resize(100,124);
        $miniatura = $img->insert($miniaturaPerfil, 'bottom-left', 265,150);

        $assinatura = Image::make(public_path('images/images/assinatura.png'))->resize(200,91);
        $ass = $img->insert($assinatura, 'bottom-left',120, 60);

        $qrCode = Image::make(public_path('images/images/qrcode.png'))->resize(300,382);
        $qr = $img->insert($qrCode, 'bottom-left',38, 215);

        return $img->response("png");
    }


}


