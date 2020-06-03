<?php namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\HouseholdHead;
use App\Models\HouseholdMember;
use App\Models\Barangay;
use App\Models\User;

class Home extends BaseController
{
	use ResponseTrait;
	private $db;
	private $session;
	function __construct() {
		$this->db      = \Config\Database::connect();
		$this->session = \Config\Services::session();
	}
	
	public function index()
	{
		if(!$this->session->user){
			return redirect()->to('/login');
		}
		return view('form_test');
	}

	public function login()
	{
		return view('form_test');
	}
	public function logout()
	{
		$this->session->remove('user');
	}

	public function createBeneficiary()
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
				$kapanganakan = \DateTime::createFromFormat('m/d/Y', $this->request->getVar("members[$key][kapanganakan]"));
				$data = [
					'household_head_id' => $household_id,
					'first_name' => $this->request->getVar("members[$key][first_name]"),
					'middle_name' => $this->request->getVar("members[$key][middle_name]"),
					'last_name' => $this->request->getVar("members[$key][last_name]"),
					'ext_name' => $this->request->getVar("members[$key][ext_name]"),
					'relasyon_sa_punong_pamilya' => $this->request->getVar("members[$key][relasyon_sa_punong_pamilya]"),
					'kasarian' => $this->request->getVar("members[$key][kasarian]"),
					'kapanganakan' => $kapanganakan->format('Y-m-d'),
					'trabaho' => $this->request->getVar("members[$key][trabaho]"),
					'pinagtratrabahuhang_lugar' => $this->request->getVar("members[$key][pinagtratrabahuhang_lugar]"),
					'sektor' => $this->request->getVar("members[$key][sektor]"),
					'kondisyon_ng_kalusugan' => $this->request->getVar("members[$key][kondisyon_ng_kalusugan]"),
				];
				$household_members = new HouseholdMember();
				$household_members->save($data);
			}
		}
		$this->db->transComplete();
		$household_head = new HouseholdHead();
		return $this->respondCreated($household_head->find($household_id));
	}

	public function listBeneficiaries()
	{
		$sac_number = $this->request->uri->getSegment(3);
		if($sac_number == null){
			$sac_number = $this->request->getVar('sac_number');
		}
		if($sac_number == null){
			return $this->fail("No records found.", 404);
		}
		$household_head_model = new HouseholdHead();
		$household_head_query = $household_head_model->where('sac_number',$sac_number);
		$household_head = $household_head_query->get()->getRow();

		$household_members_model = new HouseholdMember();
		$household_members_query = $household_members_model->where('household_head_id',$household_head->id);
		$household_members = $household_members_query->get()->getResult();
		$household_head->members = $household_members;
		
		return $this->respond($household_head);
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


	public function createUser()
	{
		$rules = [
            'username'  => 'required|allowed_string_name|min_length[6]|max_length[16]|is_unique[users.username]',
            'full_name' => 'required|allowed_string_name|min_length[6]|max_length[16]',
            'password'  => 'required|max_length[16]|min_length[6]',
            'role'  => 'required',
		];
		$this->validate($rules);
		$errors = $this->validator->getErrors();
		if($errors != array()){
			return $this->fail($errors, 422);
		}
		$user_model = new User();
		$data = [
			'username' => $this->request->getVar('username'),
			'full_name' => $this->request->getVar('full_name'),
			'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
			'role' => $this->request->getVar('role'),
		];
		$user_model->save($data);
	}

	public function loginUser()
	{
		$username = $this->request->getVar('username');
		$password = $this->request->getVar('password');
		$user_model = new User();
		$user_query = $user_model;
		$user_query->where('username',$username);
		if($user_query->first() != null){
			$user = $user_query->first();
			if(password_verify($password, $user->password)){
				unset($user->password);
				$this->session->set('user', $user);
				$data = [
					'status' => 'ok',
					'message' => 'Successfully logged in.',
				];
			}else{
				$data = [
					'status' => 'error',
					'message' => 'Invalid credentials.',
				];
			}
		}else{
			$data = [
				'status' => 'error',
				'message' => 'Invalid credentials.',
			];
		}
		return $this->respond($data, 200);
	}
}
