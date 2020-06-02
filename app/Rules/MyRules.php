<?php

namespace App\Rules;

class MyRules
{
    /* 
    sektors
    A - Nakatatanda
    B - Buntis
    C - Nagpapasusong Ina
    D - PWD
    E - Solo Parent
    F - Walang Tirahan
    W - Wala sa pagpipilian

    relasyon
    1 - Puno ng Pamilya
    2 - Asawa
    3 - Anak
    4 - Kapatid
    5 - Bayaw o Hipag
    6 - Apo
    7 - Ama / Ina
    8 - Iba pang Kamag-anak


    */
    public function allowed_string(string $str = null): bool
    {
        if(trim($str)=="" || $str==null){
            return true;
        }
        return preg_match('/^[\pL\pM_\'_-_-_ _._\/_&_(_)_,0-9]+$/u', $str) > 0;
    }
    public function allowed_string_name(string $str = null): bool
    {
        if(trim($str)=="" || $str==null){
            return true;
        }
        return preg_match('/^[\pL\pM_ _-_-]+$/u', $str) > 0;
    }
    public function required_if(string $str = null, string $field, array $data): bool
    {
        sscanf($field, '%[^.].%[^.]', $field, $arg);
        $str = trim(strtolower($str));
        $arg = trim(strtolower($arg));
        $data[$field] = trim(strtolower($data[$field]));
        if($data[$field] == $arg){
            return !($str == "" || $str == "-" || $str == "n");
        }
        return true;
    }
    public function disallow_dash(string $str = null): bool
    {
        return trim($str) != "-";
    }
    
    public function required_if_not_empty(string $str = null, string $field, array $data): bool
    {
        sscanf($field, '%[^.].%[^.]', $field, $arg);
        $str = trim(strtolower($str));
        $data[$field] = trim(strtolower($data[$field]));
        if($data[$field] != "" && $data[$field] != "-" && $data[$field] !="n"){
            return ($str != "" && $str != "-" && $str !="n");
        }else{
            return true;
        }
    }

    public function custom_valid_date(string $str = null)
    {
        $str = trim($str);
        $date = explode('/', $str);
        if(!isset($date[0])){
            return false;
        }
        if(!isset($date[1])){
            return false;
        }
        if(!isset($date[2])){
            return false;
        }
        return checkdate($date[0],$date[1],$date[2]);
    }

    public function valid_birthdate(string $str = null)
    {
        if($this->custom_valid_date($str)){
            return ($this->getAge($str, date('m/d/Y')) >= 0);
        }
        return false;
    }

    private function getAge($dob, $condate){ 
        $birthdate = new \DateTime(date("m-d-Y",  strtotime(implode('-', explode('/', $dob)))));
        $today= new \DateTime(date("m-d-Y",  strtotime(implode('-', explode('/', $condate)))));           
        $age = $birthdate->diff($today)->format('%R%a');
        if((integer)$age < 0){
            return -1;
        }else{
            $age = $birthdate->diff($today)->y;
        }
        return $age;
    }

    public function valid_nakakatanda(string $value = null, $index = null, array $data)
    {
        if($index != null){
            $data['kapanganakan'] = $data['members'][$index]['kapanganakan'];
        }
        if($value == "A - Nakatatanda"){
            $kapanganakan = $data['kapanganakan'];
            $base_date = "05/01/2020";
            $age = $this->getAge($kapanganakan, $base_date);
            return ($age>=60);
        }
    }
    
    public function valid_ina(string $value = null, $index = null, array $data)
    {
        if($index != null){
            $data['kasarian'] = $data['members'][$index]['kasarian'];
        }
        if($value == "B - Buntis" || $value == "C - Nagpapasusong Ina"){
            $kasarian = strtolower($data['kasarian']);
            return $kasarian == "f";
        }
    }
    public function valid_ina_age(string $value = null, $index = null, array $data)
    {
        if($index != null){
            $data['kapanganakan'] = $data['members'][$index]['kapanganakan'];
        }
        if($value == "B - Buntis" || $value == "C - Nagpapasusong Ina"){
            $kapanganakan = $data['kapanganakan'];
            $base_date = "05/01/2020";
            $age = $this->getAge($kapanganakan, $base_date);
            return ($age>8);
        }
    }
    public function valid_relasyon_age(string $value = null, $index = null, array $data)
    {
        $member_dob = $data['members'][$index]['kapanganakan'];
        $head_dob = $data['kapanganakan'];
        $base_date = "05/01/2020";

        $head_age = $this->getAge($head_dob, $base_date);
        $member_age = $this->getAge($member_dob, $base_date);
        $age_difference = $head_age - $member_age;
        switch ($value) {
            case "3 - Anak":
                return $age_difference > 8; 
                break;
            case "6 - Apo":
                return $age_difference > 16; 
                break;
            case "7 - Ama / Ina":
                $age_difference = $member_age - $head_age;
                return $age_difference > 8; 
                break;
            default:
                
                break;
        }
        return false;
    }
}