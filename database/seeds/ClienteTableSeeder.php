<?php

use Illuminate\Database\Seeder;

use App\Cliente;

class ClienteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Cliente::create([
            'nome' => 'Zezinha Cheirosa',
            'cpf'=>'12345678912',
            'email'=>'zezinha@cheirosa.com',
            'cep'=>'7700000',
            'endereco'=>'No lugar de sempre onde judas perdeu as botas',
            'telefone'=>'12345678',
            'cidade'=>'12345678',
            'id_estado'=>'1',
            'senha'=>'123456',
            
        ]);

        

    }
}
