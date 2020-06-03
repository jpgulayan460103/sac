<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
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
			'username' => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'null'           => TRUE,
			],
			'password' => [
				'type'           => 'VARCHAR',
				'constraint'     => 200,
				'null'           => TRUE,
			],
			'full_name' => [
				'type'           => 'VARCHAR',
				'constraint'     => 200,
				'null'           => TRUE,
			],
			'role' => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
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
		$this->forge->createTable('users');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('users');
	}
}
