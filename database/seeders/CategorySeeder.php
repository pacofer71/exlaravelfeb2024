<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias=[
            'Ocio'=>'#03a9f4',
            'Naturaleza'=>'#e040fb',
            'Politica'=>'#ffeb3b', 
            'Historia'=>'#BDBDBD',
            'Ficción'=>'#ff9800',
            'Medicina'=>'#cddc39'
        ];
        foreach($categorias as $nombre=>$color){
            Category::create(compact('nombre', 'color'));
        }
    }
}
