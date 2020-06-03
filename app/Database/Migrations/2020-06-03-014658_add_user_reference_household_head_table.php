<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserReferenceHouseholdHeadTable extends Migration
{
	public function up()
	{
		$fields = [
			'users_id' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => TRUE,
			],
		];
		$this->forge->addColumn('household_heads', $fields);
		$db = \Config\Database::connect();
		$db->query('ALTER TABLE `household_heads` ADD CONSTRAINT `household_heads_user_id` FOREIGN KEY (`users_id`) REFERENCES `users`(`id`) ON DELETE SET NULL ON UPDATE SET NULL;');
	}
	
	//--------------------------------------------------------------------
	
	public function down()
	{
		$db = \Config\Database::connect();
		$db->query('ALTER TABLE household_heads DROP FOREIGN KEY household_heads_user_id;');
		$this->forge->dropColumn('household_heads', 'users_id');
		//
	}
}
