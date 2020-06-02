<?php namespace App\Database\Seeds;

use App\Models\Barangay;

class BarangaySeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $json = json_decode($this->loadJson(), true);
        foreach ($json as $key => $psgc_data) {
            $data = [];
            $data['province_name'] = $psgc_data[0];
            $data['province_psgc'] = $psgc_data[1];
            $data['city_name'] = $psgc_data[2];
            $data['city_psgc'] = $psgc_data[3];
            $data['barangay_name'] = $psgc_data[4];
            $data['barangay_psgc'] = $psgc_data[5];
            $data['district'] = $psgc_data[6];
            $data['subdistrict'] = $psgc_data[7];
            $barangay = new Barangay();
            $barangay->save($data);
            $barangay_id = $barangay->insertID();
            $barangay = new Barangay();
            $created_barangay = $barangay->find($barangay_id);
            echo "created barangay: [$created_barangay->barangay_psgc] $created_barangay->province_name - $created_barangay->barangay_name \n";
        }
    }

    public function loadJson()
    {
        $json = file_get_contents("json/psgc.json");
        return $json;
    }
}