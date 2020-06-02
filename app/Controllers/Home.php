<?php namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\HouseholdHead;
use App\Models\HouseholdMember;
use App\Models\Barangay;

class Home extends BaseController
{
	use ResponseTrait;
	private $db;
	function __construct() {
		$this->db = \Config\Database::connect();
	}
	
	public function index()
	{
		return view('form_test');
	}

	public function create()
	{
		$rules = [
            'first_name' => 'required|disallow_dash|allowed_string_name|min_length[2]|max_length[100]',
            'middle_name' => 'allowed_string_name|disallow_dash|max_length[100]',
            'last_name' => 'required|disallow_dash|allowed_string_name|min_length[2]|max_length[100]',
            'ext_name' => 'allowed_string_name|disallow_dash|max_length[100]',
            'kasarian' => 'required|max_length[1]',
            'tirahan' => 'required|allowed_string|max_length[200]',
            'kalye' => 'required|allowed_string|max_length[200]',
            'uri_ng_id' => 'required|allowed_string|max_length[200]',
            'numero_ng_id' => 'required|allowed_string|max_length[200]',
            'kapanganakan' => 'required|valid_birthdate',
            'trabaho' => 'required|allowed_string|required_if_not_empty[pinagtratrabahuhang_lugar]|max_length[200]',
            'buwanang_kita' => 'required|numeric',
            'pinagtratrabahuhang_lugar' => 'required|required_if_not_empty[trabaho]|allowed_string|max_length[200]',
            'sektor' => 'required|valid_nakakatanda[]|valid_ina[]|allowed_string|max_length[200]',
            'kondisyon_ng_kalusugan' => 'required|allowed_string|max_length[200]',
            'bene_uct' => 'required|allowed_string|max_length[200]',
            'bene_4ps' => 'required|allowed_string|max_length[200]',
            'katutubo' => 'required|required_if_not_empty[katutubo_name]|allowed_string|max_length[200]',
            'katutubo_name' => 'required|required_if[katutubo.Y]|allowed_string|max_length[200]',
            'bene_others' => 'required|required_if_not_empty[others_name]|allowed_string|max_length[200]',
            'others_name' => 'required|required_if[bene_others.Y]|allowed_string|max_length[200]',
            'petsa_ng_pagrehistro' => 'required|valid_birthdate',
            'pangalan_ng_punong_barangay' => 'required|disallow_dash|allowed_string_name|max_length[200]',
            'pangalan_ng_lswdo' => 'required|disallow_dash|allowed_string_name|max_length[200]',
            'sac_number' => 'required|numeric|is_unique[household_heads.sac_number]|max_length[6]',
		];
		if($this->request->getVar('cellphone_number')){
			$rules['cellphone_number'] = 'exact_length[11]';
		}
		$error_messages = [ 
			'trabaho' => [
				'required_if_not_empty' => 'trabaho is required if pinagtratrabahuhang lugar is stated.',
			],
			'pinagtratrabahuhang_lugar' => [
				'required_if_not_empty' => 'pinagtratrabahuhang lugar is required if trabaho is stated.',
			],
			'katutubo' => [
				'required_if_not_empty' => 'katutubo is required if katutubo name is stated.',
			],
			'katutubo_name' => [
				'required_if' => 'katutubo name is required if katutubo is checked.',
			],
			'bene_others' => [
				'required_if_not_empty' => 'others field is required if others name is stated.',
			],
			'others_name' => [
				'required_if' => 'katutubo name is required if bene_others is checked.',
			],
		];
		
		if($this->request->getVar('members')){
			$members = $this->request->getVar('members');
			foreach ($members as $key => $member) {
				$rules["members.$key.first_name"] = 'required|disallow_dash|allowed_string_name|max_length[100]';
				$rules["members.$key.middle_name"] = 'disallow_dash|allowed_string_name|max_length[100]';
				$rules["members.$key.last_name"] = 'required|disallow_dash|allowed_string_name|max_length[100]';
				$rules["members.$key.ext_name"] = 'disallow_dash|allowed_string_name|max_length[100]';
				$rules["members.$key.relasyon_sa_punong_pamilya"] = "required|valid_relasyon_age[$key]|allowed_string|max_length[100]";
				$rules["members.$key.kasarian"] = 'required|max_length[1]';
				$rules["members.$key.kapanganakan"] = 'required|valid_birthdate';
				$rules["members.$key.trabaho"] = 'required|allowed_string|max_length[200]';
				$rules["members.$key.pinagtratrabahuhang_lugar"] = 'allowed_string|max_length[200]';
				$rules["members.$key.sektor"] = "required|valid_nakakatanda[$key]|valid_ina[$key]|valid_ina_age[$key]|allowed_string|max_length[200]";
				$rules["members.$key.kondisyon_ng_kalusugan"] = 'required|allowed_string|max_length[200]';
			}
		}
		
		$this->validate($rules,$error_messages);
		$errors = $this->validator->getErrors();
		if($errors != array()){
			return $this->fail($errors, 422);
		}
		$kapanganakan = \DateTime::createFromFormat('m/d/Y', $this->request->getVar('kapanganakan'));
		$petsa_ng_pagrehistro = \DateTime::createFromFormat('m/d/Y', $this->request->getVar('petsa_ng_pagrehistro'));
		$data = [
			'first_name' => $this->request->getVar('first_name'),
			'middle_name' => $this->request->getVar('middle_name'),
			'last_name' => $this->request->getVar('last_name'),
			'ext_name' => $this->request->getVar('ext_name'),
			'kasarian' => $this->request->getVar('kasarian'),
			'tirahan' => $this->request->getVar('tirahan'),
			'kalye' => $this->request->getVar('kalye'),
			'uri_ng_id' => $this->request->getVar('uri_ng_id'),
			'numero_ng_id' => $this->request->getVar('numero_ng_id'),
			'kapanganakan' => $kapanganakan->format('Y-m-d'),
			'trabaho' => $this->request->getVar('trabaho'),
			'buwanang_kita' => $this->request->getVar('buwanang_kita'),
			'pinagtratrabahuhang_lugar' => $this->request->getVar('pinagtratrabahuhang_lugar'),
			'sektor' => $this->request->getVar('sektor'),
			'kondisyon_ng_kalusugan' => $this->request->getVar('kondisyon_ng_kalusugan'),
			'bene_uct' => $this->request->getVar('bene_uct'),
			'bene_4ps' => $this->request->getVar('bene_4ps'),
			'katutubo' => $this->request->getVar('katutubo'),
			'katutubo_name' => $this->request->getVar('katutubo_name'),
			'bene_others' => $this->request->getVar('bene_others'),
			'others_name' => $this->request->getVar('others_name'),
			'petsa_ng_pagrehistro' => $petsa_ng_pagrehistro->format('Y-m-d'),
			'pangalan_ng_punong_barangay' => $this->request->getVar('pangalan_ng_punong_barangay'),
			'pangalan_ng_lswdo' => $this->request->getVar('pangalan_ng_lswdo'),
			'sac_number' => $this->request->getVar('sac_number'),
		];
		$household_head = new HouseholdHead();
		$this->db->transStart();
		$household_head->save($data);
		$household_id = $household_head->insertID();
		if($this->request->getVar('members')){
			$members = $this->request->getVar('members');
			foreach ($members as $key => $member) {
				$kapanganakan = \DateTime::createFromFormat('m/d/Y', $member['kapanganakan']);
				$data = [
					'household_head_id' => $household_id,
					'first_name' => $member['first_name'],
					'middle_name' => $member['middle_name'],
					'last_name' => $member['last_name'],
					'ext_name' => $member['ext_name'],
					'relasyon_sa_punong_pamilya' => $member['relasyon_sa_punong_pamilya'],
					'kasarian' => $member['kasarian'],
					'kapanganakan' => $kapanganakan->format('Y-m-d'),
					'trabaho' => $member['trabaho'],
					'pinagtratrabahuhang_lugar' => $member['pinagtratrabahuhang_lugar'],
					'sektor' => $member['sektor'],
					'kondisyon_ng_kalusugan' => $member['kondisyon_ng_kalusugan'],
				];
				$household_members = new HouseholdMember();
				$household_members->save($data);
			}
		}
		$this->db->transComplete();
		$household_head = new HouseholdHead();
		return $this->respondCreated($household_head->find($household_id));
	}
	
	public function listBarangays()
	{
		$city_psgc = $this->request->uri->getSegment(4);
		$barangays = new Barangay();
		$barangay_query = $barangays->distinct();
		$barangay_query->select('barangay_name,barangay_psgc');
		$barangay_query->where('city_psgc', $city_psgc);
		$data = [
			'barangays' => $barangay_query->get()->getResult(),
		];
		return $this->respond($data, 200);
	}

	public function listProvinces()
	{
		$barangays = new Barangay();
		$barangays->distinct();
		$barangays->select('province_name,province_psgc');
		$data = [
			'provinces' => $barangays->get()->getResult(),
		];
		return $this->respond($data, 200);
	}

	public function listCities()
	{
		$province_psgc = $this->request->uri->getSegment(2);
		$barangays = new Barangay();
		$barangay_query = $barangays->distinct();
		$barangay_query->select('city_name,city_psgc');
		$barangay_query->where('province_psgc', $province_psgc);
		$data = [
			'cities' => $barangay_query->get()->getResult(),
		];
		return $this->respond($data, 200);
	}

	/* 
	Auth Code
	$hashed = password_hash('rasmuslerdorf', PASSWORD_DEFAULT);
	echo  $hashed;
	if (password_verify('rasmuslerdorf', $hashed)) {
		echo 'Password is valid!';
	} else {
		echo 'Invalid password.';
	}
	
	*/
	

}
