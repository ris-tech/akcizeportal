<?php

namespace App\Http\Controllers;

use App\Models\Dokumenta;
use App\Models\Klijenti;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\OdgovornoLice;
use App\Models\Vozila;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Ramsey\Uuid\Uuid;
use Spatie\PdfToImage\Pdf as PdfImg;
use Illuminate\Support\Facades\DB;

use ZipArchive;
use Imagick;

class DokumentaController extends Controller
{
    public function __invoke()
    {
        //
    }

    public function getProc(Request $request): JsonResponse
	{
		$klijent = $request->klijent;
		$tip = $request->tip;
		$uid = $request->uid;
		
		$url = "http://207.180.235.62:8182/getProcess.php?klijent=".$klijent."&nalog=".$tip."&uid=".$uid;
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
        //dd($request);
        $klijent = Klijenti::find($request->klijent_id);
        $klijent_token = $klijent->token;

        $hiddenFolder=substr($klijent_token,0,8);
        $docPath =      public_path('storage'.DIRECTORY_SEPARATOR.$hiddenFolder.DIRECTORY_SEPARATOR.$request->tip.DIRECTORY_SEPARATOR);
        $docPathTmb =   public_path('storage'.DIRECTORY_SEPARATOR.$hiddenFolder.DIRECTORY_SEPARATOR.$request->tip.DIRECTORY_SEPARATOR.'tmb'.DIRECTORY_SEPARATOR);

        if (!is_dir($docPath)) {
            mkdir($docPath, 0777, true );
        }

        if (!is_dir($docPathTmb)) {
            mkdir($docPathTmb, 0777, true );
        }

        $uploaded_file = $request->file('file');
        //dd($request);
        $resp_json = [];
        $new_file = str_replace(' ','_',$request->filename);
        $thumb_file = str_replace('.pdf','.jpg',$new_file);
        $uploaded_file->move($docPath,$new_file);
        $os = php_uname('s');
        if($os == 'Windows NT') {
            exec("copy ".$docPath.$new_file." ".$docPathTmb.$new_file);
        } else {
            exec("cp ".$docPath.$new_file." ".$docPathTmb.$new_file);
        }

        $thumb = new Imagick();
        $thumb->readImage($docPathTmb.$new_file.'[0]');
        $thumb->setImageFormat('jpg');
        //$thumb->resizeImage(0, 320,Imagick::FILTER_LANCZOS,1);
        $thumb->writeImage($docPathTmb.$thumb_file);
        $thumb->clear();
        $thumb->destroy(); 

        $thumb = new Imagick();
        $thumb->readImage($docPathTmb.$thumb_file);
        $thumb->resizeImage(0, 320,Imagick::FILTER_LANCZOS,1);
        $thumb->writeImage($docPathTmb.$thumb_file);
        $thumb->clear();
        $thumb->destroy();

        $dokumenta = new Dokumenta;
        $dokumenta->klijent_id = $request->klijent_id;
        $dokumenta->tip = $request->tip;
        $dokumenta->fajl = $new_file;
        $dokumenta->save();

        $resp_json['resp']['hiddenFolder'] = $hiddenFolder;
        $resp_json['resp']['new_file'] = $new_file;
        $resp_json['resp']['klijent_id'] = $request->klijent_id;
        $resp_json['resp']['tip'] = $request->tip;
        
        /*
        if($ext == 'pdf') {
			$zip_uid = uniqid();
			set_time_limit(0);			
			
			$pdftext = file_get_contents($docPath.$new_file);
			$num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
			 
			$resp_json['resp']['hiddenFolder'] = $hiddenFolder;
			$resp_json['resp']['new_file'] = $new_file;
			$resp_json['resp']['zip_uid'] = $zip_uid; 
			$resp_json['resp']['klijent_id'] = $request->klijent_id;
			$resp_json['resp']['tip'] = $request->tip;
			$resp_json['resp']['uuid'] = $request->uuid;
			$resp_json['resp']['filename'] = $request->filename;
			$resp_json['resp']['cntFiles'] = $num;
			$resp_json['resp']['ext'] = $ext;
            
        } else {
            
            if (!is_dir($docPath.'tmb'.DIRECTORY_SEPARATOR)) {
                mkdir($docPath.'tmb'.DIRECTORY_SEPARATOR, 0777, true );
            }
            exec("cp ".$docPath.$new_file." ".$docPath."tmb".DIRECTORY_SEPARATOR.$new_file);

            $thumb = new Imagick();
            $thumb->readImage($docPath."tmb".DIRECTORY_SEPARATOR.$new_file);
            $thumb->resizeImage(0, 320,Imagick::FILTER_LANCZOS,1);
            $thumb->writeImage($docPath."tmb".DIRECTORY_SEPARATOR.$new_file);
            $thumb->clear();
            $thumb->destroy(); 
            
            $dokumenta = new Dokumenta;
            $dokumenta->klijent_id = $request->klijent_id;
            $dokumenta->tip = $request->tip;
            $dokumenta->fajl = $new_file;
            $dokumenta->save();

            $resp_json['resp']['hiddenFolder'] = $hiddenFolder;
			$resp_json['resp']['new_file'] = $new_file;
			$resp_json['resp']['klijent_id'] = $request->klijent_id;
			$resp_json['resp']['tip'] = $request->tip;
			
        }*/

        return response()->json($resp_json);
    }

    public function processPDFs(Request $request): JsonResponse
	{
		$unzipError = false;
		$hiddenFolder = $request->hiddenfolder;


        $docPath = public_path('storage'.DIRECTORY_SEPARATOR.$hiddenFolder.DIRECTORY_SEPARATOR.$request->tip.DIRECTORY_SEPARATOR);
		$docStoragePath = storage_path('app/public').DIRECTORY_SEPARATOR.$hiddenFolder.DIRECTORY_SEPARATOR.$request->tip.DIRECTORY_SEPARATOR;

        $tmpDocPath = $docPath.$request->zip_uid.DIRECTORY_SEPARATOR;
		
		if (!is_dir($tmpDocPath)) {
            mkdir($tmpDocPath, 0777, true );
        }

        if (!is_dir($tmpDocPath.'zip')) {
            mkdir($tmpDocPath.'zip', 0777, true );
        }
		
		$zip_uid = $request->zip_uid;
		$new_file = $request->new_file;
		
		$url = "http://ocr.ristic-office.de:8182";
		$zip = "/convert/".$hiddenFolder."/".$request->tip."/".$zip_uid.".zip";
		$newZip = $docPath.$request->zip_uid.DIRECTORY_SEPARATOR.$zip_uid.".zip";
		$newZipStorage = $docStoragePath.$request->zip_uid.DIRECTORY_SEPARATOR.$zip_uid.".zip";
		
		$default_socket_timeout = ini_get('default_socket_timeout');
		set_time_limit(0);
		ini_set('default_socket_timeout', 1200);
		file_get_contents($url."/index.php?file=".$new_file."&klijent=".$hiddenFolder."&nalog=".$request->tip."&tip=".$request->tip."&uid=".$zip_uid);
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
                $fajlovi = new Dokumenta;

                $fajlovi->klijent_id = $request->klijent_id;
                $fajlovi->tip = $request->tip;
                $fajlovi->folder = $zip_uid;
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

    public function retrieveFile(Request $request): JsonResponse
    {
        Dokumenta::where('klijent_id', $request->klijent_id)
                    ->where('fajl', $request->fajl)
                    ->update(['aktivan' => 1]);

        return response()->json(['success'=>'true']);
    }

    public function deleteFile(Request $request): JsonResponse
    {
        Dokumenta::where('klijent_id', $request->klijent_id)
                    ->where('fajl', $request->fajl)
                    ->delete();

        $klijent = Klijenti::find($request->klijent_id);
        $klijent_token = $klijent->token;

        $hiddenFolder=substr($klijent_token,0,8);
        $dokumenta_path = public_path('storage'.DIRECTORY_SEPARATOR.$hiddenFolder.DIRECTORY_SEPARATOR.$request->tip.DIRECTORY_SEPARATOR);
        $docPathTmb = public_path('storage'.DIRECTORY_SEPARATOR.$hiddenFolder.DIRECTORY_SEPARATOR.$request->tip.DIRECTORY_SEPARATOR.'tmb'.DIRECTORY_SEPARATOR);
        $file =$dokumenta_path.$request->fajl;
        $tmb =$docPathTmb.$request->tmb;
        unlink($file);
        unlink($tmb);

        return response()->json(['success'=>'true']);
    }

    public function upload(Request $request): RedirectResponse
    {
        $klijent = Klijenti::find($request->id);
        if($klijent->token != NULL) {
            $hiddenfolder_enc = $klijent->token;
        } else {
            $hiddenfolder_enc = md5($klijent->naziv);
            Klijenti::find($request->id)
            ->update(
                ['token' => $hiddenfolder_enc]
            );

            $setToken = Klijenti::find($request->id);
            $setToken->token = $hiddenfolder_enc;
            $setToken->save();
        }

        $hiddenFolder=substr($hiddenfolder_enc,0,8);
        $docPath = public_path('storage'.DIRECTORY_SEPARATOR.$hiddenFolder.DIRECTORY_SEPARATOR);
        if (!is_dir($docPath)) {
            mkdir($docPath, 0777, true );
        }

        $uploaded_file = $request->file('upload');
                
        $new_file = bin2hex(date('Y-m-d').'_'.$klijent->id.'_'.uniqid()).'.pdf';

        $new_dokumenta = new Dokumenta();
        $datum_fajla = date('Y-m-d');
        $new_dokumenta->klijent_id = $request->id;
        $new_dokumenta->tip = $request->docType;
        $new_dokumenta->fajl = $new_file;
        $new_dokumenta->datum_fajla = $datum_fajla;
        $new_dokumenta->broj_fajla = 'upload';

        $new_dokumenta->save();


        $uploaded_file->move($docPath,$new_file);

        $new_dokumenta = new Dokumenta();
        $datum_fajla = date('Y-m-d');
        $new_dokumenta->klijent_id = $request->id;
        $new_dokumenta->tip = $request->docType;
        $new_dokumenta->fajl = $new_file;
        $new_dokumenta->datum_fajla = $datum_fajla;
        $new_dokumenta->broj_fajla = 'upload';

        $new_dokumenta->save();

        return redirect()->route('dokumenta.show',$request->id)
        ->with('success',$request->docType.' uspešno uploadovano');
    }

    public function showDokumenta(Request $request): View
    {
        $data = [];
        $klijent = Klijenti::where('id', $request->id)->first();
        $dokumenta = Dokumenta::where('klijent_id', $klijent->id)->where('tip', $request->docType)->get();

        $dokumenta = $dokumenta->map(function ($dokument) {
            $dokument->tmb = str_replace('.pdf','.jpg',$dokument->fajl);

            return $dokument;
        });
        //dd($dokumenta);

        $data += [
            'tip' => $request->docType,
            'tipName' => $request->docTypeName
        ];

        $klijent_token = $klijent->token;
        $hiddenFolder=substr($klijent_token,0,8);
        $dokumenta_path = DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.$hiddenFolder.DIRECTORY_SEPARATOR;
        $hiddenFolderPath = public_path($dokumenta_path);
        if (is_dir($hiddenFolderPath)) {
            $data += [
                'dokumenta_path' => $dokumenta_path
            ];
        } else {
            $data += [
                'dokumenta_path' => '-'
            ];
        }


        return view('Dokumenta.showDokumenta',compact('klijent','dokumenta'), $data);
    }

    public function show($id): View
    {
        $pass_doc = [];
        $klijent = Klijenti::find($id);
        $klijent_token = $klijent->token;
        $odgovorno_lice = OdgovornoLice::find($klijent->odgovorno_lice_id);
        $hiddenFolder=substr($klijent_token,0,8);
        $dokumenta_path = 'storage'.DIRECTORY_SEPARATOR.$hiddenFolder;
        $hiddenFolderPath = public_path($dokumenta_path);
        $analiticka_kartica = Dokumenta::where('klijent_id', $id)->where('tip','analiticka_kartica')->count();
        $depo_karton = Dokumenta::where('klijent_id', $id)->where('tip','depo_karton')->count();
        $vozila = Vozila::where('klijent_id', $id)->count();
        $licenca = Vozila::where('klijent_id', $id)->where('licenca', '!=', NULL)->count();
        $saobracajna = Vozila::where('klijent_id', $id)->where('saobracajna', '!=', NULL)->count();
        $pass_doc += [
            'analiticka_kartica' =>  $analiticka_kartica,
            'vozila' =>  $vozila,
            'licenca' =>  $licenca,
            'saobracajna' =>  $saobracajna,
            'depo_karton' =>  $depo_karton
        ];
        if (is_dir($hiddenFolderPath)) {
            $pass_doc += [
                'dokumenta_path' => $dokumenta_path
            ];
        } else {
            $pass_doc += [
                'dokumenta_path' => '-'
            ];
        }

        $ugovor = Dokumenta::where('klijent_id', $id)
                    ->where('tip', 'ugovor')
                    ->get();

        if($ugovor->isNotEmpty()) {
                $pass_doc += [
                    'ugovor' => $ugovor[0]->fajl,
                    'broj_ugovora' => $ugovor[0]->broj_fajla,
                    'datum_ugovora' => $ugovor[0]->datum_fajla
                ];
        } else {
            $pass_doc += [
                'ugovor' => '-',
                'broj_ugovora' => 'Nema',
                'datum_ugovora' => '-'
            ];
        }

        $pep = Dokumenta::where('klijent_id', $id)
                    ->where('tip', 'pep')
                    ->get();
        if($pep->isNotEmpty()) {
            $pass_doc += [
                'pep' => $pep[0]->fajl,
                'datum_pep' => $pep[0]->datum_fajla
            ];
        } else {
            $pass_doc += [
                'pep' => 'Nema',
                'datum_pep' => '-'
            ];
        }

        return view('Dokumenta.index',compact('klijent','odgovorno_lice'), $pass_doc);
    }
    public function destroy(Request $request, $id)
    {

        Dokumenta::where('klijent_id', $id)
        ->where('tip', $request->docType)
        ->delete();

        return redirect()->route('dokumenta.show',$id)
            ->with('success',$request->docType.' uspešno izbrisan');
    }

    public function sendMail(Request $request)
    {
        $email = $request->email;
        $docType = $request->docType;
        $docTypeName = $request->docTypeName;
        $data = [
            'docType' => $docType,
            'docTypeName' => $docTypeName
        ];
        $id = $request->query('id');
        $klijent = Klijenti::find($id);
        $klijent_token = $klijent->token;
        $hiddenFolder=substr($klijent_token,0,8);
        $dokumenta_path = 'storage'.DIRECTORY_SEPARATOR.$hiddenFolder;
        $hiddenFolderPath = public_path($dokumenta_path);


        $odgovorno_lice = OdgovornoLice::find($klijent->odgovorno_lice_id);
        $dokumenta = Dokumenta::where('klijent_id', $id)->where('tip',$docType)->first();

        //dd($dokumenta[0]);


        if($odgovorno_lice->pol == 1) {
            $data += [
                'formalno' => 'Postovani g.'
            ];
        } else {
            $data += [
                'formalno' => 'Postovana gđo.'
            ];
        }

        $data += [
            'ime' => $odgovorno_lice->ime,
            'prezime' => $odgovorno_lice->prezime,
            'email' => $email,
        ];

        $file = env('APP_URL').DIRECTORY_SEPARATOR.$dokumenta_path.DIRECTORY_SEPARATOR.$dokumenta->fajl;

        //dd($dokumenta);

        Mail::send('Mailovi.mail', $data, function($message)use($docTypeName, $email, $odgovorno_lice, $file) {
            $message->to($email)
            ->subject('Akcize.rs | '.$docTypeName);
            $message->attach($file, [
                'as' => $docTypeName.'.pdf',
                'mime' => 'application/pdf'
            ]);
        });
        return redirect()->route('dokumenta.show',$id)
        ->with('success',$request->docType.' uspešno poslat');



    }

}
