<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\View\View;
use App\Models\Klijenti;
use App\Models\Banke;
use App\Models\Dobavljaci;
use App\Models\poreska_filijala;
use Illuminate\Http\RedirectResponse;
use App\Models\OdgovornoLice;
use App\Models\knjigovodja;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Dokumenta;
use App\Models\Fajlovi;
use App\Models\Fajlpromene;
use App\Models\Nalozi;
use App\Models\NVFajlovi;
use App\Models\NVIznosi;
use App\Models\Pozicije;
use App\Models\Vozila;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

use TCPDF;
use ZipArchive;


class RadnaListaController extends Controller
{
    function __construct()
    {
         //
    }

    public function index(Request $request): View
    {
        $nalozi = Nalozi::where([
                    ['skener_ulazne_fakture_id', '=', Auth::user()->id],
                    ['sken_ulazne_fakture', '=', 0]
                ])
                ->orWhere([
                    ['skener_izlazne_fakture_id', '=', Auth::user()->id],
                    ['sken_izlazne_fakture', '=', 0],
                ])
                ->orWhere([
                    ['skener_izvodi_id', '=', Auth::user()->id],
                    ['sken_izvodi', '=', 0],
                ])
                ->orWhere([
                    ['skener_kompenzacije_id', '=', Auth::user()->id],
                    ['sken_kompenzacije', '=', 0],
                ])
                ->orWhere([
                    ['skener_knjizna_odobrenja_id', '=', Auth::user()->id],
                    ['sken_knjizna_odobrenja', '=', 0],
                ])
                ->orWhere([
                    ['unosilac_id', '=', Auth::user()->id],
                    ['unos_gotov', '=', 0],
                ])
                ->with('skener_ulazne_fakture')
                ->with('skener_izlazne_fakture')
                ->with('skener_izvodi')
                ->with('skener_kompenzacije')
                ->with('skener_knjizna_odobrenja')
                ->with('unosilac')
                ->with('kvartal')
                ->with('klijent')
                ->get();

        return view('radnalista.index',compact('nalozi'));
    }

    public function selectScan($id): View
    {
        $nalozi = Nalozi::where('id',$id)->first();

        return view('radnalista.selectscan', compact('nalozi'));
    }

    public function scan($id, $tip, $tip_ime): View
    {
        $v_tip = str_replace('sken','skener',$tip).'_id';
        $nalozi = Nalozi::where('id',$id)
                ->with('unosilac')
                ->with('kvartal')
                ->with('klijent')
                ->first();
        //dd($nalozi);
        if($nalozi) {
            $klijent_pod = Klijenti::find($nalozi->klijent_id);
            $klijent_token = $klijent_pod->token;
            $hiddenFolder=substr($klijent_token,0,8);
            $dokumenta_path = '/storage/'.$hiddenFolder.'/'.$id.'/';

            $data = [
                'resp' => true,
                'dokumenta_path' => $dokumenta_path,
                'tip' => $tip,
                'v_tip' => $v_tip,
                'tip_ime' => $tip_ime
            ];

            $fajlovi = Fajlovi::where('nalog_id',$id)->where('tip',$tip)->get();
            $poreska_filijala = poreska_filijala::where('id', $klijent_pod->poreska_filijala_id)->first();
            $banke = Banke::get();

            return view('radnalista.scan', compact('nalozi','poreska_filijala','fajlovi','banke'), $data);
        } else {
            $data = [
                'resp' => false
            ]; 
            return view('radnalista.scan', $data);
        }
    }
	
	function remote_file_exists($url)
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); # handles 301/2 redirects
		curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if( $httpCode == 200 ){return true;}
	}
	
	public function processPDFs(Request $request): JsonResponse
	{
		$unzipError = false;
		$hiddenFolder = $request->hiddenfolder;


        $docPath = public_path('storage'.DIRECTORY_SEPARATOR.$hiddenFolder.DIRECTORY_SEPARATOR.$request->nalog_id.DIRECTORY_SEPARATOR);
		$docStoragePath = storage_path('app/public').DIRECTORY_SEPARATOR.$hiddenFolder.DIRECTORY_SEPARATOR.$request->nalog_id.DIRECTORY_SEPARATOR;
		$tmpDocPath = $docPath.$request->zip_uid.DIRECTORY_SEPARATOR;
		
		if (!is_dir($tmpDocPath)) {
            mkdir($tmpDocPath, 0777, true );
            mkdir($tmpDocPath.'zip', 0777, true );
        }
		
		$zip_uid = $request->zip_uid;
		$new_file = $request->new_file;
		
		$url = "http://ocr.ristic-office.de:8182";
		$zip = "/convert/".$hiddenFolder."/".$request->nalog_id."/".$zip_uid.".zip";
		$newZip = $docPath.$request->zip_uid.DIRECTORY_SEPARATOR.$zip_uid.".zip";
		$newZipStorage = $docStoragePath.$request->zip_uid.DIRECTORY_SEPARATOR.$zip_uid.".zip";
		
		$default_socket_timeout = ini_get('default_socket_timeout');
		set_time_limit(0);
		ini_set('default_socket_timeout', 1200);
		file_get_contents($url."/index.php?file=".$new_file."&klijent=".$hiddenFolder."&nalog=".$request->nalog_id."&tip=".$request->tip."&uid=".$zip_uid);
		ini_set('default_socket_timeout', $default_socket_timeout);
				
		$zip_resource = fopen($newZip, "w");
		
		$ch_start = curl_init();
		curl_setopt($ch_start, CURLOPT_URL, $url.$zip);
		curl_setopt($ch_start, CURLOPT_FAILONERROR, true);
		curl_setopt($ch_start, CURLOPT_HEADER, 0);
		curl_setopt($ch_start, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch_start, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch_start, CURLOPT_BINARYTRANSFER,true);
		curl_setopt($ch_start, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch_start, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch_start, CURLOPT_SSL_VERIFYPEER, 0); 
		curl_setopt($ch_start, CURLOPT_FILE, $zip_resource);
		$page = curl_exec($ch_start);
		if(!$page)
		{
			$resp_json['resp'] = "Error :- ".curl_error($ch_start);
		}
		curl_close($ch_start);

		//dd($docStoragePath.$request->tip.'.zip');
		$unzip = new ZipArchive;
		$res = $unzip->open($newZipStorage);
		if ($res === TRUE) {
			$unzip->extractTo($docStoragePath.$zip_uid);
			$unzip->close();
		} else {
			$unzipError = true;
		}
		
		if($unzipError) {
			$resp_json['resp'] = 'Fehler beim unzip';
		} else {
            exec("mv ".$newZipStorage." ".$docStoragePath.$zip_uid.DIRECTORY_SEPARATOR.'zip'.DIRECTORY_SEPARATOR);
			$scanned_directory = array_diff(scandir($docStoragePath.$zip_uid), array('..', '.', 'tmb', 'zip')); 
			

			$cnt_files = 0;
			foreach($scanned_directory as $scaned_file) {
                $cnt_files++;
                $fajlovi = new Fajlovi;

                $fajlovi->nalog_id = $request->nalog_id;
                $fajlovi->tip = $request->tip;
                $fajlovi->folder = $zip_uid;
                if (isset($request->banka)) {
                    $fajlovi->banka_id = $request->banka;
                }
                $fajlovi->fajl = $scaned_file;

                $fajlovi->save();
            }
			
            
			//exec("mv ".$tmpDocUrl."* ".$docStoragePath);
			
			
			$pdftext = file_get_contents($docPath.$new_file);
			$num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
			$num = $num;

			if($cnt_files == $num) {
				$resp_json['resp'] = $num;
			} else {
				$resp_json['resp'] = 'in PDF: '.$num." - in ZIP: ".$cnt_files;
			}
		}
		return response()->json($resp_json);
	}
	
	public function getProc(Request $request): JsonResponse
	{
		$klijent = $request->klijent;
		$nalog = $request->nalog;
		$uid = $request->uid;
		
		$url = "http://207.180.235.62:8182/getProcess.php?klijent=".$klijent."&nalog=".$nalog."&uid=".$uid;
		//dd($url);
		$default_socket_timeout = ini_get('default_socket_timeout');
		set_time_limit(0);
		ini_set('default_socket_timeout', 1200);
		$cntFiles = file_get_contents($url);
		ini_set('default_socket_timeout', $default_socket_timeout);
		
		$resp_json['files'] = $cntFiles;
		
		return response()->json($resp_json);
	}

    public function storeFiles(Request $request): JsonResponse
    {

        $klijent = Klijenti::find($request->klijent_id);
        $klijent_token = $klijent->token;

        $hiddenFolder=substr($klijent_token,0,8);
        $docPath = public_path('storage'.DIRECTORY_SEPARATOR.$hiddenFolder.DIRECTORY_SEPARATOR.$request->nalog_id.DIRECTORY_SEPARATOR);		

		$uploaded_file = $request->file('file');
        //dd($request);
        $resp_json = [];
        $new_file = bin2hex(date('Y-m-d').'_'.$klijent->id.'_'.uniqid()).'.'.$uploaded_file->extension();
        $uploaded_file->move($docPath,$new_file);
        $ext = pathinfo($docPath.$new_file, PATHINFO_EXTENSION);

        if($ext == 'pdf') {
			$zip_uid = uniqid();
			set_time_limit(0);			
			
			$pdftext = file_get_contents($docPath.$new_file);
			$num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
			 
			$resp_json['resp']['hiddenFolder'] = $hiddenFolder;
			$resp_json['resp']['new_file'] = $new_file;
			$resp_json['resp']['zip_uid'] = $zip_uid; 
			$resp_json['resp']['nalog_id'] = $request->nalog_id;
			$resp_json['resp']['tip'] = $request->tip;
			$resp_json['resp']['uuid'] = $request->uuid;
			$resp_json['resp']['filename'] = $request->filename;
			$resp_json['resp']['cntFiles'] = $num;
			
        } else {

			$fajlovi = new Fajlovi;

			$fajlovi->nalog_id = $request->nalog_id;
			$fajlovi->tip = $request->tip;
            if (isset($request->banka)) {
                $fajlovi->banka_id = $request->banka;
            }
			$fajlovi->fajl = $new_file;

			$fajlovi->save();

            $resp_json['resp'] = $new_file;
        }


        return response()->json($resp_json);
    }

    public function deleteFile(Request $request): JsonResponse
    {
        Fajlovi::where('id', $request->fajl)->update(['aktivan' => 0]);
        DB::table('fajlpromene')
            ->updateOrInsert(
                ['nalog_id' => $request->nalog_id, 'fajl' => $request->fajl],
                ['aktivan' => false]
            );


        return response()->json(['success'=>'true']);
    }

    public function changeFajlTip(Request $request): JsonResponse
    {
        $fajlovi = Fajlovi::where('tip', $request->tip)->where('nalog_id', $request->nalog_id)->get();
        $countFajl = $fajlovi->count();
        if($fajlovi->isNotEmpty()) {

            foreach($fajlovi as $fajl) {
                $data[] = [
                    'fajl_id' => $fajl->id,
                    'folder' => $fajl->folder,
                    'fajl' => $fajl->fajl,
                    'aktivan' => $fajl->aktivan,
                    'countFajl' => $countFajl
                ];
            }
        } else {
            $data = [];
        }

        


        
        return response()->json($data);
    }

    public function addNV(Request $request): void
    {

        DB::table('nv_iznosi')
            ->updateOrInsert(
                ['nalog_id' => $request->nalog_id, 'br_fakture' => $request->br_fakture],
                ['kupljeno' => $request->kupljeno]
            );
    }

    public function removeNV(Request $request): void
    {
        DB::table('nv_iznosi')->where('nalog_id', $request->nalog_id)->where('br_fakture', $request->br_fakture)->delete();
    }

    public function retrieveFile(Request $request): JsonResponse
    {
        Fajlovi::where('id', $request->fajl)->update(['aktivan' => 1]);
        DB::table('fajlpromene')
            ->updateOrInsert(
                ['nalog_id' => $request->nalog_id, 'fajl' => $request->fajl],
                ['aktivan' => true]
            );

        return response()->json(['success'=>'true']);
    }

    public function getFileStatus(Request $request): JsonResponse
    {
        $fajlovi = Fajlpromene::where('nalog_id', $request->nalog_id)->get();
        //Fajlpromene::where('nalog_id', $request->nalog_id)->delete();

        return response()->json($fajlovi);
    }

    public function finishScan(Request $request): RedirectResponse
    {
        $upd = Nalozi::where('id', $request->nalog_id)
                ->update([$request->tip => 1]);

        return redirect()->route('radnalista.index');
    }

	public function finishUnos(Request $request): RedirectResponse
    {
        $upd = Nalozi::where('id', $request->nalog_id)
                ->update(['unos_gotov' => 1]);

        return redirect()->route('radnalista.index');
    }

    public function getNV(Request $request) : JsonResponse {
        $nv = NVIznosi::where('nalog_id', $request->nalog_id)->where('br_fakture', $request->br_fakture)->get();
        return response()->json($nv);
    }

    public function getCntNvFajlovi(Request $request) : JsonResponse {
        $nv = NVFajlovi::where('nalog_id', $request->nalog_id)->where('faktura', $request->br_fakture)->count();
        return response()->json($nv);
    }

    public function getNvFajlovi(Request $request) : JsonResponse {
        $nv = NVFajlovi::where('nalog_id', $request->nalog_id)->where('faktura', $request->br_fakture)->with('fajl')->get();

        $nalozi = Nalozi::where('id', $request->nalog_id)->first();
        $klijent_pod = Klijenti::find($nalozi->klijent_id);
        $klijent_token = $klijent_pod->token;
        $hiddenFolder=substr($klijent_token,0,8);
        $dokumenta_path = '/storage/'.$hiddenFolder.'/'.$request->nalog_id.'/';

        return response()->json(['nv' => $nv, 'dokumenta_path' => $dokumenta_path]);
    }

    public function removeNvFajl(Request $request) : JsonResponse {
        $nv = NVFajlovi::where('nalog_id', $request->nalog_id)->where('faktura', $request->br_fakture)->where('fajl_id', $request->fajl_id)->delete();

        return response()->json(['ok']);
    }

    public function addNvFajl(Request $request) : JsonResponse {
       
        $nvFajlovi = NVFajlovi::updateOrCreate(
            ['nalog_id' => $request->nalog_id, 'faktura' => $request->br_fakture, 'fajl_id' => $request->fajl_id],
            ['nalog_id' => $request->nalog_id, 'faktura' => $request->br_fakture, 'fajl_id' => $request->fajl_id]
        );

        return response()->json(['ok']);
    }

    

    public function tabela($id, ?string $tipVar = NULL, ?int $tipId = NULL, ): View
    {
        //dd($tipId);
        $data = [
            'tipVar' => 'null',
            'tipId' => ''
        ];
        $nalozi = Nalozi::where('id',$id)
                ->with('klijent')
                ->with('unosilac')
                ->with('kvartal')
                ->first();


        if($tipVar == 'poVozilu' && $tipId != NULL) {
            $pozicije = Pozicije::where('nalog_id', $id)
            ->where('vozila', $tipId)
            ->with('vozilo')
            ->get();

            $data = [
                'tipVar' => 'poVozilu',
                'tipId' => $tipId
            ];
        } elseif($tipVar == 'poDobavljacu' && $tipId != NULL) {
            $pozicije = Pozicije::where('nalog_id', $id)
            ->where('dobavljac_id', $tipId)
            ->with('dobavljac')
            ->get();

            $data = [
                'tipVar' => 'poDobavljacu',
                'tipId' => $tipId
            ];
        } else {
            $pozicije = Pozicije::where('nalog_id', $id)
                    ->with('vozilo')
                    ->get();
        }

        $pozicije = $pozicije->map(function($pozicija) {
            if($pozicija->vozila != NULL) {
                $reg_broj = explode('-',$pozicija->vozilo->reg_broj);
                $pozicija->reg_broj1 = $reg_broj[0];
                $pozicija->reg_broj2 = $reg_broj[1];
                $pozicija->reg_broj3 = $reg_broj[2];
            }
                return $pozicija;
            
        });
    

        //dd($pozicije);
        
        if($tipVar == 'poVozilu' && $tipId != NULL) {
            $suma = DB::table('pozicije')
            ->where('nalog_id', $id)
            ->where('vozila', $tipId)
            ->select(DB::raw('vozila.reg_broj, SUM(iznos) iznos_goriva, SUM(kolicina) as kol_goriva'))
            ->leftJoin('vozila', 'pozicije.vozila', '=', 'vozila.id')
            ->groupBy('vozila')
            ->get();
            //dd($suma);
        } elseif($tipVar == 'poDobavljacu' && $tipId != NULL) {
            $suma = DB::table('pozicije')
            ->where('nalog_id', $id)
            ->where('dobavljac_id', $tipId)
            ->select(DB::raw('vozila.reg_broj, SUM(iznos) iznos_goriva, SUM(kolicina) as kol_goriva'))
            ->leftJoin('vozila', 'pozicije.vozila', '=', 'vozila.id')
            ->groupBy('vozila')
            ->get();
            //dd($suma);
        } else {
            $suma = DB::table('pozicije')
                    ->where('nalog_id', $id)
                    ->select(DB::raw('vozila.reg_broj, SUM(iznos) iznos_goriva, SUM(kolicina) as kol_goriva'))
                    ->leftJoin('vozila', 'pozicije.vozila', '=', 'vozila.id')
                    ->groupBy('vozila')
                    ->get();
            }
        //dd($nalozi);
        if($nalozi) {
            
            $klijent_pod = Klijenti::where('id', $nalozi->klijent_id)->first();
            $klijent_token = $klijent_pod->token;
            $hiddenFolder=substr($klijent_token,0,8);
            $dokumenta_path = '/storage/'.$hiddenFolder.'/'.$id.'/';

            
            $dobavljaci = Dobavljaci::get();
            $fajlovi = Fajlovi::where('nalog_id',$id)
                        ->where('tip', 'sken_ulazne_fakture')
                        ->get();
            $cndFiles = count($fajlovi);
            $poreska_filijala = poreska_filijala::where('id', $klijent_pod->poreska_filijala_id)->first();


            $data += [
                'resp' => true,
                'dokumenta_path' => $dokumenta_path,
                'pos' => 1,
                'sumpos' => 1,
                'tip' => 'sken_ulazne_fakture',
                'filepos' => 0,
                'cntFiles' => $cndFiles
            ];
            //dd($data);
            return view('radnalista.tabela', compact('nalozi','pozicije','suma', 'poreska_filijala','fajlovi','dobavljaci'), $data);
        } else {
            $data = [
                'resp' => false
            ];
            return view('radnalista.tabela', $data);
        }
    }

    public function extImg($id, ?string $tip = NULL): View
    {

        $nalozi = Nalozi::where('id',$id)->first();
        //dd($nalozi);
        if($nalozi) {
            $klijent_pod = Klijenti::find($nalozi->klijent_id);
            $klijent_token = $klijent_pod->token;
            $hiddenFolder=substr($klijent_token,0,8);
            $dokumenta_path = '/storage/'.$hiddenFolder.'/'.$id.'/';

            if($tip == NULL) {
                $fajlovi = Fajlovi::where('nalog_id',$id)
                            ->where('tip', 'sken_ulazne_fakture')
                            ->get();
            } else {
                $fajlovi = Fajlovi::where('nalog_id',$id)
                ->where('tip', $tip)
                ->get();
            }
            
            $cndFiles = count($fajlovi);

            $data = [
                'resp' => true,
                'dokumenta_path' => $dokumenta_path,
                'i' => 0,
                'filepos' => 0,
                'cntFiles' => $cndFiles
            ];

            return view('radnalista.extImg', compact('nalozi','fajlovi'), $data);
        } else {
            $data = [
                'resp' => false
            ];
            return view('radnalista.extImg', $data);
        }
    }

    public function store(Request $request): RedirectResponse
    {
        
        $nalog = Nalozi::where('id', $request->nalog_id)->first();
        $klijent_id = $nalog->klijent_id;
        $nalog_id = $request->nalog_id;
        
        if(isset($request->tipVar) && $request->tipVar != '') {
            //dd($request);
            if (isset($request->delPos)) {
                foreach($request->delPos as $delPos) {
                    Pozicije::where('id', $delPos)->delete();
                }
            }

            foreach($request->posId as $posIdx => $posId) {
                if(!isset($request->taxi)) {
                    $reg_br = $request->reg_broj1[$posIdx].'-'.$request->reg_broj2[$posIdx].'-'.$request->reg_broj3[$posIdx];
                
                    $getVozilo =  Vozila::where('reg_broj', $reg_br)
                    ->where('klijent_id', $klijent_id)
                    ->first();
                    if($getVozilo) {
                        $voziloId = $getVozilo->id;
                    } else {
                        $voziloId = Vozila::insertGetId(
                            ['klijent_id' => $klijent_id, 'reg_broj' =>  $reg_br]
                        );
                    }
                }
                $pozicija = Pozicije::find($posId);
                $pozicija->datum_fakture = $request->datum[$posIdx];
                $pozicija->broj_fakture = $request->br_fakture[$posIdx];
                $pozicija->broj_opremnice = $request->br_opremnice[$posIdx];
                $pozicija->gorivo = $request->gorivo[$posIdx];
                $pozicija->dobavljac_id = $request->dobavljac[$posIdx];
                $pozicija->iznos = str_replace(',', '.', $request->iznos[$posIdx]);
                $pozicija->kolicina = str_replace(',', '.', $request->kolicina[$posIdx]);
                if(!isset($request->taxi)) {
                    $pozicija->vozila = $voziloId;
                }
                $pozicija->updated_at =  \Carbon\Carbon::now();
                $pozicija->save();

            }

        } else {
            Pozicije::where('nalog_id', $request->nalog_id)->delete();
            $nalog_id = $request->nalog_id;
            $datum = $request->datum;
            $br_fakture = $request->br_fakture;
            $br_opremnice = $request->br_opremnice;
            $gorivo = $request->gorivo;
            $dobavljac = $request->dobavljac;
            $iznos = $request->iznos;
            $kolicina = $request->kolicina;
            if(!isset($request->taxi)) {
                $reg_vozila1 = $request->reg_broj1;
                $reg_vozila2 = $request->reg_broj2;
                $reg_vozila3 = $request->reg_broj3; 
            }

            for($i=0;$i<count($datum);$i++){
                if(!isset($request->taxi)) {
                    $reg_br = $reg_vozila1[$i].'-'.$reg_vozila2[$i].'-'.$reg_vozila3[$i];
                
                    $getVozilo =  Vozila::where('reg_broj', $reg_br)
                    ->where('klijent_id', $klijent_id)
                    ->first();
                    if($getVozilo) {
                        $voziloId = $getVozilo->id;
                    } else {
                        $voziloId = Vozila::insertGetId(
                            ['klijent_id' => $klijent_id, 'reg_broj' =>  $reg_br]
                        );
                    }
                    $datasave = [
                        'nalog_id'=>$nalog_id,
                        'datum_fakture'=>$datum[$i],
                        'broj_fakture'=>$br_fakture[$i],
                        'broj_opremnice'=>$br_opremnice[$i],
                        'gorivo'=>$gorivo[$i],
                        'dobavljac_id'=>$dobavljac[$i],
                        'iznos'=>str_replace(',', '.', $iznos[$i]),
                        'kolicina'=>str_replace(',', '.', $kolicina[$i]),
                        'vozila'=>$voziloId,
                        "created_at" =>  \Carbon\Carbon::now(),
                        "updated_at" =>  \Carbon\Carbon::now()
    
                    ];
                } else {
                    $datasave = [
                        'nalog_id'=>$nalog_id,
                        'datum_fakture'=>$datum[$i],
                        'broj_fakture'=>$br_fakture[$i],
                        'broj_opremnice'=>$br_opremnice[$i],
                        'gorivo'=>$gorivo[$i],
                        'dobavljac_id'=>$dobavljac[$i],
                        'iznos'=>str_replace(',', '.', $iznos[$i]),
                        'kolicina'=>str_replace(',', '.', $kolicina[$i]),
                        "created_at" =>  \Carbon\Carbon::now(),
                        "updated_at" =>  \Carbon\Carbon::now()
    
                    ];
                }
                
                Pozicije::insert($datasave);
                
            }
        }

        NVIznosi::where('nalog_id', $nalog_id)->delete();

        foreach($request->nvIznos as $faktura =>$nvIznos) {
            $NVIznosi = new NVIznosi;
            $NVIznosi->nalog_id = $nalog_id;
            $NVIznosi->br_fakture = $faktura;
            $NVIznosi->kupljeno = $nvIznos;
            $NVIznosi->save();
        }   

        if(isset($request->tipVar) && $request->tipVar != '') {
            return redirect()->route('radnalista.tabela', ['id' => $nalog_id,'tip' => $request->tipVar, 'tipId' => $request->tipId])
                        ->with('success','Sačuvano');
        } else {
            return redirect()->route('radnalista.tabela', ['id' => $nalog_id])
                        ->with('success','Sačuvano');
        }
    }

}
