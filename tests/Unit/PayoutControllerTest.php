<?php

namespace Tests\Unit;

use Tests\TestCase;



class PayoutControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_payout_post()
    {        
        $expectedResponseData = json_decode('{"success":false,"error":{"soldItems":["The sold items field is required."]}}', true);

        $response = $this->json('POST','/api/createPayouts', ['invalid-json-string']);
        $response->assertStatus(422)
            ->assertJson(
                $expectedResponseData
            );
    }
}
