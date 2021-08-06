<?php


namespace App\Services;


use App\Http\Requests\StoreRgbmRequest;
use App\Models\Rgbm;
use App\Services\Interfaces\IRgbmService;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Exception;


class RgbmService implements IRgbmService
{

    public function index()
    {
        return Rgbm::query()->get();
    }

    public function store(array $request)
    {
        DB::beginTransaction();
        try{
            $rgbmObj = $request;
            $rgbmObj['data_expedicao'] = Carbon::now();
            Rgbm::create($rgbmObj);
            DB::commit();
        }catch (Exception $err){
            DB::rollBack();
            throw new Exception($err->getMessage(), $err->getCode());
        }

        $rgbmFrente = $this->gerarRgbmFrente($rgbmObj['num_matricula']);
        $rgbmVerso = $this->gerarRgbmVerso($rgbmObj['num_matricula']);

        return $rgbmFrente;
    }

    public function gerarRgbmFrente(string $num_matricula)
    {
        $rgbm = Rgbm::where('num_matricula', '=', $num_matricula)->get()->first();

        $img = Image::make(public_path('images/templates/carteira-digital-bombeiros-frente.jpg'))
            ->resize(638, 1011);

        $fotoPerfil = Image::make(public_path('images/images/fotografia cel alexandre.jpg'))->resize(240,298);
        $foto = $img->insert($fotoPerfil, 'bottom-left', 47,500);

        $assinatura = Image::make(public_path('images/images/assinatura.png'))->resize(200,91);
        $img->insert($assinatura, 'bottom-center',50, 80);

        $img->text($rgbm->nom_completo, 45, 600, function ($font) {
            $font->size(30);
            $font->file(public_path('fonts/CRYSRG__.TTF'));
            $font->color('#000000');
        });

        $img->text($rgbm->cargo_nome, 45, 700, function ($font) {
            $font->size(35);
            $font->file(public_path('fonts/CrystalBold.ttf'));
            $font->color('#e21f27');
        });

        $img->text($rgbm->num_cpf, 45, 790, function ($font) {
            $font->size(30);
            $font->file(public_path('fonts/CRYSRG__.TTF'));
            $font->color('#000000');
        });

        $img->text($rgbm->num_matricula, 45, 855, function ($font) {
            $font->size(30);
            $font->file(public_path('fonts/CRYSRG__.TTF'));
            $font->color('#000000');
        });

        $img->text($rgbm->tip_sangue, 370, 855, function ($font) {
            $font->size(30);
            $font->file(public_path('fonts/CrystalBold.ttf'));
            $font->color('#000000');
        });

        $img->text(Carbon::createFromDate($rgbm->dat_validade_rgbm)->format('d/m/Y'), 370, 790, function ($font) {
            $font->size(30);
            $font->file(public_path('fonts/CRYSRG__.TTF'));
            $font->color('#000000');
        });

        return $img->response("png");

    }

    public function gerarRgbmVerso(string $num_matricula)
    {
        $rgbm = Rgbm::where('num_matricula', '=', $num_matricula)->get()->first();

        $img = Image::make(public_path('images/templates/carteira-digital-bombeiros-verso.jpg'))
            ->resize(638, 1011);

        $numero = $img->text($rgbm->num_rgbm, 20, 200, function ($font) {
            $font->file(public_path('fonts/CRYSRG__.TTF'));
            $font->size(24);
            $font->color('#000000');
        });

        $rg = $img->text($rgbm->rg, 195, 200, function ($font) {
            $font->file(public_path('fonts/CRYSRG__.TTF'));
            $font->size(24);
            $font->color('#000000');
        });

        $img->text(Carbon::createFromDate($rgbm->dat_nasc)->format('d/m/Y'), 20, 258, function ($font) {
            $font->file(public_path('fonts/CRYSRG__.TTF'));
            $font->size(24);
            $font->color('#000000');
        });

        $img->text($rgbm->siape, 215, 258, function ($font) {
            $font->file(public_path('fonts/CRYSRG__.TTF'));
            $font->size(24);
            $font->color('#000000');
        });

        $img->text($rgbm->naturalidade, 20, 315, function ($font) {
            $font->file(public_path('fonts/CRYSRG__.TTF'));
            $font->size(24);
            $font->color('#000000');
        });

        $img->text($rgbm->nacionalidade, 20, 370, function ($font) {
            $font->file(public_path('fonts/CRYSRG__.TTF'));
            $font->size(24);
            $font->color('#000000');
        });

        $img->text(Carbon::createFromDate($rgbm->data_expedicao)->format('d/m/Y'), 215, 370, function ($font) {
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


