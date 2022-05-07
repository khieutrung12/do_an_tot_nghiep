<?php

namespace Tests\Unit\Models;

use App\Models\Voucher;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VoucherTest extends TestCase
{
    protected $voucher;

    public function setUp(): void
    {
        parent::setUp();
        $this->voucher = new Voucher();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->voucher);
    }

    public function testFillable()
    {
        $this->assertEquals([
            'name',
            'quantity',
            'value',
            'condition_min_price',
            'maximum_reduction',
            'start_date',
            'end_date',
        ], $this->voucher->getFillable());
    }

    public function testHasOneOrder()
    {
        $relation = $this->voucher->order();

        $this->assertInstanceOf(HasOne::class, $relation);
        $this->assertEquals('voucher_id', $relation->getForeignKeyName());
    }

    public function testFunctionDiscountFail()
    {
        $voucher = Voucher::factory()->make();

        $total = $voucher->condition_min_price - 1;

        $voucher->quantity = 0;
        $voucher->start_date = date("Y-m-d", strtotime("+1 day"));
        $voucher->end_date = date("Y-m-d", strtotime("-1 day"));

        $this->assertEquals($voucher->discount($total), null);
    }

    public function testFunctionDiscountReturnDiscount()
    {
        $voucher = Voucher::factory()->make();

        $total = $voucher->condition_min_price;
        
        $voucher->quantity = 1;
        $voucher->start_date = date("Y-m-d");
        $voucher->end_date = date("Y-m-d");
        $voucher->value = 50;

        $discount = ($voucher->value / 100) * $total;
        $voucher->maximum_reduction = $discount + 1;

        $this->assertEquals($voucher->discount($total), $discount);
    }

    public function testFunctionDiscountReturnMaximumReduction()
    {
        $voucher = Voucher::factory()->make();

        $total = $voucher->condition_min_price;

        $voucher->quantity = 1;
        $voucher->start_date = date("Y-m-d");
        $voucher->end_date = date("Y-m-d");
        $voucher->value = 50;
        $voucher->maximum_reduction = ($voucher->value / 100) * $total - 1;

        $this->assertEquals($voucher->discount($total), $voucher->maximum_reduction);
    }
}
