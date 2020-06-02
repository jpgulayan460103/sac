<?php namespace App\Models;

use CodeIgniter\Model;

class HouseholdMembers extends Model
{
    protected $table         = 'household_members';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}