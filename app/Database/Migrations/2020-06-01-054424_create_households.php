<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHouseholds extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => TRUE,
				'auto_increment' => TRUE,
			],
			'barangay_psgc' => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'null'           => TRUE,
			],
			'first_name' => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'null'           => TRUE,
			],
			'middle_name' => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'null'           => TRUE,
			],
			'last_name' => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'null'           => TRUE,
			],
			'ext_name' => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'null'           => TRUE,
			],
			'kasarian' => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'null'           => TRUE,
			],
			'tirahan' => [
				'type'           => 'VARCHAR',
				'constraint'     => 200,
				'null'           => TRUE,
				'default'        => '-',
			],
			'kalye' => [
				'type'           => 'VARCHAR',
				'constraint'     => 200,
				'null'           => TRUE,
				'default'        => '-',
			],
			'uri_ng_id' => [
				'type'           => 'VARCHAR',
				'constraint'     => 200,
				'null'           => TRUE,
				'default'        => '-',
			],
			'numero_ng_id' => [
				'type'           => 'VARCHAR',
				'constraint'     => 200,
				'null'           => TRUE,
				'default'        => '-',
			],
			'kapanganakan' => [
				'type'           => 'DATE',
				'null'           => TRUE,
			],
			'trabaho' => [
				'type'           => 'VARCHAR',
				'constraint'     => 200,
				'null'           => TRUE,
				'default'        => '-',
			],
			'buwanang_kita' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'null'           => TRUE,
				'default'        => 0,
			],
			'cellphone_number' => [
				'type'           => 'VARCHAR',
				'constraint'     => 11,
				'null'           => TRUE,
				'default'        => '-',
			],
			'pinagtratrabahuhang_lugar' => [
				'type'           => 'VARCHAR',
				'constraint'     => 200,
				'null'           => TRUE,
				'default'        => '-',
			],
			'sektor' => [
				'type'           => 'VARCHAR',
				'constraint'     => 200,
				'null'           => TRUE,
				'default'        => 'W - Wala sa pagpipilian',
			],
			'kondisyon_ng_kalusugan' => [
				'type'           => 'VARCHAR',
				'constraint'     => 200,
				'null'           => TRUE,
				'default'        => '0 - Wala sa pagpipilian',
			],
			'bene_uct' => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'null'           => TRUE,
				'default'        => 'N',
			],
			'bene_4ps' => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'null'           => TRUE,
				'default'        => 'N',
			],
			'katutubo' => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'null'           => TRUE,
				'default'        => 'N',
			],
			'katutubo_name' => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'null'           => TRUE,
				'default'        => '-',
			],
			'bene_others' => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'null'           => TRUE,
				'default'        => 'N',
			],
			'others_name' => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'null'           => TRUE,
				'default'        => '-',
			],
			'petsa_ng_pagrehistro' => [
				'type'           => 'DATE',
				'null'           => TRUE,
			],
			'pangalan_ng_punong_barangay' => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'null'           => TRUE,
				'default'        => '-',
			],
			'pangalan_ng_lswdo' => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'null'           => TRUE,
				'default'        => '-',
			],
			'sac_number' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'null'           => TRUE,
			],
			'created_at' => [
				'type'           => 'TIMESTAMP',
				'null'           => TRUE,
			],
			'updated_at' => [
				'type'           => 'TIMESTAMP',
				'null'           => TRUE,
			],
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->addKey('barangay_psgc');
		$this->forge->createTable('household_heads');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('household_heads');
	}
}
