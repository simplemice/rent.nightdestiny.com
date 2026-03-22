<?php

namespace Monkeycar;

class Calculator
{
    /**
     * @var \Monkeycar\Store
     */
    private $store;

    /**
     * @var array
     */
    private $fromRegion;

    /**
     * @var array
     */
    private $toRegion;

    /**
     * @var \Monkeycar\Request
     */
    private $request;

    public function __construct(Store $store, Request $request)
    {
        $this->store = $store;
        $this->request = $request;

        try {
            $this->fromRegion = $this->store->getRegionById($request->getPlaceFromId());
            $this->toRegion = $this->store->getRegionById($request->getPlaceToId());
        } catch (\Exception $e) {
            $firstRegion = current($this->store->getRegions());

            $this->fromRegion = $firstRegion;
            $this->toRegion = $firstRegion;

            error_log(print_r($e->getMessage(), true));
        }
    }

    /**
     * @param int $carId
     * @return array
     * @throws \Exception
     */
    public function calculatePrice(int $carId): array
    {
        $startDate = $this->request->getStartDate();
        $endDate = $this->request->getEndDate();

        $car = $this->store->getCarById($carId);
        $price = $car['price'];
        $discountPercentage = $car['discount'];
        $carDeposit = $car['deposit'];

        /**
         * Discounts per days
         */
//        $discountPerDays = $this->store->getExtraByKey('discount_per_days');
//        foreach ($discountPerDays as $item) {
//            if ($days >= $item['start'] && $days < $item['end']) {
//                $discountPercentage += $item['discount'];
//                break;
//            }
//        }

        $price = $this->_reducePercentage($price, $discountPercentage);
        // ...end discount

        $rentPrice = 0;
        $addPrice = 0;

        /**
         * Rent price
         */
        $diff = $endDate->diff($startDate);
        $days = $diff->days;
        // Plus one day if more/low than 4 hours.
        if ($diff->h > $this->store->getExtraByKey('extra_hour')) {
            $days++;
        }

        for ($i = 0; $i < $days; $i++) {
            $_date1 = clone $startDate;
            $curDate = $_date1->add(new \DateInterval("P{$i}D"));

            $rentPrice += $this->_calcPrice($curDate, $price);
        }

        /**
         * Additional price
         */
        if ($this->request->getExtra()->isIncludeInsurance()) {
            $addPrice += $rentPrice * (float)$this->store->getExtraByKey('insurance') / 100;
        }

        if ($this->request->getExtra()->isIncludeBabyChair()) {
            $addPrice += $days * (float)$this->store->getExtraByKey('baby_chair');
        }

        if ($this->request->getExtra()->isIncludeSim()) {
            $addPrice += (float)$this->store->getExtraByKey('sim');
        }

        /**
         * Recalculate
         */
        $addPrice = round($addPrice, 2);

        $regionFromPrice = $this->fromRegion['price'];
        $regionToPrice = $this->toRegion['price'];

        $avgPrice = round($rentPrice / $days, 2);
        $rentPrice = $avgPrice * $days;

        /**
         * Response
         */
        $response = [];
        $response['days'] = $days;
        $response['per_day'] = [
            'old_price' => $discountPercentage ? $this->_addPercentage($avgPrice, $discountPercentage) : null,
            'price' => $avgPrice,
        ];

        $response['price'] = $rentPrice;

        $response['discountPercentage'] = $discountPercentage;
        $response['discountPrice'] = $discountPercentage
            ? $rentPrice - $this->_reducePercentage($rentPrice, $discountPercentage)
            : null;

        $response['deposit'] = $carDeposit;

        $response['delivery'] = $regionToPrice + $regionFromPrice;
        $response['options'] = $addPrice;

        // Total
        $response['total'] = $rentPrice + $regionToPrice + $regionFromPrice + $addPrice;
        $response['total'] = round($response['total'], 2);

        return $response;
    }

    /**
     * @return array
     */
    public function getFromRegion(): array
    {
        return $this->fromRegion;
    }

    /**
     * @return array
     */
    public function getToRegion(): array
    {
        return $this->toRegion;
    }

    /**
     * @param float $price
     * @param int $percentage
     * @return float
     */
    private function _reducePercentage(float $price, int $percentage): float
    {
        if ($percentage) {
            $price *= (1 - ($percentage / 100));

            $price = ceil($price);
        }

        return $price;
    }

    /**
     * @param float $price
     * @param int $percentage
     * @return float
     */
    private function _addPercentage(float $price, int $percentage): float
    {
        if ($percentage) {
            $price *= (1 + ($percentage / 100));

            $price = ceil($price);
        }

        return $price;
    }

    /**
     * @param \DateTimeImmutable $date
     * @param float $price
     * @return float
     */
    private function _calcPrice(\DateTimeImmutable $date, float $price): float
    {
        $periods = $this->store->getPeriods();

        foreach ($periods as $period) {
            $d1 = \DateTimeImmutable::createFromFormat('d.m.Y', $period['start']);
            $d2 = \DateTimeImmutable::createFromFormat('d.m.Y', $period['end']);
            $ratio = (float)$period['ratio'];

            if ($ratio) {
                $ts = $date->getTimestamp();

                if ($ts >= $d1->getTimestamp() && $ts <= $d2->getTimestamp()) {
                    $price *= $ratio;

                    break;
                }
            }
        }

        return $price;
    }
}
