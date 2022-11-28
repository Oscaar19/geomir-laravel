<?php
 
namespace App\Http\Controllers\Admin;
 
use Backpack\PermissionManager\app\Http\Controllers\UserCrudController 
as PM_UserCrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
 
class UserCrudController extends PM_UserCrudController
{
   public function setup()
   {
        parent::setup();
        
   }

   public function setupListOperation()
   {
       parent::setupListOperation();
       $this->crud->removeColumn('permissions');
   }
}
