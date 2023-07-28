<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Satuan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'sat_id' => [
                'type' => 'int',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'sat_nama' => [
                'type' => 'varchar',
                'constraint' => '50',
            ]
        ]);

        $this->forge->addPrimaryKey('sat_id');
        $this->forge->createTable('satuan');
    }

    public function down()
    {
        $this->forge->dropTable('satuan');
    }
}
