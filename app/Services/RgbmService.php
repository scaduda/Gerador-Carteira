<?php


namespace App\Services;



use App\Models\Rgbm;
use App\Models\RgbmArquivo;
use App\Services\Interfaces\IRgbmService;
use Carbon\Carbon;
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
            $rgbmObj['foto'] = base64_encode(file_get_contents($request['foto']->getPathName()));
            $rgbmObj['assinatura'] = base64_encode(file_get_contents($request['assinatura']->getPathName()));
            $rgbmSalva = Rgbm::where([
                ['num_cpf', '=', $rgbmObj['num_cpf']],
                ['num_matricula', '=', $rgbmObj['num_matricula']],
                ['tip_sangue', '=', $rgbmObj['tip_sangue']],
                ['num_rgbm', '=', $rgbmObj['num_rgbm']],
                ['rg', '=', $rgbmObj['rg']],
                ['dat_nasc', '=', $rgbmObj['dat_nasc']],
                ['siape', '=', $rgbmObj['siape']],
                ['naturalidade', '=', $rgbmObj['naturalidade']],
                ['nacionalidade', '=', $rgbmObj['nacionalidade']]
            ])->get()->first();

            $rgbmFinal = [];
            if (!$rgbmSalva) {
               $rgbmFinal = Rgbm::query()->create($rgbmObj)->toArray();
            } else {

                $rgbmId = $rgbmSalva->id;
                unset($rgbmSalva->id);

                if (!empty(array_diff($rgbmSalva->toArray(), $rgbmObj))) {
                    RGBM::where('id', '=', $rgbmId)->update($rgbmObj);
                    $rgbmFinal = $rgbmSalva->fresh();
                }
            }
            DB::commit();
            $frente = base64_encode($this->gerarRgbmFrente($rgbmFinal['num_rgbm']));
            $verso = base64_encode($this->gerarRgbmVerso($rgbmFinal['num_rgbm']));
            return ['frente' => $frente, 'verso' => $verso];
        } catch (Exception $err) {
            DB::rollBack();
            throw new Exception($err->getMessage(), $err->getCode());
        }
    }

    public function gerarRgbmFrente(string $num_rgbm)
    {
        $rgbm = Rgbm::where('num_rgbm', '=', $num_rgbm)->get()->first();
        $rgbm->makeVisible('foto');
        $rgbm->foto = stream_get_contents($rgbm->foto);
        $rgbm->makeVisible('assinatura');
        $rgbm->assinatura = stream_get_contents($rgbm->assinatura);

        $img = Image::make(public_path('images/templates/carteira-digital-bombeiros-frente.jpg'))
            ->resize(638, 1011);

        $fotoPerfil = Image::make($rgbm->foto)->resize(240,298)->stream('jpeg', 90);
        $img->insert($fotoPerfil, 'bottom-left', 47,500);

        $assinatura = Image::make($rgbm->assinatura)->resize(200,91)->stream('png');
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

    public function gerarRgbmVerso(string $num_rgbm)
    {
        $rgbm = Rgbm::where('num_rgbm', '=', $num_rgbm)->get()->first();
        $rgbm->makeVisible('foto');
        $rgbm->foto = stream_get_contents($rgbm->foto);
        $rgbm->makeVisible('assinatura');
        $rgbm->assinatura = stream_get_contents($rgbm->assinatura);


        $img = Image::make(public_path('images/templates/carteira-digital-bombeiros-verso.jpg'))
            ->resize(638, 1011);

        $img->text($rgbm->num_rgbm, 20, 200, function ($font) {
            $font->file(public_path('fonts/CRYSRG__.TTF'));
            $font->size(24);
            $font->color('#000000');
        });

        $img->text($rgbm->rg, 195, 200, function ($font) {
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
        $miniaturaPerfil = Image::make($rgbm->foto)->resize(100,124)->stream('jpg', 90);
        $img->insert($miniaturaPerfil, 'bottom-left', 265,150);

        $assinatura = Image::make($rgbm->assinatura)->resize(200,91)->stream('png');
        $img->insert($assinatura, 'bottom-left',120, 60);

        $qrCode = Image::make(public_path('images/images/qrcode.png'))->resize(300,382);
        $qr = $img->insert($qrCode, 'bottom-left',38, 215);

        return $img->response("png");
    }

}


