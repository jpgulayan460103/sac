<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HouseholdMembers extends Migration
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
			'household_head_id' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => TRUE,
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
			'relasyon_sa_punong_pamilya' => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'null'           => TRUE,
			],
			'kasarian' => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
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
			'pinagtratrabahuhang_lugar' => [
				'type'           => 'VARCHAR',
				'constraint'     => 200,
				'default'        => '-',
			],
			'sektor' => [
				'type'           => 'VARCHAR',
				'constraint'     => 200,
				'default'        => 'W - Wala sa pagpipilian',
			],
			'kondisyon_ng_kalusugan' => [
				'type'           => 'VARCHAR',
				'constraint'     => 200,
				'default'        => '0 - Wala sa pagpipilian',
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
		$this->forge->addForeignKey('household_head_id','household_heads','id','CASCADE','CASCADE');
		$this->forge->createTable('household_members');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
