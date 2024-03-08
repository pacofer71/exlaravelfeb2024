<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articulos=Article::factory(80)->create();
        foreach($articulos as $article){
            $article->usersLike()->attach(self::getArrayLikes());
        }
    }
    private static function getArrayLikes():array {
        $likes=[];
        $usersId=User::pluck('id')->toArray();
        $indices=array_rand($usersId, random_int(1, count($usersId)));
        
        if(!is_array($indices)){
            return [$usersId[$indices]];
        }

        foreach($indices as $indice){
            $likes[]=$usersId[$indice];
        }

        return $likes;
    }
}
