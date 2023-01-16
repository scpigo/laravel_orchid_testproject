<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use Dadata\DadataClient;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function adress(Request $request)
    {
        $query = $request->get('query');

        $token = env("DADATA_TOKEN");
        $secret = env("DADATA_SECRET");
        $dadata = new DadataClient($token, $secret);

        $result = $dadata->suggest("address", $query);

        return response()->json($result);
    }

    public function classification(Request $request)
    {
        $query = $request->get('query');

        return Classification::query()->where('keyword', 'ilike', '%' . $query . '%')->get()->pluck('keyword')->toArray();
    }
}
