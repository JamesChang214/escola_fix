<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StudentRequest;
use App\Libraries\Classer\ClasserAbstract;
use App\Libraries\Finance\InvoicesAbstract;
use App\Models\Classer;
use App\Models\Grade;
use App\Models\Invoice;
use App\Models\InvoiceFeeType;
use App\Models\InvoiceItem;
use App\Models\ScheduleClasser;
use App\Models\Student;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;

/**
 * Class StudentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StudentCrudController extends CrudController
{
  use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
  //  use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
  use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
    update as traitUpdate;
  }
  use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
  use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
  use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
    store as traitStore;
  }

  /**
   * Configure the CrudPanel object. Apply settings to all operations.
   * 
   * @return void
   */
  public function setup()
  {
    CRUD::setModel(\App\Models\Student::class);
    CRUD::setRoute(config('backpack.base.route_prefix') . '/student');
    CRUD::setEntityNameStrings('student', 'students');
  }

  protected function setupBulkAddClassDefaults()
  {
    $this->crud->allowAccess('bulkAddClass');

    $this->crud->operation('list', function () {
      $this->crud->addButtonFromView('bottom', 'bulk_add_to_class', 'bulk_add_to_class', 'beginning');
    });
  }

  protected function setupBulkStudentsInvoiceDefaults()
  {
    $this->crud->allowAccess('bulkStudentsInvoice');

    $this->crud->operation('list', function () {
      $this->crud->addButtonFromView('bottom', 'bulk_students_invoice', 'bulk_students_invoice', 'end');
    });
  }


  /*
        |--------------------------------------------------------------------------
        | LIST OPERATION
        |--------------------------------------------------------------------------
        */

  protected function setupListOperation()
  {
    // added by CPR for switching centres
    $centre_id = session()->get('centre_id');
    $this->crud->addClause('where', 'centre_id', '=', $centre_id);
    // added by CPR for switching centres
    $this->crud->enableBulkActions();
    $this->crud->denyAccess('delete');
    $this->crud->enableDetailsRow();

    //Display name according to name format
    $this->crud->addColumn([
      'name' => 'display_name',
      'label' => 'Student',
      'searchLogic' => function ($query, $column, $searchTerm) {
        $query->orWhere('first_name', 'like', '%' . $searchTerm . '%');
        $query->orWhere('last_name', 'like', '%' . $searchTerm . '%');
        $query->orWhere('common_name', 'like', '%' . $searchTerm . '%');
      }
    ]);

    $this->crud->addColumn([
      'name' => 'school_id',
      'label' => 'School',
      'type' => 'relationship',
      'key' => 'school',
      'attribute' => 'short_name',
      'searchLogic' => function ($query, $column, $searchTerm) {
        $query->orWhereHas('school', function ($q) use ($column, $searchTerm) {
          $q->where('short_name', 'like', '%' . $searchTerm . '%')
            ->orWhere('name', 'like', '%' . $searchTerm . '%');
        });
      },
      'visibleInTable'  => false,
    ]);

    $this->crud->addColumn([
      'name' => 'scheduleClassers',
      'label' => 'Schedule Classers',
      'type' => 'relationship',
      'key' => 'scheduleClassers',
      'attribute' => 'short_name',
      'searchLogic' => function ($query1, $column, $searchTerm) {
        $query1->orWhereHas('scheduleClassers', function ($query2) use ($searchTerm) {
          $query2->whereHas('classer', function ($q) use ($searchTerm) {
            $q->where('short_name', 'like', '%' . $searchTerm . '%');
          });
        });
      },
      'visibleInTable'  => false,
    ]);

    $this->crud->addColumn([
      'name' => 'phone',
      'label' => 'Phone',
      'searchLogic' => 'text',
      'visibleInTable'  => false,
    ]);

    $this->crud->addColumn([
      'name' => 'email',
      'label' => 'Email',
      'searchLogic' => 'text',
      'visibleInTable'  => false,
    ]);

    $this->crud->addColumn([
      'name' => 'guardian1_display',
      'label' => 'Guardian 1 Display',
      'searchLogic' => 'text',
      'visibleInTable'  => false,
    ]);

    $this->crud->addColumn([
      'name' => 'guardian1_phone',
      'label' => 'Guardian 1 Phone',
      'searchLogic' => 'text',
      'visibleInTable'  => false,
    ]);

    $this->crud->addColumn([
      'name' => 'guardian1_email',
      'label' => 'Guardian 1 Email',
      'searchLogic' => 'text',
      'visibleInTable'  => false,
    ]);

    $this->crud->addColumn([
      'name' => 'guardian2_display',
      'label' => 'Guardian 2 Display',
      'searchLogic' => 'text',
      'visibleInTable'  => false,
    ]);

    $this->crud->addColumn([
      'name' => 'guardian2_phone',
      'label' => 'Guardian 2 Phone',
      'searchLogic' => 'text',
      'visibleInTable'  => false,
    ]);

    $this->crud->addColumn([
      'name' => 'guardian2_email',
      'label' => 'Guardian 2 Email',
      'searchLogic' => 'text',
      'visibleInTable'  => false,
    ]);

    /* Dedicated search columns end */

    $this->crud->addColumn([
      'name' => 'dob',
      'label' => 'DOB',
      'type' => 'date',
      'format' => 'Y-MM-DD',
    ]);

    CRUD::column('phone');

    $this->crud->addColumn([
      'name' => 'enrollment_date',
      'label' => 'Enrollment',
      'type' => 'date',
      'format' => 'Y-MM-DD',
    ]);

    $this->crud->addColumn([
      'name' => 'grade_id',
      'type' => 'relationship',
      'key' => 'short_name',
      'attribute' => 'short_name',
      'label' => 'Level',
    ]);

    $this->crud->addColumn([
      'name' => 'enrollment_date',
      'label' => 'Enrollment',
      'type' => 'date',
      'format' => 'Y-MM-DD',
    ]);

    $this->crud->addColumn([
      'label' => 'Class',
      'type'  => 'model_function',
      'function_name' => 'getClass',
      'wrapper'   => [
        'data-toggle' => 'tooltip',
        'class' => function ($crud, $column, $entry, $related_key) {
          if ($entry->scheduleClassers->count() > 1) {
            return 'text-primary';
          }
        },
        'title' => function ($crud, $column, $entry, $related_key) {
          $classers = "";
          foreach ($entry->scheduleClassersForDetailsRow as $key => $classer) {
            $classers .= ($key == 0 ? '' : ',   ') . $classer->classer->short_name;
          }
          return $classers;
        },
      ],
    ]);

    $this->addCustomCrudFilters();

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
    CRUD::setValidation(StudentRequest::class);

    //$this->crud->addFields(static::getFieldsArrayForRequiredTab());
    //$this->crud->addFields(static::getFieldsArrayForAddressTab());

    $this->crud->addField([
      'name' => 'first_name',
      'type' => 'text',
      'label' => "Given Name",
      'tab' => "Required",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'avatar',
      'type' => 'text',
      'label' => "Avatar",
      'tab' => "Required",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'last_name',
      'type' => 'text',
      'label' => "Family Name",
      'tab' => "Required",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'last_name',
      'type' => 'text',
      'label' => "Family Name",
      'tab' => "Required",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'middle_name',
      'type' => 'text',
      'label' => "Middle Name",
      'tab' => "Required",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'common_name',
      'type' => 'text',
      'label' => "Common Name",
      'tab' => "Required",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'name_format',
      'type' => 'select_from_array',
      'label' => "Name Format",
      'tab' => "Required",
      'options'     => ['Western' => 'Western', 'Chinese' => 'Chinese'],
      'allows_null' => false,
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);


    $this->crud->addField([
      'name' => 'gender',
      'type' => 'select_from_array',
      'label' => "Gender",
      'tab' => "Required",
      'options'     => ['Male' => 'Male', 'Female' => 'Female'],
      'allows_null' => false,
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'identification',
      'type' => 'text',
      'label' => "Identification",
      'tab' => "Required",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'ethnicity',
      'type' => 'select_from_array',
      'label' => "Ethnicity",
      'tab' => "Required",
      'options'     => ['Chinese' => 'Chinese', 'Malay' => 'Malay', 'Indian' => 'Indian', 'Caucasian' => 'Caucasian', 'Eurasian' => 'Eurasian', 'other' => 'Other'],
      'allows_null' => false,
      'default' => 'Chinese',
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'language',
      'type' => 'select_from_array',
      'label' => "Language",
      'tab' => "Required",
      'options'     => ['English' => 'English', 'Chinese' => 'Chinese', 'Bahasa' => 'Bahasa', 'Tamal' => 'Tamal'],
      'allows_null' => false,
      'default' => 'English',
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'dob',
      'type' => 'date',
      'label' => "Date of Birth",
      'tab' => "Required",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'source',
      'type' => 'text',
      'label' => "Source",
      'tab' => "Required",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'grade_id',
      'type' => 'select2',
      'label' => 'Level',
      'tab' => 'Required',
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'school_id',
      'type' => 'select',
      'label' => "School ID",
      'tab' => "Required",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $dt = Carbon::today();
    $this->crud->addField([
      'name' => 'enrollment_date',
      'type' => 'date',
      'label' => "Enrollment Date",
      'default' => $dt,
      'tab' => "Required",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'status',
      'type' => 'select_from_array',
      'label' => "Status",
      'tab' => "Required",
      'default' => 'Active',
      'options'     => ['Active' => 'Active', 'Workshop' => 'Workshop', 'Withdrawn' => 'Withdrawn'],
      'allows_null' => false,
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'centre_id',
      'type' => 'hidden',
      'label' => "Centre",
      'tab' => "Required",
      // added by CPR for switching centres
      'default' => session()->get('centre_id'),
      'readonly'    => 'readonly',
      // 'disabled'    => 'disabled',
      // added by CPR for switching centres      
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    //Address Tab items
    //CRUD::field('address1');
    //CRUD::field('address2');
    //CRUD::field('address3');
    //CRUD::field('address4');
    //CRUD::field('city');
    //CRUD::field('state');
    //CRUD::field('country');
    //CRUD::field('postal_code');
    //CRUD::field('area_code');
    //CRUD::field('phone');
    //CRUD::field('email');

    $this->crud->addField([
      'name' => 'address1',
      'type' => 'text',
      'label' => "Street & Number",
      'tab' => "Address",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'address2',
      'type' => 'text',
      'label' => "Unit",
      'tab' => "Address",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'address3',
      'type' => 'text',
      'label' => "Building",
      'tab' => "Address",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'address4',
      'type' => 'text',
      'label' => "Additional",
      'tab' => "Address",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'city',
      'type' => 'text',
      'label' => "City",
      'tab' => "Address",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'state',
      'type' => 'text',
      'label' => "State",
      'tab' => "Address",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'country',
      'type' => 'text',
      'label' => "Country",
      'tab' => "Address",
      'default' => 'Singapore',
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'postal_code',
      'type' => 'text',
      'label' => "Postal Code",
      'tab' => "Address",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'phone',
      'type' => 'text',
      'label' => "Phone",
      'tab' => "Address",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'email',
      'type' => 'text',
      'label' => "Email",
      'tab' => "Address",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    // Parent / Guardian fields

    //Custom HTML
    $this->crud->addField([
      'name'  => 'primary_parent_heading',
      'type'  => 'custom_html',
      'value' => '<h5 class="mb-0 mt-3 text-primary">Primary Parent/Guardian</h5>',
      'tab'   => 'Parent/Guardian',
    ]);

    $this->crud->addField([
      'name' => 'guardian1_first',
      'type' => 'text',
      'label' => "Given Name",
      'tab' => "Parent/Guardian",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'guardian1_last',
      'type' => 'text',
      'label' => "Family Name",
      'tab' => "Parent/Guardian",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'guardian1_common',
      'type' => 'text',
      'label' => "Common Name",
      'tab' => "Parent/Guardian",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'guardian1_format',
      'type' => 'select_from_array',
      'label' => "Name Format",
      'tab' => "Parent/Guardian",
      'options'     => ['Western' => 'Western', 'Chinese' => 'Chinese'],
      'allows_null' => false,
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'guardian1_phone',
      'type' => 'text',
      'label' => "Phone",
      'tab' => "Parent/Guardian",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'guardian1_email',
      'type' => 'text',
      'label' => "email",
      'tab' => "Parent/Guardian",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name'  => 'secondary_parent_details',
      'type'  => 'custom_html',
      'value' => '<h5 class="mb-0 mt-3 text-primary">Secondary Parent/Guardian</h5>',
      'tab'   => 'Parent/Guardian',
    ]);

    $this->crud->addField([
      'name' => 'guardian2_first',
      'type' => 'text',
      'label' => "Given Name",
      'tab' => "Parent/Guardian",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'guardian2_last',
      'type' => 'text',
      'label' => "Family Name",
      'tab' => "Parent/Guardian",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'guardian2_common',
      'type' => 'text',
      'label' => "Common Name",
      'tab' => "Parent/Guardian",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'guardian2_format',
      'type' => 'select_from_array',
      'label' => "Name Format",
      'tab' => "Parent/Guardian",
      'options'     => ['Western' => 'Western', 'Chinese' => 'Chinese'],
      'allows_null' => false,
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'guardian2_phone',
      'type' => 'text',
      'label' => "Phone",
      'tab' => "Parent/Guardian",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

    $this->crud->addField([
      'name' => 'guardian2_email',
      'type' => 'text',
      'label' => "email",
      'tab' => "Parent/Guardian",
      'attributes' => [
        'placeholder' => 'Some text when empty',
        'class'       => 'form-control some-class',
      ], // change the HTML attributes of your input
      'wrapper'   => [
        'class'      => 'form-group col-md-6'
      ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
    ]);

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

  //Beging 

  public static function getFieldsArrayForRequiredTab()
  {
    return [];
  }

  public function addToClass()
  {
    $this->crud->hasAccessOrFail('update');
    $class = new ClasserAbstract();

    return $class->addToClass($this->crud->getRequest()->input('students'), $this->crud->getRequest()->input('classes'));
  }

  public function bulkStudentsInvoice()
  {
    $studentsIds = $this->crud->getRequest()->input('students');
    $selected_fees = $this->crud->getRequest()->input('selected_fees');
    $total = $this->crud->getRequest()->input('total');
    $total_discount = $this->crud->getRequest()->input('total_discount');
    $instruction1 = $this->crud->getRequest()->input('instruction1');
    $instruction2 = $this->crud->getRequest()->input('instruction2');
    $due_date = $this->crud->getRequest()->input('due_date');
    $issue_date = $this->crud->getRequest()->input('issue_date');

    $invoice = new InvoicesAbstract();
    return $invoice->bulkStudentsInvoice($studentsIds, $selected_fees, $total, $total_discount, $instruction1, $instruction2, $due_date, $issue_date);
  }


  protected function setupBulkRoutes($segment, $routeName, $controller)
  {
    \Route::post($segment . '/add/to/class', [
      'as'        => $routeName . '.addToClass',
      'uses'      => $controller . '@addToClass',
      'operation' => 'addToClass',
    ]);

    \Route::post($segment . '/students/invoice', [
      'as'        => $routeName . '.bulkStudentsInvoice',
      'uses'      => $controller . '@bulkStudentsInvoice',
      'operation' => 'bulkStudentsInvoice',
    ]);
  }


  protected function addCustomCrudFilters()
  {

    $this->crud->addFilter([
      'name' => 'sc',
      'type'  => 'select2_multiple',
      'label' => 'Classers'
    ], function () {
      return Classer::orderBy('short_name')->get()->keyBy('id')->pluck('short_name', 'id')->toArray();
    }, function ($values) {
      $this->crud->addClause('whereHas', 'scheduleClassers', function ($query) use ($values) {
        $query->whereIn('classer_id', json_decode($values));
      });
    });

    $this->crud->addFilter([ // dropdown filter
      'name' => 'grade_id',
      'type' => 'select2_multiple',
      'label' => 'Level',
    ], function () {
      return Grade::orderBy('short_name')->get()->keyBy('id')->pluck('short_name', 'id')->toArray();
    }, function ($values) {
      $this->crud->addClause('whereIn', 'grade_id', json_decode($values));
    });

    $this->crud->addFilter([ // dropdown filter
      'name' => 'status',
      'type' => 'dropdown',
      'label' => 'Status',
    ], ['Active' => 'Active', 'Workshop' => 'Workshop','Withdrawn' => 'Withdrawn'], function ($value) {
      $this->crud->addClause('where', 'status', $value);
    });
  }

  public function store()
  {

    $this->crud->setOperationSetting('saveAllInputsExcept', ['save_action']);

// student display name
    if (strtoupper($this->crud->getRequest()->input('name_format')) == "WESTERN") {
      if ($this->crud->getRequest()->input('common_name') == '') {
        $displayName = $this->crud->getRequest()->input('first_name') . ' ' . $this->crud->getRequest()->input('last_name');
      } else {
        $displayName = $this->crud->getRequest()->input('common_name') . ' ' . $this->crud->getRequest()->input('last_name');
      }
    } else {
      $displayName = $this->crud->getRequest()->input('last_name') . ' ' . $this->crud->getRequest()->input('first_name');
    }

//guardian 1 display name
    if (strtoupper($this->crud->getRequest()->input('guardian1_format')) == "WESTERN") {
      $displayGuardian1Name = $this->crud->getRequest()->input('guardian1_first') . ' ' . $this->crud->getRequest()->input('guardian1_last');
    } else {
      $displayGuardian1Name = $this->crud->getRequest()->input('guardian1_last') . ' ' . $this->crud->getRequest()->input('guardian1_first');
    }

//guardian 2 display name
    if (strtoupper($this->crud->getRequest()->input('guardian2_format')) == "WESTERN") {
      $displayGuardian2Name = $this->crud->getRequest()->input('guardian2_first') . ' ' . $this->crud->getRequest()->input('guardian2_last');
    } else {
      $displayGuardian2Name = $this->crud->getRequest()->input('guardian2_last') . ' ' . $this->crud->getRequest()->input('guardian2_first');
    }

    $this->crud->getRequest()->request->add(['display_name' => $displayName]);
    $this->crud->getRequest()->request->add(['guardian1_display' => $displayGuardian1Name]);
    $this->crud->getRequest()->request->add(['guardian1_display' => $displayGuardian2Name]);
    
    return $this->traitStore();
  }

  public function update()
  {

    $this->crud->setOperationSetting('saveAllInputsExcept', ['save_action']);

// student display name
    if (strtoupper($this->crud->getRequest()->input('name_format')) == "WESTERN") {
      $displayName = $this->crud->getRequest()->input('first_name') . ' ' . $this->crud->getRequest()->input('last_name');
    } else {
      $displayName = $this->crud->getRequest()->input('last_name') . ' ' . $this->crud->getRequest()->input('first_name');
    }

    if (strtoupper($this->crud->getRequest()->input('name_format')) == "WESTERN") 
    {
      if ($this->crud->getRequest()->input('common_name') == '') 
        {
          $displayName = $this->crud->getRequest()->input('first_name') . ' ' . $this->crud->getRequest()->input('last_name');
        } 
      else 
        {
        $displayName = $this->crud->getRequest()->input('common_name') . ' ' . $this->crud->getRequest()->input('last_name');
        }
    }
    else
    {
      $displayName = $this->crud->getRequest()->input('last_name') . ' ' . $this->crud->getRequest()->input('first_name');
    }

    //guardian 1 display name
    if (strtoupper($this->crud->getRequest()->input('guardian1_format')) == "WESTERN") 
    {
      if ($this->crud->getRequest()->input('guardian1_common') == '') 
        {
          $displayGuardian1Name = $this->crud->getRequest()->input('guardian1_first') . ' ' . $this->crud->getRequest()->input('guardian1_last');
        } 
      else 
        {
        $displayGuardian1Name = $this->crud->getRequest()->input('guardian1_common') . ' ' . $this->crud->getRequest()->input('guardian1_last');
        }
    }
    else
    {
      $displayGuardian1Name = $this->crud->getRequest()->input('guardian1_last') . ' ' . $this->crud->getRequest()->input('guardian1_first');
    }

    //guardian 2 display name
    if (strtoupper($this->crud->getRequest()->input('guardian2_format')) == "WESTERN") 
    {
      if ($this->crud->getRequest()->input('guardian2_common') == '') 
        {
          $displayGuardian2Name = $this->crud->getRequest()->input('guardian2_first') . ' ' . $this->crud->getRequest()->input('guardian2_last');
        } 
      else 
        {
        $displayGuardian2Name = $this->crud->getRequest()->input('guardian2_common') . ' ' . $this->crud->getRequest()->input('guardian2_last');
        }
    }
    else
    {
      $displayGuardian2Name = $this->crud->getRequest()->input('guardian2_last') . ' ' . $this->crud->getRequest()->input('guardian2_first');
    }

    $this->crud->getRequest()->request->add(['display_name' => $displayName]);
    $this->crud->getRequest()->request->add(['guardian1_display' => $displayGuardian1Name]);
    $this->crud->getRequest()->request->add(['guardian2_display' => $displayGuardian2Name]);

return $this->traitUpdate();
  }
}
