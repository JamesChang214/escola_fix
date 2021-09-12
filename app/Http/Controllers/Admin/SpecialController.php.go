<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeeTypesResource;
use App\Models\Classer;
use App\Models\Grade;
use App\Models\InvoiceFeeType;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\InvoicePaymentVoid;
use App\Models\PaymentType;
use Carbon\Carbon;
use Mpdf\Output\Destination;
use PDF;

class SpecialController extends Controller
{
    public function getClassers(Request $request)
    {
        if ($request->ajax()) {
            $grade = $request->grade;
            $subject = $request->subject;
            $key = $request->search;
            $day = $request->day;
            // dd($grade);
            $output = "";
            $days = [];
            $data = Classer::query();
            $classers = $data->when($key, function ($query) use ($key) {
                return $query->where('name', 'LIKE', '%' . $key . "%");
            })->when($grade, function ($query) use ($grade) {
                return $query->where('grade_id', $grade);
            })->when($subject, function ($query) use ($subject) {
                return $query->where('subject', $subject);
            })->when($day, function ($query) use ($day) {
                return $query->where('days', $day);
            })->get();
            if ($classers) {
                foreach ($classers as $key => $class) {
                    $days = [0, 1, 2, 3, 4, 5, 6];
                    $enabled = "[";
                    foreach ($days as $num) {
                        if (($num != $class->days)) {
                            if (!($class->days == 7 && $num == 0)) {
                                $enabled .= $num . ",";
                            }
                        }
                    }
                    $enabled = rtrim($enabled, ",");
                    $enabled .= "]";
                    $output .= '<tr>' .
                        '<td><input name="class-check" type="checkbox" value="' . $class->id . '"></input></td>' .
                        '<td>' . $class->short_name . '</td>' .
                        '<td>' . $class->name . '</td>' .
                        '<td>' . $class->subject . '</td>' .
                        '<td><input class="form-control" id="start-date-' . $class->id . '" type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-start-date="' . ($class->start_date ? $class->start_date->toDateString() : '') . '" @endif data-date-end-date="' . ($class->end_date ? $class->end_date->toDateString() : '') . '" data-date-days-of-week-disabled="' . $enabled . '" readonly></input></td>' .
                        '</tr>';
                    $days[$class->id] = $class->days;
                }
                return response()->json(['output' => $output]);
            }
        }
    }

    public function getGradesAndSubjects(Request $request)
    {
        if ($request->ajax()) {
            $outputGrades = "";
            $outputSubjects = "";
            $subjects = Classer::groupBy('subject')->pluck('subject')->toArray();
            $grades = Grade::all();
            if ($grades) {
                $outputGrades = '<option value="">Select Grade</option>';
                foreach ($grades as $key => $grade) {
                    $outputGrades .= '<option value=' . $grade->id . '>' . $grade->short_name . '</option>';
                }
            }
            if ($subjects) {
                $outputSubjects = '<option value="">Select Subject</option>';
                foreach ($subjects as $key => $subject) {
                    $outputSubjects .= '<option value=' . $subject . '>' . $subject . '</option>';
                }
            }
            return response()->json(['grades' => $outputGrades, 'subjects' => $outputSubjects]);
        }
    }


    public function getFeeTypes(Request $request)
    {
        if ($request->ajax()) {
            $data = InvoiceFeeType::all();
            return response()->json(['output' => FeeTypesResource::collection($data)]);
        }
    }

    public function getInvoicePaymentInputs(Request $request)
    {
        if ($request->ajax()) {
            $invoicesIds = $request->invoices;
            // dd($invoicesIds);
            $invoices = Invoice::whereIn('id', $invoicesIds)->get();
            $payment_types = PaymentType::all();
            $output = "";
            $date = Carbon::now()->toDateString();
            $payment_types_output = "";
            foreach ($payment_types as $type) {
                $payment_types_output .= '<option value="' . $type->id . '">' . $type->short_name . '</option>';
            }
            foreach ($invoices as $invoice) {
                $output .= '<div class="form-group row">
                            <label class="col-4" for="invoice-payment-' . $invoice->id . '">Invoice Number</label>
                            <input class="col-7 form-control" id="invoice-payment-' . $invoice->id . '" name="invoice-payment-' . $invoice->id . '" type="text" value="' . $invoice->invoice_number . '" disabled>
                        </div>
                        <div class="form-group row">
                            <label class="col-4" for="created-invoice-' . $invoice->id . '">Created Date</label>
                            <input class="col-7 form-control" id="created-invoice-' . $invoice->id . '" name="created-invoice-' . $invoice->id . '" type="text" value="' . $invoice->invoice_date->toDateString() . '" disabled>
                        </div>
                        <div class="form-group row">
                            <label class="col-4" for="created-invoice-' . $invoice->id . '">Fee Amount</label>
                            <input class="col-7 form-control" id="fee-amount-invoice-' . $invoice->id . '" name="fee-amount-invoice-' . $invoice->id . '" type="text" value="' . $invoice->total_amount . '" disabled>
                        </div>
                        <div class="form-group row">
                            <label class="col-4" for="created-invoice-' . $invoice->id . '">Due</label>
                            <input class="col-7 form-control" id="due-amount-invoice-' . $invoice->id . '" name="due-amount-invoice-' . $invoice->id . '" type="text" value="' . $invoice->balance . '" disabled>
                        </div>
                        <div class="form-group row">
                            <label class="col-4" for="created-invoice-' . $invoice->id . '">Student Name</label>
                            <input class="col-7 form-control" id="student-name-invoice-' . $invoice->id . '" name="student-name-invoice-' . $invoice->id . '" type="text" value="' . $invoice->student->common_name . '" disabled>
                        </div>
                        <div class="form-group row">
                            <label class="col-4" for="created-invoice-' . $invoice->id . '">Paid</label>
                            <input class="col-7 form-control" id="paid-invoice-' . $invoice->id . '" name="paid-invoice-' . $invoice->id . '" type="text">
                        </div>
                        <div class="form-group row">
                            <label class="col-4" for="created-invoice-' . $invoice->id . '">External Comment</label>
                            <textarea class="col-7 form-control" id="external-comment-invoice-' . $invoice->id . '" name="external-comment-invoice-' . $invoice->id . '" type="text"></textarea>
                        </div>
                        <div class="form-group row">
                            <label class="col-4" for="created-invoice-' . $invoice->id . '">Transaction Date</label>
                            <input class="col-7 form-control" id="transaction-date-' . $invoice->id . '" type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="' . $date . '" data-date-start-date="' . ($invoice->invoice_date ? $invoice->invoice_date->toDateString() : '') . '" @endif data-date-end-date="' . Carbon::now()->toDateString() . '" readonly></input>
                        </div>
                        <div class="form-group row">
                            <label class="col-4" for="created-invoice-' . $invoice->id . '">Transaction Type</label>
                            <select class="col-7 form-control" name="transaction-type-' . $invoice->id . '" id="transaction-type-' . $invoice->id . '">
                                <option value="" selected>Select Payment Type</option>' . $payment_types_output . '
                            </select>
                        </div>
                        <div class="form-group row">
                            <label class="col-4" for="created-invoice-' . $invoice->id . '">Internal Comment</label>
                            <textarea class="col-7 form-control" id="internal-comment-invoice-' . $invoice->id . '" name="internal-comment-invoice-' . $invoice->id . '" type="text"></textarea>
                        </div>
                        <br><br>';
            }

            return response()->json(['output' => $output]);
        }
    }

    public function getInvoicePdf($invoice_id, $type)
    {
        $invoice = Invoice::find($invoice_id);
        $data = [
            'invoice' => $invoice,
        ];
        // return view('invoice_pdf', $data);

        $pdf = PDF::loadView('invoice_pdf', $data, [], ['title' => 'Invoice']);
        if ($type == 'O') {
            return $pdf->stream($invoice->invoice_number . '_' . $invoice->student->first_name . '_' . $invoice->student->last_name . '.pdf');
        }
        return $pdf->getMpdf()->Output($invoice->invoice_number . '_' . $invoice->student->first_name . '_' . $invoice->student->last_name . '.pdf', 'D');
    }

    public function checkInvoiceStatus(Request $request)
    {
        $approved = [];
        $draft = [];

        foreach ($request->invoices as $invoice_id) {
            $invoice = Invoice::find($invoice_id);
            if ($invoice->status == "Draft") {
                $draft[] = $invoice_id;
            } else {
                $approved[] = $invoice_id;
            }
        }

        return response()->json(['status' => 1, 'approved' => $approved, 'draft' => $draft]);
    }

    public function getReceiptPdf($payment_id)
    {
        $payment = InvoicePayment::find($payment_id);

        $data = [
            'payment' => $payment,
        ];
        // return view('receipt_pdf',$data);
        $pdf = PDF::loadView('receipt_pdf', $data, [], ['title' => 'Receipt']);
        return $pdf->stream($payment->receipt_number . '_' . $payment->student->first_name . '_' . $payment->student->last_name . '.pdf');
    }

    public function getFeeTypeValue($invoice_id, $fee_id)
    {
        $fee_type = InvoiceFeeType::find($fee_id);

        return response()->json(['amount' => $fee_type->amount, 'start_date' => $fee_type->revenue_start_date ? $fee_type->revenue_start_date->toDateString() : "", 'end_date'=> $fee_type->revenue_end_date ? $fee_type->revenue_end_date->toDateString() : ""]);
    }

    public function getRefundPaymentInput(Request $request)
    {
        $output1 = '';
        $output2 = '';

        if ($request->ajax()) {
            $payment = InvoicePayment::find($request->payment_id);
            $today = Carbon::now()->toDateString();

            $output1 = '<div class="form-group">
                <label for="refund-date-' . $payment->id . '">Refund Date</label>
                <input class="form-control" id="refund-date-' . $payment->id . '" type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="' . $today . '" readonly></input>
            </div>
            <div class="form-group">
                <label for="refund-type-' . $payment->id . '">Refund Type</label>
                <select class="form-control" name="refund-type-' . $payment->id . '" id="refund-type-' . $payment->id . '">
                    <option value="" selected>Select Refund Type</option>
                </select>
            </div>
            <div class="form-group">
                <label for="refund-to-' . $payment->id . '">Refund To</label>
                <input class="form-control" id="refund-to-' . $payment->id . '" name="refund-to-' . $payment->id . '" type="text" value="' . $payment->student->getDisplayStudentName() . '" disabled>
            </div>
            <div class="form-group">
                <label for="refund-reason-' . $payment->id . '">Reason</label>
                <select class="form-control" name="refund-reason-' . $payment->id . '" id="refund-reason-' . $payment->id . '">
                    <option value="" selected>Select Reason</option>
                </select>
            </div>
            <div class="form-group">
                <label for="refund-internal-comment-' . $payment->id . '">Internal Comment</label>
                <textarea class="form-control" id="refund-internal-comment-' . $payment->id . '" name="refund-internal-comment-' . $payment->id . '" type="text"></textarea>
            </div>
            <div class="form-group">
                <label for="refund-external-comment-' . $payment->id . '">External Comment</label>
                <textarea class="form-control" id="refund-external-comment-' . $payment->id . '" name="refund-external-comment-' . $payment->id . '" type="text"></textarea>
            </div>';
        }

        return response()->json(['output1' => $output1, 'output2' => $output2]);
    }

    public function getInvoicePaymentDetails(Request $request)
    {
        $body = "";
        $voided = false;
        $payment = InvoicePayment::find($request->payment_id);

        $body = "<div class='row'>
                <strong>Date</strong> : " . $payment->payment_date .
            "</div>
            <div class='row'>
                <strong>Amount</strong> : " . $payment->amount .
            "</div>
            <div class='row'>
                <strong>Type</strong> : " . $payment->paymentType->short_name .
            "</div>";

        if ($payment->status == "voided" || $payment->status == "cleared") {
            $voided = true;
        }

        return response()->json(['heading' => $payment->receipt_number, 'body' => $body, 'payment_date' => $payment->payment_date, 'today' => Carbon::now()->toDateString(), 'voided' => $voided]);
    }

    public function voidPayment(Request $request)
    {
        $payment = InvoicePayment::find($request->payment_id);
        $payment->status = "voided";
        $payment->save();

        $invoice = $payment->invoice;
        if ($invoice->balance) {
            $invoice->balance += $payment->amount;
            $invoice->save();
        }

        if ($payment->financeDeposit) {
            $deposit = $payment->financeDeposit;
            $deposit->status = "voided";
            $deposit->save();
        }

        $invoice_void = new InvoicePaymentVoid();
        $invoice_void->invoice_payment_id = $request->payment_id;
        $invoice_void->reason = $request->reason;
        $invoice_void->voided_date = $request->date;
        $invoice_void->volided_by = backpack_user()->id;
        $invoice_void->save();

        return response()->json(['status' => 1]);
    }
}
