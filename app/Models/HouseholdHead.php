<?php namespace App\Models;

use CodeIgniter\Model;

class HouseholdHead extends Model
{
    protected $table         = 'household_heads';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $allowedFields = [
        'barangay_id',
        'first_name',
        'middle_name',
        'last_name',
        'ext_name',
        'kasarian',
        'tirahan',
        'kalye',
        'uri_ng_id',
        'numero_ng_id',
        'kapanganakan',
        'trabaho',
        'buwanang_kita',
        'cellphone_number',
        'pinagtratrabahuhang_lugar',
        'sektor',
        'kondisyon_ng_kalusugan',
        'bene_uct',
        'bene_4ps',
        'katutubo',
        'katutubo_name',
        'bene_others',
        'others_name',
        'petsa_ng_pagrehistro',
        'pangalan_ng_punong_barangay',
        'pangalan_ng_lswdo',
        'sac_number',
    ];
}