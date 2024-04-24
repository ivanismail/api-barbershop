<?php

namespace App\Http\Controllers;

use App\Library\Res;
use App\Models\User;
use App\Models\Shaver;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use Illuminate\Support\Carbon;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
     public function shaver(Request $req)
     {
         try {
             $data = Shaver::where('active', '1')
                            ->orderBy('shaver_name', 'ASC') 
                            ->get();
             return Res::success($data, 'Data Shaver');
         } catch (\Throwable $th) {
             return Res::error($th, 'Server Error');
         } 
     }
     public function service_category(Request $req)
     {
         try {
             $data = ServiceCategory::where('active', '1')->get();
             return Res::success($data, 'Data Category Shaver');
         } catch (\Throwable $th) {
             return Res::error($th, 'Server Error');
         } 
     }
     public function service(Request $req)
     {
         try {
             $category = $req->category;
             $data = null;
             if ($category == 'all'){
                $data = Service::where('active', '1')->get();
             } else {
                $data = Service::where('active', '1')
                                    ->where('category_id',$category)                   
                                    ->get();
             }
             return Res::success($data, 'Data Category Shaver');
         } catch (\Throwable $th) {
             return Res::error($th, 'Server Error');
         } 
     }
     public function history(Request $req)
     {
         try {
             $data = Booking::join('service_categories as b', 'bookings.category_id', '=', 'b.id')
                                     ->join('general_settings as c', 'bookings.status', '=', 'c.value')                                     
                                     ->join('services as d', 'bookings.service_id', '=', 'd.id')
                                     ->join('shavers as e', 'bookings.shaver_id', '=', 'e.id')
                                     ->where('user_id',auth()->user()->id)
                                     ->where('c.code','STS')
                                     ->orderBy('bookings.id', 'DESC') 
                                     ->whereDate('bookings.created_at', '>', Carbon::now()->subDays(30)) 
                                     ->get(['bookings.id',   
                                            'b.category_name as category',
                                            'd.service_name as service',
                                            'e.shaver_name as shaver',
                                            'bookings.price',
                                            'bookings.date',                                            
                                            'bookings.time',
                                            'bookings.payment_methode',
                                            'bookings.note',
                                            'c.description as status',
                                            'bookings.created_at'
                                        ]);
             return Res::success($data, 'Data Booking');
         } catch (\Throwable $th) {
             return Res::error($th, 'Server Error');
         } 
     }
     public function profile(Request $req)
     {
         try {
             //* CEK USER ACTIVE
            $user = User::whereId(auth()->user()->id)->where('active', '1')->first();
            if(is_null($user)){
                return Res::error(null, "User Not Found");
            }
             return Res::success($user, 'Data Profile');
         } catch (\Throwable $th) {
             return Res::error($th, 'Server Error');
         } 
     }
     public function gs(Request $req)
     {
         try {
            $data = GeneralSetting::where(['active'=>'1','code'=>$req->code])->get();
             return Res::success($data, 'Data General Setting');
         } catch (\Throwable $th) {
             return Res::error($th, 'Server Error');
         } 
     }
     public function booking(Request $req)
     {
         $category = $req->input('category');
         $service = $req->input('service');
         $shaver = $req->input('shaver');         
         $price = $req->input('price');         
         $date = $req->input('date');                
         $time = $req->input('time');
         $payment_methode = $req->input('payment_methode');
         $note = $req->input('note');
         try {            
            DB::beginTransaction();
            //* CEK USER ACTIVE
            $user = User::whereId(auth()->user()->id)->where('active', '1')->first();
            if(is_null($user)){
                return Res::error(null, "User Not Found");
            }
             //* CEK BOOKING PENDING
            $booking = Booking::whereIn('status', array('1', '2'))->whereDate('created_at', Carbon::today())->first();
            if($booking){
                return Res::error($booking, "Masih ada transaksi yang belum dibayar.");
            }
            $create = null;
            if ($payment_methode == 'Tunai') {
                $create = Booking::create([
                    'user_id' => $user->id,
                    'category_id' => $category,
                    'service_id' => $service,
                    'shaver_id' => $shaver,
                    'price' => $price, 
                    'date' => $date,
                    'time' => $time,
                    'note' => $note,
                    'payment_methode' => $payment_methode,
                    // 'expired' => Carbon::now()->addMinutes(60),
                    'status' => '2',
                ]);
            } else {
                $create = Booking::create([
                    'user_id' => $user->id,
                    'category_id' => $category,
                    'service_id' => $service,
                    'shaver_id' => $shaver,
                    'price' => $price, 
                    'date' => $date,
                    'time' => $time,
                    'note' => $note,
                    'payment_methode' => $payment_methode,
                    // 'expired' => Carbon::now()->addMinutes(60),
                    'status' => '1',
                ]);
            }           
            DB::commit();
            return Res::success($create, 'Berhasil membuat booking');
         } catch (\Throwable $th) {            
            DB::rollBack(); 
            return Res::error($th, 'Server Error');
         } 
     }
     public function check_availability(Request $req)
     {
         $shaver = $req->input('shaver');         
         $date = $req->input('date');                
         try {            
            //* CEK USER ACTIVE
            $user = User::whereId(auth()->user()->id)->where('active', '1')->first();
            if(is_null($user)){
                return Res::error(null, "User Not Found");
            }
             //* CEK KETERSEDIAAN
            $booking = Booking::where('status', array('1', '2'))->whereDate('created_at', Carbon::today())->first();
            if($booking){
                return Res::error($booking, "Masih ada transaksi yang belum dibayar.");
            }
            $query = "SELECT 
                        a.description as time,
                        CASE
                            WHEN count(b.id) > 0 THEN false
                            WHEN count(b.id) = 0 THEN true
                            ELSE true
                        END AS available
                        FROM
                        general_settings a
                        LEFT JOIN bookings b ON a.description = b.time AND b.date=:TGL AND b.shaver_id=:SHV
                        WHERE a.code ='schedule' 
                        GROUP BY a.description";
            $transaction = DB::select($query,['TGL'=> $req->date, 'SHV'=>$req->shaver]);    
            return Res::success($transaction, 'Data Ketersediaan Jadwal');
         } catch (\Throwable $th) {   
            return Res::error($th, 'Server Error');
         } 
     }
     public function queue(Request $req)
     {
         $shaver = $req->input('shaver');         
         $date = $req->input('date');                
         try { 
            $dates = Carbon::today();
            // Convert Carbon instance to date in a specific format
            $dateString = $dates->format('Y-m-d'); // Format as YYYY-MM-DD           
            //* CEK ANTRIAN
            $query = "SELECT b.description as sts, COUNT(*) as total
                        FROM bookings a
                        LEFT JOIN general_settings b on a.`status` = b.`value` AND b.`code`='STS'
                        WHERE date=:TGL
                        GROUP BY sts;";
            $transaction = DB::select($query,['TGL'=> $dateString]);    
            return Res::success($transaction, 'Data Antrian');
         } catch (\Throwable $th) {   
            return Res::error($th, 'Server Error');
         } 
     }
}
