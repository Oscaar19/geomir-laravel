<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PlaceRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Log;


/**
 * Class PlaceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PlaceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        Log::debug("Entro al setup");
        CRUD::setModel(\App\Models\Place::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/place');
        CRUD::setEntityNameStrings('place', 'places');
        $this->crud->denyAccess(['update', 'create', 'delete']);
        Log::debug("Paso previo al if");
        if (!backpack_user()->hasPermissionTo('places.list')) {
            CRUD::denyAccess('list');
        }
        if (!backpack_user()->hasPermissionTo('places.create')) {
            CRUD::denyAccess('create');
        }
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('author_id')->label(__('fields.author_id'));
        CRUD::column('category_id')->label(__('fields.category_id'));
        CRUD::column('created_at')->label(__('fields.created_at'));
        CRUD::column('description')->label(__('fields.description'));
        CRUD::column('file_id')->label(__('fields.file_id'));
        CRUD::column('latitude')->label(__('fields.latitude'));
        CRUD::column('longitude')->label(__('fields.longitude'));
        CRUD::column('name')->label(__('fields.name'));
        CRUD::column('updated_at')->label(__('fields.updated_at'));
        CRUD::column('visibility_id')->label(__('fields.visibility_id'));

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PlaceRequest::class);

        CRUD::field('author_id');
        CRUD::field('category_id');
        CRUD::field('description');
        CRUD::field('file_id');
        CRUD::field('latitude');
        CRUD::field('longitude');
        CRUD::field('name');
        CRUD::field('visibility_id');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
