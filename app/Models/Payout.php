<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PayoutItem;
use \Exception;
use \DB;

class Payout extends Model
{
    use HasFactory;

    protected $fillable = ['currency_code','seller_id','amount'];

    public static function createRecords($payoutRecords) {
        DB::beginTransaction();
        try {
            $payoutItemRecords = array();
            foreach($payoutRecords as &$record) {
                $row = ['currency_code' => strtoupper($record['currency_code']),
                        'seller_id' => $record['seller_id'],
                        'amount' => $record['amount']
                    ];
                $payoutId = self::make($row)->save();
                foreach($record['item_id'] as $itemId) {
                    $payoutItemRecords[] = ['payout_id'=>$payoutId, 'item_id'=>$itemId];
                }
            }
            PayoutItem::insert($payoutItemRecords);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        return true;
    }

}
