<?php
namespace App\Helpers;

use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
// use Image;
// use Intervention\Image\ImageManager;

class General
{

    public static function cekShiftToday($user_shift_id=null)
    {
        $cek_shift = Shift::where('is_active', 1)->first();
        $day_now = date('D');
        if($cek_shift) {   
            switch($day_now){
                case 'Sun':
                    $jam_masuk = $cek_shift->minggu_in == null ? null : date('H:i', strtotime($cek_shift->minggu_in));
                    $jam_pulang = $cek_shift->minggu_out == null ? null : date('H:i', strtotime($cek_shift->minggu_out));
                break;
         
                case 'Mon':			
                    $jam_masuk = date('H:i', strtotime($cek_shift->senin_in));
                    $jam_pulang = date('H:i', strtotime($cek_shift->senin_out));
                break;
         
                case 'Tue':
                    $jam_masuk = date('H:i', strtotime($cek_shift->selasa_in));
                    $jam_pulang = date('H:i', strtotime($cek_shift->selasa_out));
                break;
         
                case 'Wed':
                    $jam_masuk = date('H:i', strtotime($cek_shift->rabu_in));
                    $jam_pulang = date('H:i', strtotime($cek_shift->rabu_out));
                break;
         
                case 'Thu':
                    $jam_masuk = date('H:i', strtotime($cek_shift->kamis_in));
                    $jam_pulang = date('H:i', strtotime($cek_shift->kamis_out));
                break;
         
                case 'Fri':
                    $jam_masuk = date('H:i', strtotime($cek_shift->jumat_in));
                    $jam_pulang = date('H:i', strtotime($cek_shift->jumat_out));
                break;
         
                case 'Sat':
                    $jam_masuk = date('H:i', strtotime($cek_shift->sabtu_in));
                    $jam_pulang = date('H:i', strtotime($cek_shift->sabtu_out));
                break;
                
                default:
                    $jam_masuk = null;		
                    $jam_pulang = null;		
                break;
            }
            $data = [
                'id' => $cek_shift->id,
                'shift_name' => $cek_shift->shift_name,
                'status' => $jam_masuk == null && $jam_pulang == null ? 'libur' : 'masuk',
                'jam_masuk' => $jam_masuk,
                'jam_pulang' => $jam_pulang,
            ];
            return $data; 
        } else {
            return false;
        }
    }

    public static function cekShift($user_shift_id=null)
    {
        $cek_shift = Shift::where('id', $user_shift_id)->where('is_active', 1)->first();
        $day_now = date('D');
        if($cek_shift) {   
            switch($day_now){
                case 'Sun':
                    $jam_masuk = $cek_shift->minggu_in == null ? null : date('H:i', strtotime($cek_shift->minggu_in));
                    $jam_pulang = $cek_shift->minggu_out == null ? null : date('H:i', strtotime($cek_shift->minggu_out));
                break;
         
                case 'Mon':			
                    $jam_masuk = date('H:i', strtotime($cek_shift->senin_in));
                    $jam_pulang = date('H:i', strtotime($cek_shift->senin_out));
                break;
         
                case 'Tue':
                    $jam_masuk = date('H:i', strtotime($cek_shift->selasa_in));
                    $jam_pulang = date('H:i', strtotime($cek_shift->selasa_out));
                break;
         
                case 'Wed':
                    $jam_masuk = date('H:i', strtotime($cek_shift->rabu_in));
                    $jam_pulang = date('H:i', strtotime($cek_shift->rabu_out));
                break;
         
                case 'Thu':
                    $jam_masuk = date('H:i', strtotime($cek_shift->kamis_in));
                    $jam_pulang = date('H:i', strtotime($cek_shift->kamis_out));
                break;
         
                case 'Fri':
                    $jam_masuk = date('H:i', strtotime($cek_shift->jumat_in));
                    $jam_pulang = date('H:i', strtotime($cek_shift->jumat_out));
                break;
         
                case 'Sat':
                    $jam_masuk = date('H:i', strtotime($cek_shift->sabtu_in));
                    $jam_pulang = date('H:i', strtotime($cek_shift->sabtu_out));
                break;
                
                default:
                    $jam_masuk = null;		
                    $jam_pulang = null;		
                break;
            }
            $data = [
                'id' => $cek_shift->id,
                'shift_name' => $cek_shift->shift_name,
                'status' => $jam_masuk == null && $jam_pulang == null ? 'libur' : 'masuk',
                'jam_masuk' => $jam_masuk,
                'jam_pulang' => $jam_pulang,
            ];
            return $data; 
        } else {
            return false;
        }
    }

    public static function convertSecondToStringTime($second_time = null) {
        $hours = floor($second_time / 3600);
        $minutes = floor(($second_time % 3600) / 60);
        $seconds = $second_time % 60;

        $timeString = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

        return $timeString;
    }
    
    public static function tanggalMerah($value)
    {
        // $array = (array)json_decode(file_get_contents('https://raw.githubusercontent.com/guangrei/Json-Indonesia-holidays/master/calendar.json'));
        // if (isset($array[$value])) {
        //     echo "tanggal merah " . $array[$value]["deskripsi"];
        // } else if (date("D", strtotime($value)) === "Sun") {
        //     echo "tanggal merah hari minggu";
        // } else {
        //     echo "bukan tanggal merah";
        // }

        if (date("D", strtotime($value)) === "Sun") {
            $is_sunday = true;  
        } else {
            $is_sunday = false;  
        }

        return $is_sunday;
    }

    public static function tanggalMerahOnline($value)
    {
        $array = (array)json_decode(file_get_contents('https://raw.githubusercontent.com/guangrei/Json-Indonesia-holidays/master/calendar.json'));
        
        // dd($array);
        $day_identity = [];

        // if (isset($array[$value])) {
        if (isset($array[$value]) == $value) {
            $day_identity = [
                'libur' => true,
                'ket' => $array[$value]->deskripsi
            ];
        } else if (date("D", strtotime($value)) === "Sun") {
            $day_identity = [
                'libur' => true,
                'ket' => null
            ];
        } else {
            $day_identity = [
                'libur' => false,
                'ket' => null
            ];
        }

        return $day_identity;
    }

    public static function dateIndo($date)
    {
        return Carbon::parse( $date )->isoFormat('dddd, D MMMM Y');
    }
    
    public static function saveFileStorage($file, $destinationFolder)
    {
        $name = time() . '-' . $file->getClientOriginalName();
        $file->move($destinationFolder . '/normal', $name);

        // $img = ImageResize::make($file->path());
        // $img->resize(100, 100, function ($constraint) {
        //     $constraint->aspectRatio();
        // })->move($destinationFolder.'/thumb'.$name);

        // $img->resize(300, null, function ($constraint) {
        //     $constraint->aspectRatio();
        // })->move($destinationFolder.'/medium'.$name);

        return $name;
    }

    public static function deleteFileStorage($filename, $destinationFolder)
    {
        Storage::disk($destinationFolder)->delete($filename);
        return true;
    }

    public static function noxss($string)
    {
        // echo htmlentities($string, ENT_QUOTES, 'UTF-8');
        return preg_replace('/[^a-zA-Z0-9]/', '', $string);
    }

    public static function sanitizeTolower($string)
    {
        return strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $string));
    }

    public static function sanitizeToUpper($string)
    {
        return strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', $string));
    }

}
