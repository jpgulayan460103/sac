<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBarangayTables extends Migration
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
			'barangay_name' => [
				'type'           => 'VARCHAR',
				'constraint'     => 200,
				'null'           => TRUE,
			],
			'barangay_psgc' => [
				'type'           => 'VARCHAR',
				'constraint'     => 200,
				'null'           => TRUE,
			],
			'province_name' => [
				'type'           => 'VARCHAR',
				'constraint'     => 200,
				'null'           => TRUE,
			],
			'province_psgc' => [
				'type'           => 'VARCHAR',
				'constraint'     => 200,
				'null'           => TRUE,
			],
			'city_name' => [
				'type'           => 'VARCHAR',
				'constraint'     => 200,
				'null'           => TRUE,
			],
			'city_psgc' => [
				'type'           => 'VARCHAR',
				'constraint'     => 200,
				'null'           => TRUE,
			],
			'district' => [
				'type'           => 'VARCHAR',
				'constraint'     => 200,
				'null'           => TRUE,
			],
			'subdistrict' => [
				'type'           => 'VARCHAR',
				'constraint'     => 200,
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
		$this->forge->createTable('barangays');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('barangays');
	}
}
