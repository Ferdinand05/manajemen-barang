<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

use function PHPSTORM_META\type;

class Barang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kode_brg' => [
                'type' => 'char',
                'constraint' => '10'
            ],
            'nama_brg' => [
                'type' => 'varchar',
                'constraint' => '100'
            ],
            'brg_katid' => [
                'type' => 'int',
                'unsigned' => true
            ],
            'brg_satid' => [
                'type' => 'int',
                'unsigned' => true
            ],
            'harga_brg' => [
                'type' => 'double',
            ],
            'gambar_brg' => [
                'type' => 'varchar',
                'constraint' => 200
            ]

        ]);

        $this->forge->addPrimaryKey('kode_brg');
        // foreign key , kategori
        $this->forge->addForeignKey('brg_katid', 'kategori', 'kat_id');
        // foreign key, satuan
        $this->forge->addForeignKey('brg_satid', 'satuan', 'sat_id');

        $this->forge->createTable('barang');
    }

    public function down()
    {
        $this->forge->dropTable('barang');
    }
}
