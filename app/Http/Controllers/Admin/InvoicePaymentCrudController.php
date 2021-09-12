<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\InvoicePaymentRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class InvoicePaymentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class InvoicePaymentCrudController extends CrudController
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
        CRUD::setModel(\App\Models\InvoicePayment::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/invoicepayment');
        CRUD::setEntityNameStrings('invoicepayment', 'invoice_payments');
    }

    protected function setupRefundDefaults()
    {

        $this->crud->allowAccess('refund');

        $this->crud->operation('list', function () {
            $this->crud->addButtonFromView('line', 'refund', 'refund', 'beginning');
        });
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // $this->crud->enableBulkActions();

        CRUD::column('receipt_number');

        $this->crud->addColumn([
            'name' => 'invoice_id',
            'type' => 'relationship',
            'key' => 'invoice',
            'attribute' => 'invoice_number',
            'label' => 'Invoice',
        ]);        

        $this->crud->addColumn([
            'name' => 'student',
            'label' => 'Student',
            'attribute' => 'display_name',
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('student', function ($q1) use ($column, $searchTerm) {
                    $q1->where('first_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('middle_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('last_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('common_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('guardian1_display', 'like', '%' . $searchTerm . '%')
                        ->orWhere('guardian2_display', 'like', '%' . $searchTerm . '%')
                        ->orWhereHas('scheduleClassers', function ($q2) use ($column, $searchTerm) {
                            $q2->whereHas('classer', function ($q3) use ($column, $searchTerm) {
                                $q3->where('short_name', 'like', '%' . $searchTerm . '%');
                            });
                        });
                });
            },
            'visibleInTable'  => false,
        ]);

        $this->crud->addColumn([
            'name' => 'payment_date',
            'label' => 'Date',
            'type' => 'date',
            'format' => 'Y-MM-DD',
        ]);

        CRUD::column('amount');

$this->crud->addColumn([
    'name' => 'payment_type_id',
//    'type' => 'relationship',
    'attribute' => 'short_name',
]);  
        CRUD::column('cleared');
        CRUD::column('cleared_date');
        CRUD::column('status');

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
        CRUD::setValidation(InvoicePaymentRequest::class);

        CRUD::field('invoice_id');
        CRUD::field('student_id');
        CRUD::field('centre_id');
        CRUD::field('receipt_number');
        CRUD::field('amount');
        CRUD::field('payment_type_id');
        CRUD::field('private_note');
        CRUD::field('syear');
        CRUD::field('public_note');
        CRUD::field('cheuque_number');
        CRUD::field('bank_name');
        CRUD::field('cleared');
        CRUD::field('cleared_date');
        CRUD::field('user_id');
        CRUD::field('status');
        CRUD::field('source');

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
