<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \RouterOS\Client;
use RouterOS\Query;

class RouterController extends Controller
{
    //
    public function getRouterView()
    {
        return view("routers");
    }
    public function verificarCredencialesRouter(Request $request)
    {
        $client = new Client([
            'host' => $request->ip,
            'user' => $request->user,
            'pass' => $request->pass
        ]);

        // Send "equal" query with details about IP address which should be created
        $query =
            (new Query('/system/routerboard/print'));

        // Send query and read response from RouterOS (ordinary answer from update/create/delete queries has empty body)
        $response = $client->query($query)->read();
        
        return $response[0];
    }
}
