<?php
namespace App\Traits;

trait CheckUserPermissions
{
    public function hasPerm(String $permissionName = null)
    {
        $userPermissions = $this->getAllPermissions()->pluck('name');

        foreach($userPermissions as $arr_val){
            if($arr_val == $permissionName){
              return true;
            }
            if($arr_val == 'Super Admin'){
                return true;
            }
          }
          return false;
    }
}
