<?php
namespace App\Traits;

use PhpParser\Node\Expr\Cast\String_;

trait SecureDelete
{
public function secureDelete($relations, String $msg)
{
    $hasRelation = false;
    if(is_array($relations)){
        foreach ($relations as $relation){
            if ($this->$relation()->withTrashed()->count()){
                $hasRelation = true;
                break;
            }
        }
    }
    else {
        if ($this->$relations()->withTrashed()->count()){
            $hasRelation = true;
        }
    }


    if ($hasRelation){
        return response(['msg' => 'Erreur : '.$msg], 403);
    }else {
        $this->delete();
        // $this->forceDelete();
        return ['msg' => 'Element Supprimer !'];
    }
}

}

