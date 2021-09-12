<!-- Add Students to class modal start -->

<div class="modal fade" id="toClass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Students To Class</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body add-to-class-modal-body">
                <div class="form-group row">
                    <input type="text" class="form-controller col-md-3 mb-2 ml-2" id="searchClass" name="searchClass" placeholder="Search Class"></input>
                    <select class="form-control col-md-2 mb-2 ml-1" name="grades" id="grades">
                    </select>
                    <select class="form-control col-md-3 mb-2 ml-1" name="subjects" id="subjects">
                    </select>
                    <select class="form-control col-md-3 mb-2 ml-1" name="day" id="day">
                        <option value="" selected>Select Day</option>
                        <option value="1">Monday</option>
                        <option value="2">Tuesday</option>
                        <option value="3">Wednesday</option>
                        <option value="4">Thursday</option>
                        <option value="5">Friday</option>
                        <option value="6">Saturday</option>
                        <option value="7">Sunday</option>
                    </select>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Short Name</th>
                                <th>Name</th>
                                <th>Subject</th>
                                <th>Start Date</th>
                            </tr>
                        </thead>
                        <tbody class="class-list" id="tbody-modal-to-class">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button id="submitAddToClass" class="btn btn-primary" type="button">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content-->
        </div>
        <!-- /.modal-dialog-->
    </div>
</div>
<!-- Add students to class modal end -->


<!-- Classes invoice modal start -->

<div class="modal fade" id="classersInvoice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-large" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Classers Invoice</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body classers-invoice-modal">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active" data-toggle=tab href="#classerInvoiceTabNav-tabs-1">Details</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle=tab href="#classerInvoiceTabNav-tabs-2">Instructions</a></li>
                </ul>
                <div class="tab-content" id="classerInvoiceTabNav-content">
                    <div class="tab-pane fade show active" id="classerInvoiceTabNav-tabs-1" role="tabpanel" aria-labelledby="classerInvoiceTabNav-tab-1">
                        <div class="form-group row">
                            <!-- <input type="text" class="form-controller col-md-3 mb-2 ml-2" id="searchFee" name="searchFee" placeholder="Search Fee"></input> -->
                            <a class="btn btn-secondary m-1" type="button" data-toggle="modal" data-target="#addFeeTypeClassers">Add Fee</a>
                            <div class="modal fade" id="addFeeTypeClassers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Add Fee</h4>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <select class="form-control" name="feesClassersInvoice" id="feesClassersInvoice">
                                            </select>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" onclick="$('#addFeeTypeClassers').modal('hide');">Close</button>
                                                <button id="submitFeeTypeClassers" class="btn btn-primary" type="button">Add</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content-->
                                    </div>
                                    <!-- /.modal-dialog-->
                                </div>
                            </div>
                            <div class="form-group col-md-2 ml-auto row date-div">
                                <label for="#classer-invoice-issue-date" class="col-6">Issue Date</label>
                                <input class="form-control col-6" id="classer-invoice-issue-date" type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-week-start="1" placeholder="Issue Date" value="{{ now()->toDateString() }}"></input>
                            </div>
                            <div class="form-group col-md-2 row date-div">
                                <label for="#classer-invoice-due-date" class="col-6">Due Date</label>
                                <input class="form-control col-6" id="classer-invoice-due-date" type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-week-start="1" placeholder="Due Date" value="{{ now()->addDays(14)->toDateString() }}"></input>
                            </div>
                            <!-- /.For Invoice templates 
                            <select class="form-control col-md-3 mb-2 mr-2" name="templateClassersInvoice" id="templateClassersInvoice">
                                <option value="" selected>Select Template</option>
                                <option value="1">Template 1</option>
                                <option value="2">Template 2</option>
                                <option value="3">Template 3</option>
                                <option value="4">Template 4</option>
                            </select>
-->
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Fee Type</th>
                                        <!-- <th>Description</th> -->
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Discount</th>
                                        <th>Net</th>
                                    </tr>
                                </thead>
                                <tbody class="class-list" id="tbody-modal-classers-invoice">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="classerInvoiceTabNav-tabs-2" role="tabpanel" aria-labelledby="classerInvoiceTabNav-tab-2">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="classer-invoice-instruction-1">Instruction 1</label>
                                <textarea class="form-control" id="classer-invoice-instruction-1" name="classer-invoice-instruction-1" type="text"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="classer-invoice-instruction-2">Instruction 2</label>
                                <textarea class="form-control" id="classer-invoice-instruction-2" name="classer-invoice-instruction-2" type="text"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group col-md-2 mb-2 ml-auto mr-2">
                        <label for="classers-invoice-total-discount">Total Discount</label>
                        <input class="form-control" id="classers-invoice-total-discount" name="classers-invoice-total" type="text" disabled>
                    </div>
                    <div class="form-group col-md-2 mb-2 ml-2 mr-2">
                        <label for="classers-invoice-total">Total</label>
                        <input class="form-control" id="classers-invoice-total-net" name="classers-invoice-total-net" type="text" disabled>
                    </div>
                    <button id="closeClassersInvoice" class="btn btn-secondary mt-3" type="button" data-dismiss="modal">Close</button>
                    <button id="submitClassersInvoice" class="btn btn-primary" type="button">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content-->
        </div>
        <!-- /.modal-dialog-->
    </div>
</div>

<!-- Classes invoice modal end -->


<!-- Students invoice modal start -->

<div class="modal fade" id="studentsInvoice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-large" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Students Invoice</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body students-invoice-modal">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active" data-toggle=tab href="#studentInvoiceTabNav-tabs-1">Details</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle=tab href="#studentInvoiceTabNav-tabs-2">Instructions</a></li>
                </ul>
                <div class="tab-content" id="studentInvoiceTabNav-content">
                    <div class="tab-pane fade show active" id="studentInvoiceTabNav-tabs-1" role="tabpanel" aria-labelledby="studentInvoiceTabNav-tab-1">
                        <div class="form-group row">
                            <!-- <input type="text" class="form-controller col-md-3 mb-2 ml-2" id="searchFee" name="searchFee" placeholder="Search Fee"></input> -->
                            <a class="btn btn-secondary m-1" type="button" data-toggle="modal" data-target="#addFeeTypeStudents">Add Fee</a>
                            <div class="modal fade" id="addFeeTypeStudents" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Add Fee</h4>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <select class="form-control" name="feesStudentsInvoice" id="feesStudentsInvoice">
                                            </select>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" onclick="$('#addFeeTypeStudents').modal('hide');">Close</button>
                                                <button id="submitFeeTypeStudents" class="btn btn-primary" type="button">Add</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content-->
                                    </div>
                                    <!-- /.modal-dialog-->
                                </div>
                            </div>
                            <div class="form-group col-md-2 ml-auto row date-div">
                                <label for="#student-invoice-issue-date" class="col-6">Issue Date</label>
                                <input class="form-control col-6" id="student-invoice-issue-date" type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-week-start="1" placeholder="Issue Date" value="{{ now()->toDateString() }}"></input>
                            </div>
                            <div class="form-group col-md-2 row date-div">
                                <label for="#student-invoice-due-date" class="col-6">Due Date</label>
                                <input class="form-control col-6" id="student-invoice-due-date" type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-week-start="1" placeholder="Due Date" value="{{ now()->addDays(14)->toDateString() }}"></input>
                            </div>
                            <!-- For invoice templates
                            <select class="form-control col-md-3 mb-2 mr-2" name="templateStudentsInvoice" id="templateStudentsInvoice">
                                <option value="" selected>Select Template</option>
                                <option value="1">Template 1</option>
                                <option value="2">Template 2</option>
                                <option value="3">Template 3</option>
                                <option value="4">Template 4</option>
                            </select>
-->
                            <table class="table table-bordered table-hover p-2">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Fee Type</th>
                                        <!-- <th>Description</th> -->
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Discount</th>
                                        <th>Net</th>
                                    </tr>
                                </thead>
                                <tbody class="class-list" id="tbody-modal-students-invoice">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="studentInvoiceTabNav-tabs-2" role="tabpanel" aria-labelledby="studentInvoiceTabNav-tab-2">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="student-invoice-instruction-1">Instruction 1</label>
                                <textarea class="form-control" id="student-invoice-instruction-1" name="student-invoice-instruction-1" type="text"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="student-invoice-instruction-2">Instruction 2</label>
                                <textarea class="form-control" id="student-invoice-instruction-2" name="student-invoice-instruction-2" type="text"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="form-group col-md-2 mb-2 ml-auto mr-2">
                    <label for="students-invoice-total-discount">Total Discount</label>
                    <input class="form-control" id="students-invoice-total-discount" name="students-invoice-total" type="text" disabled>
                </div>
                <div class="form-group col-md-2 mb-2 ml-2 mr-2">
                    <label for="students-invoice-total">Total</label>
                    <input class="form-control" id="students-invoice-total-net" name="students-invoice-total-net" type="text" disabled>
                </div>
                <button id="closeStudentsInvoice" class="btn btn-secondary mt-3" type="button" data-dismiss="modal">Close</button>
                <button id="submitStudentsInvoice" class="btn btn-primary mt-3" type="button">Save changes</button>
            </div>
            <!-- /.modal-content-->
        </div>
        <!-- /.modal-dialog-->
    </div>
</div>

<!-- Students invoice modal end -->


<!-- Invoice payments modal start -->

<div class="modal fade" id="invoicePaymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Invoice Payments</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body invoice-payment-modal-body">

            </div>
            <div class="modal-footer row">
                <div class="custom-control custom-switch col ml-2">
                    <input type="checkbox" class="custom-control-input" id="print_receipt" name="print_receipt">
                    <label class="custom-control-label" for="print_receipt">Print Receipt</label>
                </div>
                <button id="closeInvoicePayment" class="btn btn-secondary mt-3" type="button" data-dismiss="modal">Close</button>
                <button id="submitInvoicePayment" class="btn btn-primary mt-3" type="button">Save changes</button>
            </div>
            <!-- /.modal-content-->
        </div>
        <!-- /.modal-dialog-->
    </div>
</div>

<!-- Invoice payments modal end -->

<!-- Invoice approve confirmation modal start -->

<div class="modal fade" id="invoiceStatusModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmation</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body invoice-status-modal-body">
                Are you sure you want to update status of these selected invoices ?
            </div>
            <div class="modal-footer">
                <button id="closeInvoiceStatus" class="btn btn-secondary mt-3" type="button" data-dismiss="modal">Close</button>
                <button id="submitInvoiceApprove" class="btn btn-primary mt-3 submit-invoice-status" type="button" value="1">Approve</button>
                <button id="submitInvoiceVoid" class="btn btn-primary mt-3 submit-invoice-status" type="button" value="0">Void</button>
            </div>
            <!-- /.modal-content-->
        </div>
        <!-- /.modal-dialog-->
    </div>
</div>

<!-- Invoice approve confirmation end -->


<!-- Invoice PDF confirmation modal start -->

<div class="modal fade" id="invoicePdfConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmation</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body invoice-pdf-modal-body">
                Are you sure you want to download these invoices ?
            </div>
            <div class="modal-footer">
                <button id="closeInvoicePdf" class="btn btn-secondary mt-3" type="button" data-dismiss="modal">Close</button>
                <button id="submitInvoicePdf" class="btn btn-primary mt-3" type="button">Download</button>
            </div>
            <!-- /.modal-content-->
        </div>
        <!-- /.modal-dialog-->
    </div>
</div>

<!-- Invoice PDF confirmation end -->


<!-- Refund modal start -->

<div class="modal fade" id="refundModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-large" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Refund</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body row">
                <div class="col-3 refund-modal-body-1">
                    Part 1
                </div>
                <div class="col-9 refund-modal-body-2">
                    Part 2
                </div>
            </div>
            <div class="modal-footer">
                <button id="closeRefundModal" class="btn btn-secondary mt-3" type="button" data-dismiss="modal">Cancel</button>
                <button id="submitRefundModal" class="btn btn-primary mt-3" type="button">Process</button>
            </div>
            <!-- /.modal-content-->
        </div>
        <!-- /.modal-dialog-->
    </div>
</div>

<!-- Refund modal end -->

<!-- Document Action modal start -->

<div class="modal fade" id="documentActionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title document-action-modal-title"></h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body document-action-modal-body">
            </div>
            <div class="modal-footer document-action-modal-footer">
                <button id="closeDocumentActionModal" class="btn btn-secondary mt-3" type="button" data-dismiss="modal">Close</button>
                <a id="printDocumentActionModal" class="btn btn-primary mt-3" type="button">Print</a>
                <a id="editDocumentActionModal" class="btn btn-primary mt-3" type="button" href="">Edit</a>
                <button id="voidDocumentActionModal" class="btn btn-primary mt-3" type="button" onclick="voidPaymentModal()">Void</button>
            </div>
            <!-- /.modal-content-->
        </div>
        <!-- /.modal-dialog-->
    </div>
</div>

<!-- Document Action end -->

<!-- Void payment modal start -->

<div class="modal fade" id="voidPaymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Collection (Void)</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body void-payment-modal-body">
                <div class="form-group">
                    <label for="void-payment-date">Voided Date</label>
                    <input class="form-control" id="void-payment-date" type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" required readonly></input>
                </div>
                <div class="form-group">
                    <label for="void-payment-date">Voided Reason</label>
                    <select class="form-control" name="void-payment-reason" id="void-payment-reason">
                        <option value="Duplicate Payment" selected>Duplicate Payment</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer collection-void-modal-footer">
                <button id="closeVoidPaymentModal" class="btn btn-secondary mt-3" type="button" data-dismiss="modal">Close</button>
                <button id="submitVoidPayment" class="btn btn-primary mt-3" type="button">Process</button>
            </div>
            <!-- /.modal-content-->
        </div>
        <!-- /.modal-dialog-->
    </div>
</div>

<!-- Void payment end -->