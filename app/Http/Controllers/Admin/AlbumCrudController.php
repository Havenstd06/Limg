<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CrudAlbumRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;

/**
 * Class CrudAlbumCrudController.
 * @property-read CrudPanel $crud
 */
class AlbumCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\CrudAlbum');
        $this->crud->setRoute(config('backpack.base.route_prefix').'/crud-album');
        $this->crud->setEntityNameStrings('crud-album', 'crud-albums');

        $this->crud->addColumn([
            'label'     => 'Username', // Table column heading
            'type'      => 'select',
            'name'      => 'user_id', // the column that contains the ID of that connected entity;
            'entity'    => 'user', // the method that defines the relationship in your Model
            'attribute' => 'username', // foreign key attribute that is shown to user
        ]);
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(CrudAlbumRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
