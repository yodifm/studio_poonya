<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function payment_handler(Request $request)
    {
        $json = json_decode($request->getContent());

        $signature_key = hash('sha512', $json->order_id . $json->status_code . $json->gross_amount . env('MIDTRANS_SERVER_KEY'));
        if($signature_key != $json->signature_key)
        {
            return abort(404);
        }

        //status berhasil
        $order = Order::where('order_id', $json->order_id)->first();
        return $order->update(['status'=>$json->transaction_status]);
    }

    public function init_camera(Request $request)
    {
        shell_exec('"C:\Users\RakaP\AppData\Local\Programs\UiPath\Studio\UiRobot.exe" -file "C:\Users\RakaP\OneDrive\Documents\UiPath\TriggerBasedAttendedAutomation\Main - Test.xaml"');


        // $url ='http://localhost:1500/api/start?mode=print&password=I9okCyP7dih2QEQs';

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL,$url);
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HEADER, false);
        // $output = curl_exec($ch);
        // curl_close($ch);

        // shell_exec("cd C:/Program Files/dslrBooth && START /MAX dslrBooth");
    }

    public function trigger_info(Request $request)
    {
        if ($request->event_type == 'sharing_screen') {
            shell_exec('cd C:/Program Files/dslrBooth && taskkill /F /IM "dslrBooth.exe" ');
            # code...
        }
       return Log::error($request->all());
    }

}
