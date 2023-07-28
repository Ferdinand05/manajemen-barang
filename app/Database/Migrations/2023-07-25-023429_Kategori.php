<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

use function PHPSTORM_META\type;

class Kategori extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kat_id' => [
                'type' => 'int',
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'kat_nama' => [
                'type' => 'varchar',
                'constraint' => '50',
            ]
        ]);

        $this->forge->addPrimaryKey('kat_id');
        $this->forge->createTable('kategori');
    }

    public function down()
    {
        $this->forge->dropTable('kategori');
    }
}
