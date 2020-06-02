<?php namespace App\Models;

use CodeIgniter\Model;

class Barangay extends Model
{
    protected $table         = 'barangays';
    protected $primaryKey    = 'id';
    protected $returnType    = 'object';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $allowedFields = [
        'barangay_name',
        'barangay_psgc',
        'province_name',
        'province_psgc',
        'city_name',
        'city_psgc',
        'district',
        'subdistrict',
    ];
}