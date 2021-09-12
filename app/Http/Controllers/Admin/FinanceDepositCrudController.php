<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FinanceDepositRequest;
use App\Models\PaymentType;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class FinanceDepositCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FinanceDepositCrudController extends CrudController
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
        CRUD::setModel(\App\Models\FinanceDeposit::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/financedeposit');
        CRUD::setEntityNameStrings('financedeposit', 'finance_deposits');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $centre_id = session()->get('centre_id');
        $this->crud->addClause('where', 'centre_id', '=', $centre_id);
        $this->crud->enableBulkActions();
        $this->crud->denyAccess('delete');

            // Filters

    $this->crud->addFilter([
        'name'  => 'paymenttype',
        'type'  => 'dropdown',
        'label' => 'Payment Type'
      ], function () {
        return PaymentType::orderBy('short_name')->get()->pluck('short_name', 'id')->toArray();
      }, function ($value) {
        $this->crud->addClause('whereHas', 'paymenttype', function ($query) use ($value) {
          $query->where('payment_type_id', $value);
        });
      });

      $this->crud->addFilter([ // dropdown filter
        'name' => 'status',
        'type' => 'dropdown',
        'label' => 'Status',
      ], ['Deposited' => 'Deposited', 'Cleared' => 'Cleared'], function ($value) {
        $this->crud->addClause('where', 'status', $value);
      });

      $this->crud->addFilter(
        [ // daterange filter
            'type' => 'date_range',
            'name' => 'date_range',
            'label'=> 'Date range',
            // 'date_range_options' => [
            // 'format' => 'YYYY/MM/DD',
            // 'locale' => ['format' => 'YYYY/MM/DD'],
            // 'showDropdowns' => true,
            // 'showWeekNumbers' => true
            // ]
        ],
        false,
        function ($value) { // if the filter is active, apply these constraints
            $dates = json_decode($value);
            $this->crud->addClause('where', 'deposited_date', '>=', $dates->from);
            $this->crud->addClause('where', 'deposited_date', '<=', $dates->to);
        }
    );



        // columns

$this->crud->addColumn([
    'name' => 'deposited_date',
    'type' => 'date',
    'label' => 'Deposit Date',
    'format' => 'Y-MM-DD',
  ]);

  $this->crud->addColumn([
    'name' => 'amount',
    'label' => 'Amount',
    'type' => 'decimal,2',
]);

$this->crud->addColumn([
    'name' => 'paymentType',
    'type' => 'relationship',
    'key' => 'short_name',
    'attribute' => 'short_name',
    'label' => 'Payment Type',
  ]);

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
        CRUD::setValidation(FinanceDepositRequest::class);

        CRUD::setFromDb(); // fields

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
