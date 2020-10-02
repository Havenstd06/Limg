<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CrudImageRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;

/**
 * Class ImageCrudController.
 * @property-read CrudPanel $crud
 */
class ImageCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\CrudImage');
        $this->crud->setRoute(config('backpack.base.route_prefix').'/crud-image');
        $this->crud->setEntityNameStrings('crud-image', 'crud-images');

        $this->crud->addColumn([
            'name'      => 'path', // The db column name
            'label'     => 'Image', // Table column heading
            'type'      => 'image',
            'height'    => '100px',
            'width'     => '100px',
        ]);

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
        $this->crud->setValidation(CrudImageRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
