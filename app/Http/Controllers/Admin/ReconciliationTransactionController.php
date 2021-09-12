<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinanceDeposit;
use App\Models\FinanceReconciliation;
use App\Models\InvoicePayment;
use App\Repositories\Reconciliation\ReconciliationInterface;
use Illuminate\Http\Request;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class ReconciliationTransactionController extends Controller
{

    /**
     * @var ReconciliationInterface
     */
    private $reconciliation;

    public function __construct(ReconciliationInterface $reconciliation)
    {
        $this->reconciliation = $reconciliation;
    }

    public function index(Request $request)
    {

//        $payment_types = $this->reconciliation->paymentTypes();

/*        if (count($request->all()) > 0) {

           $data = $this->reconciliation->index($request);

            return view('reconciliations/index', [
                'data' => $data,
                'payments' => $payment_types
            ]);
        }
*/
        $data = $this->reconciliation->index($request);

        return view('reconciliations/index', [
            'data' => $data,
//           'payments' => $payment_types
        ]);
  
  
    }

    public function store(Request $request)
    {
        //To check if the record already reconciled
        $depositIds = $request['deposit_id'];
        foreach ($depositIds as $depositId) {
           if (FinanceReconciliation::where(['link_id' => $depositId])->exists()) {
              return "One or more item already reconciled";
           }
        }

        //The date validation
        foreach ($depositIds as $depositId) {
//            dd($depositId);
            $finance_deposit = FinanceDeposit::firstWhere(['id' => $depositId]);
            if ($finance_deposit->deposited_date > $request['date']) {
                return "Reconciliation date must be after the deposited date";
            }
        }

        $this->reconciliation->store($request);

        return "You have successfully reconciled";
    }

    public function storeVoid(Request $request)
    {
        $depositIds = $request['deposit_id'];

        //check for reconciled earlier
        foreach ($depositIds as $depositId) {
        $finance_reconciliation_record = FinanceReconciliation::firstWhere(['link_id' => $depositId, 'link_key' => 'deposit_id']);
            if ($finance_reconciliation_record === null) {
                return "One or more item never reconciled or already voided";
            }
        }

        //date validation
        foreach ($depositIds as $depositId) {
            $finance_reconciliation = FinanceReconciliation::firstWhere(['link_key' => 'deposit_id', 'link_id' => $depositId]);
            if ($finance_reconciliation->cleared_date > $request['date']) {
                return "Voided date must be greater than reconciled date";
            }
        }


       $this->reconciliation->storeVoid($request);

        return "Reconciliation voided successfully";
    }
}
