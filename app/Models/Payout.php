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

    public function payoutItems() {
        return $this->hasMany(PayoutItem::class, 'payout_id', 'id');
    }

    /**
     * Creates payout records in DB
     * For every row, associates payout items
     * Transactional Commits
     * Throws Error
     * @return Boolean
     */
    public static function createRecords($payoutRecords) {
        DB::beginTransaction();
        try {
            $payoutItemRecords = array();
            foreach($payoutRecords as &$record) {
                $row = ['currency_code' => strtoupper($record['currency_code']),
                        'seller_id' => $record['seller_id'],
                        'amount' => $record['amount']
                    ];
                $payoutRow = self::make($row);
                $payoutRow->save();
                $payoutId = $payoutRow->id;
                foreach($record['item_id'] as $itemId) {
                    $payoutItemRecords[] = ['payout_id'=>$payoutId, 'item_id' => $itemId];
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

    public static function getAllRecords() {
        return self::with('payoutItems')
            ->orderBy('created_at','DESC')->get();
    }

}
