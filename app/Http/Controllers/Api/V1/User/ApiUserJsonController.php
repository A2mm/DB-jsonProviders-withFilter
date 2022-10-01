<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\JsonProviderService;
use App\Services\DBJsonProviderService;
use DB;
use Exception;

class ApiUserJsonController extends Controller
{
    protected $storageFolder = "dataproviders";

    /*
    * FETCH USERS DATA FROM JSON FILES 
    * @param Request $request, JsonProviderService $JsonProviderService
    * @return JsonResponse
    */
    public function fech_users(Request $request, JsonProviderService $JsonProviderService)
    {
        $requestData = $request->all();
        try{
            $data        = $JsonProviderService->getAllParents($requestData);
            $total       = count($data);
            $message     = 'success';
            return response()->json([
            	'total'   => $total,
            	'message' => $message,
            	'data'    => $data, 
            ]);
        }catch(Exception $exception){
            return $exception;
        }
    }

    /*
    * FETCH USERS DATA FROM DATABASE 
    * @param Request $request,  DBJsonProviderService $DBJsonProviderService
    * @return JsonResponse
    */
    public function fechAndFilterUsingDB(Request $request, DBJsonProviderService $DBJsonProviderService)
    {
        $requestData = $request->all();
        try{
            $data        = $DBJsonProviderService->getAllParents($requestData);
            $total       = count($data);
            $message     = 'success';
            return response()->json([
                'total'   => $total,
                'message' => $message,
                'data'    => $data, 
            ]);
        }catch(Exception $exception){
            return $exception;
        }
    }

    /*
    * READ JSON FILES DATA AND INSERT IT INTO DATABASE 
    * (DYNAMICALLY INSERT (USERS || TRANSACTIONS , ........))
    * @param string $file 
    * @return JsonResponse
    */
    public function readJsonAndInsertDB(string $file)
    {
        $filePath      = storage_path($this->storageFolder.'/').$file.'.json';
        $json_contents = file_get_contents($filePath);
        $data          = json_decode($json_contents, true);
        $jsonFileUsers = $data[$file];

        DB::table($file)->truncate();
        DB::table($file)->insert($jsonFileUsers);

        $message     = 'success';
        return response()->json([
            'message' => $message,
            'data'    => $jsonFileUsers, 
        ]);
    }

}
