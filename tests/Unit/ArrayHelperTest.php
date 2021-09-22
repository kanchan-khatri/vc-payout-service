<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Helpers\ArrayHelper;
use \Exception;

class ArrayHelperTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_split_array_by_key_threshold()
    {
        $dummyData1 = [
            ['item_id'=>1, 'amount'=> 10],
            ['item_id'=>2, 'amount'=> 15],
            ['item_id'=>3, 'amount'=> 20],
            ['item_id'=>4, 'amount'=> 30],
            ['item_id'=>5, 'amount'=> 50],
            ['item_id'=>6, 'amount'=> 165]
        ];
        $expectedResponse1 = [
            [
                ['item_id'=>1, 'amount'=> 10],
                ['item_id'=>2, 'amount'=> 15],
                ['item_id'=>6, 'amount'=> 15]
            ],
            [
                ['item_id'=>3, 'amount'=> 20],
                ['item_id'=>4, 'amount'=> 30]
            ],
            [
                ['item_id'=>5, 'amount'=> 50],                
            ],
            [
                ['item_id'=>6, 'amount'=> 50],                
            ],
            [
                ['item_id'=>6, 'amount'=> 50],                
            ],
            [
                ['item_id'=>6, 'amount'=> 50],                
            ]
        ];
            
        $this->assertEquals($expectedResponse1, 
            ArrayHelper::splitArrayByKeyThreshold($dummyData1, 50, 'amount'));

        $this->expectException(Exception::class);
        ArrayHelper::splitArrayByKeyThreshold($dummyData1, 0, 'amount');        
    }

    public function test_sort_array_by_key() {
        $dummyData1 = [
            ['item_id'=>1, 'amount'=> 10],            
            ['item_id'=>5, 'amount'=> 50],
            ['item_id'=>3, 'amount'=> 20]
        ];
        $expectedResponse1 = [
            ['item_id'=>1, 'amount'=> 10],            
            ['item_id'=>3, 'amount'=> 20],
            ['item_id'=>5, 'amount'=> 50]
        ];
        ArrayHelper::sortArrayByKey($dummyData1, 'amount');
        $this->assertEquals($expectedResponse1, $dummyData1);        
    }

}
