<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    public function order_items()
    {
        return $this->hasMany(OrderItems::class,'order_id');
    }

    public function getCode()
    {
        $sDocument = "INV.";
        $lastCode = Order::latest()->first();
        $sDocumentLength = strlen($sDocument);

        $sCurrentDB = $lastCode->invoice_number ?? '';
        $sLetterHead = $sDocument.date("y").date("m").date("d");

        $nDocumentLength = strlen($sCurrentDB);
        if ((substr($sCurrentDB, (0 + $sDocumentLength), 2) == date("y")) and (substr($sCurrentDB, (2 + $sDocumentLength), 2) == date("m")) and (substr($sCurrentDB, (4 + $sDocumentLength), 2) == date("d"))) {
            $sLetterNumber = substr($sCurrentDB, (7 + $sDocumentLength), $nDocumentLength) + 1;
        } else {
            $sLetterNumber = "1";
        }

        $nLetterNumberLength = strlen($sLetterNumber);
        switch ($nLetterNumberLength) {
            case 1 : $sLetterNumber = "0".$sLetterNumber;
            case 2 : $sLetterNumber = "0".$sLetterNumber;
        }

        $sValue = $sLetterHead.$sLetterNumber;

        return $sValue;
    }
}
