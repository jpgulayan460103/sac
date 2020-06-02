<?php namespace App\Models;

use CodeIgniter\Model;

class HouseholdMember extends Model
{
    protected $table         = 'household_members';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $allowedFields = [
        'household_head_id',
        'first_name',
        'middle_name',
        'last_name',
        'ext_name',
        'relasyon_sa_punong_pamilya',
        'kasarian',
        'kapanganakan',
        'trabaho',
        'pinagtratrabahuhang_lugar',
        'sektor',
        'kondisyon_ng_kalusugan',
        'created_at',
        'updated_at',
    ];
}