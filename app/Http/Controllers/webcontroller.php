<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use RealRashid\SweetAlert\Facades\Alert;

class webcontroller extends Controller
{

    public function index(Request $request)
    {
        return view('index');
    }

    public function dashboard(Request $request)
    {
        return view('dashboard');
    }

    public function generate(Request $request)
    {
        return view('generate');
    }

    public function redeem(Request $request)
    {
        return view('generate');
    }

    public function redeemCode(Request $request)
    {
        // return $request->all();
      $order = Order::where("code", $request->codeInput)->first();
      if($order)
      {
        if($order->status_code == "0")
        {
            Order::where("code", $request->codeInput)->update([
                "status_code" => 1,

            ]);
            // $answer = shell_exec("C:\\Program Files\\dslrBooth\\dslrBooth.exe");
            // $answer = shell_exec("START /MAX notepad");
            // $answer = shell_exec("START /MAX notepad");
            $answer = shell_exec("cd C:/Program Files/dslrBooth && START /MAX dslrBooth");
            return redirect()->back()->with("success", "siap foto");
        }
        elseif($order->status_code == "1")
        {
            return redirect()->back()->with("error", "Voucher sudah dipakai");
        }

      }
      else{
        return redirect()->back()->with("error", "Voucher tidak ditemukan");
      }
    }

    public function generateCode(Request $request)
    {
        $firstName = 'FromCashier';
        $lastName = time();
        $email = 'fromcashier@getnada.com';
        $phoneNumber = '08123';
        $grossAmount = '25000';
        $status_code = 0;


        $order = new Order();
        $order->uname = $firstName . '-' . $lastName;
        $order->email = $email;
        $order->number = $phoneNumber;
        $order->order_id = rand();
        $order->gross_amount = $grossAmount;
        $order->status = 'paid';
        $order->status_code = $status_code;
        $order->code = $this->getRandomstring(6);
        $order->save();

        return view('generate', compact('order'));
    }

    public function generatePayment(Request $request)
    {
        $firstName = 'Customer';
        $lastName = time();
        $email = 'customer@getnada.com';
        $phoneNumber = '08123';
        $grossAmount = '25000';
        $status_code = 1;

        $order = new Order();
        $order->uname = $firstName . '-' . $lastName;
        $order->email = $email;
        $order->number = $phoneNumber;
        $order->order_id = rand();
        $order->gross_amount = $grossAmount;
        $order->status_code = $status_code;
        $order->save();


        // Set your Merchant Server Key
        // return config('app.midtrans_key');
        \Midtrans\Config::$serverKey = config('app.midtrans_key');
        
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $order->order_id,
                'gross_amount' =>  $order->gross_amount,
            ),
            'item_details' => array(
                [
                    'id' => 'a1',
                    'price' =>  $order->gross_amount,
                    'quantity' => '1',
                    'name' => 'photobooth'
                ],
            ),
            // 'customer_details' => array(
            //     'first_name' => $request->get('uname'),
            //     'last_name' => '',
            //     'email' => $request->get('email'),
            //     'phone' => $request->get('number'),
            // ),
            'customer_details' => array(
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => $phoneNumber,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return $snapToken;
    }

    public function payment(Request $request)
    {
        // $firstName = 'Customer';
        // $lastName = time();
        // $email = 'customer@getnada.com';
        // $phoneNumber = '08123';
        // $grossAmount = '25000';
        // $status_code = 1;

        // $order = new Order();
        // $order->uname = $firstName . '-' . $lastName;
        // $order->email = $email;
        // $order->number = $phoneNumber;
        // $order->order_id = rand();
        // $order->gross_amount = $grossAmount;
        // $order->status_code = $status_code;
        // $order->save();


        // // Set your Merchant Server Key
        // \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        // // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        // \Midtrans\Config::$isProduction = false;
        // // Set sanitization on (default)
        // \Midtrans\Config::$isSanitized = true;
        // // Set 3DS transaction for credit card to true
        // \Midtrans\Config::$is3ds = true;

        // $params = array(
        //     'transaction_details' => array(
        //         'order_id' => $order->order_id,
        //         'gross_amount' =>  $order->gross_amount,
        //     ),
        //     'item_details' => array(
        //         [
        //             'id' => 'a1',
        //             'price' =>  $order->gross_amount,
        //             'quantity' => '1',
        //             'name' => 'photobooth'
        //         ],
        //     ),
        //     // 'customer_details' => array(
        //     //     'first_name' => $request->get('uname'),
        //     //     'last_name' => '',
        //     //     'email' => $request->get('email'),
        //     //     'phone' => $request->get('number'),
        //     // ),
        //     'customer_details' => array(
        //         'first_name' => $firstName,
        //         'last_name' => $lastName,
        //         'email' => $email,
        //         'phone' => $phoneNumber,
        //     ),
        // );

        // $snapToken = \Midtrans\Snap::getSnapToken($params);

        // return $snapToken; 

        return view('payment');
        // return view('payment', ['snap_token' => $snapToken]);
    }

    public function payment_post(Request $request)
    {
        $json = json_decode($request->get('json'));
        $orderID = Order::where('order_id', $json->order_id)->first()->id;
        $order = Order::find($orderID);
        $order->status = $json->transaction_status;
        $order->transaction_id = $json->transaction_id;
        $order->payment_type = $json->payment_type;

        if (isset($json->payment_code)) {
            $order->payment_code = $json->payment_code;
        }
        if (isset($json->pdf_url)) {
            $order->pdf_url = $json->pdf_url;
        }
        return $order->save() ? redirect(url('/'))->with('alert-success', 'order berhasil dibuat') : redirect(url('/'))->with('alert-failed', 'order gagal dibuat');
    }
    private function getRandomstring($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
}
