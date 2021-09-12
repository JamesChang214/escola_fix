<?php

namespace App\Repositories\Reconciliation;

use App\Models\FinanceDeposit;
use App\Models\FinanceReconciliation;
use App\Models\FinanceVoid;
use App\Models\InvoicePayment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReconciliationAbstract implements ReconciliationInterface
{
    public function index($request)
    {
        $results = DB::table('finance_deposits as fd')
            ->leftJoin('invoice_payments as ip', 'fd.link_id', '=', 'ip.id')
            ->leftJoin('students as st', 'ip.student_id', '=', 'st.id')
            ->leftJoin('payment_types as pt', 'fd.payment_type_id', '=', 'pt.id')
            ->leftJoin('finance_reconciliations as fr','fd.id','=','fr.link_id')
            ->leftJoin('users as users', 'fr.user_id', '=', 'users.id')
            ->select('ip.id as ip_id', 'ip.student_id', 'ip.receipt_number', 'ip.payment_type_id', 'ip.cheuque_number as cheque',
            'ip.bank_name as bank','fr.cleared_date', 'ip.user_id', 'fd.created_at', 'st.display_name', 'pt.name as payment',
                'fd.deposited_date as deposit_date', 'fd.amount as amount','fd.id as fd_id', 'fd.status as status', 'users.name as name');

        if (isset($request['filterfdstatus'])) {
            $results = $results->where('fd.status', '=', $request['filterfdstatus']);
            unset($request['filterfdstatus']);
        }

        return $results->paginate(15);
    }

    public function store($request)
    {
        $payments = $request['payment_id'];
        $deposits = $request['deposit_id'];

//        foreach ($payments as $key => $payment) {
    foreach ($deposits as $key => $deposit) {
        $reconciliation = new FinanceReconciliation();
        $reconciliation->link_key ='deposit_id';
        $reconciliation->link_id = $deposit[$key];
        $reconciliation->cleared_date = $request['date'];
        $reconciliation->user_id = backpack_user()->id;
        $reconciliation->save();

        $this->updateFinanceDeposit($deposit[$key], 'cleared');
//        $this->updateInvoicePayments($payment, 'cleared');
        }
    }

    private function updateInvoicePayments($id, $status)
    {
        $invoice = InvoicePayment::firstWhere('id', $id);
        if ($status == 'cleared') {
            $invoice->reconciled = 1;
        } else if ($status == 'deposited') {
            $invoice->reconciled = NULL;
        }
//        $invoice->status = $status;

        $invoice->save();
    }

    private function updateFinanceDeposit($id, $status)
    {
        $deposit = FinanceDeposit::firstWhere('id', $id);
        $deposit->status = $status;
        $deposit->save();
    }

    public function storeVoid($request)
    {
        $payments = $request['payment_id'];
        $deposit = $request['deposit_id'];

        foreach ($payments as $key => $payment) {

            $reconciliation_id = $this->updateReconciliation($deposit[$key]);

/*            $void = new FinanceVoid();
            $void->link_key = 'reconciliation_id';
            $void->link_id = $reconciliation_id;
            $void->reason = $request['reason'];
            $void->voided_by = backpack_user()->id;;
            $void->voided_date = $request['date'];
            $void->created_by = backpack_user()->id;;
            $void->save();
*/
            $this->updateFinanceDeposit($deposit[$key], 'deposited');
            $this->updateInvoicePayments($payment, 'deposited');
//            $this->updateInvoicePayments($reconciled, null);
        }
    }

    private function updateReconciliation($deposit_id)
    {
        $reconciliation = FinanceReconciliation::firstWhere('link_id', $deposit_id);
        $reconciliation->link_key ='voided_deposit_id';
//        $reconciliation->save();
        $reconciliation->delete();

        return $reconciliation->id;
    }

/*    public function paymentTypes(): Collection
    {
        return DB::table('payment_types as pt')
            ->select('pt.name as name', 'pt.id')
           ->get();
    }
*/

}
