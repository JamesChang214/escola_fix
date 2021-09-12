<?php


namespace App\Repositories\Reconciliation;


Interface ReconciliationInterface
{
    public function index($request);
//    public function paymentTypes();
    public function store($request);
    public function storeVoid($request);
}
