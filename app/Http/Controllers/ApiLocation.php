<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiLocation extends Controller
{
    public function getProvinces(){
        $response = Http::get('https://alamat.thecloudalert.com/api/provinsi/get/');
        return $response->json('result');
    }
    public function getCity($province_id){
        $response = Http::get("https://alamat.thecloudalert.com/api/kabkota/get/?d_provinsi_id=$province_id");
        return $response->json('result');
    }
    public function getSubDistrict($city_id){
        $response = Http::get("https://alamat.thecloudalert.com/api/kecamatan/get/?d_kabkota_id=$city_id");
        return $response->json('result');
    }
    public function getPostalCode($city_id, $district_id){
        $response = Http::get("https://alamat.thecloudalert.com/api/kodepos/get/?d_kabkota_id=$city_id&d_kecamatan_id=$district_id");
        return $response->json('result');
    }
}
