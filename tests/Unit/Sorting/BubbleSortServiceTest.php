<?php

namespace Tests\Unit\Sorting;

use App\Services\Sorting\BubbleSortService;
use Exception;
use Tests\TestCase;

class BubbleSortServiceTest extends TestCase
{
    private BubbleSortService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new BubbleSortService();
    }

    public function testSortsMixedArray(): void
    {
        $result = $this->service->sort([15, 23, 1, -234, 400, 92]);

        $this->assertSame([-234, 1, 15, 23, 92, 400], $result);
    }

    public function testAlreadySortedReturnsSameOrder(): void
    {
        $result = $this->service->sort([1, 2, 3, 4, 5]);

        $this->assertSame([1, 2, 3, 4, 5], $result);
    }

    public function testReverseSorted(): void
    {
        $result = $this->service->sort([5, 4, 3, 2, 1]);

        $this->assertSame([1, 2, 3, 4, 5], $result);
    }

    public function testNegativeNumbers(): void
    {
        $result = $this->service->sort([-5, -1, -10, -3]);

        $this->assertSame([-10, -5, -3, -1], $result);
    }

    public function testSingleElement(): void
    {
        $result = $this->service->sort([42]);

        $this->assertSame([42], $result);
    }

    public function testEmptyArray(): void
    {
        $result = $this->service->sort([]);

        $this->assertSame([], $result);
    }

    public function testDuplicateValues(): void
    {
        $result = $this->service->sort([3, 1, 2, 1, 3]);

        $this->assertSame([1, 1, 2, 3, 3], $result);
    }

    public function testResultMatchesNativeSort(): void
    {
        $data = [412, -99, 0, 7, -7, 1000, 3, 256];
        $expected = $data;
        sort($expected);

        $result = $this->service->sort($data);

        $this->assertSame($expected, $result);
    }

    public function testSortsLargeArray(): void
    {
        try {
            $data = array_map(fn() => random_int(-1000000, 1000000), range(1, 10000));
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }

        $expected = $data;
        sort($expected);

        $result = $this->service->sort($data);

        $this->assertSame($expected, $result);
    }
}
