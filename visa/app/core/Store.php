<?php

namespace Monkeycar;

class Store
{
    /**
     * @var array
     */
    private $cars;

    /**
     * @var array
     */
    private $regions;

    /**
     * @var array
     */
    private $periods;

    /**
     * @var array
     */
    private $extra;

    public function __construct(array $cars, array $regions, array $periods, array $extra)
    {
        foreach ($cars as $carId => $car) {
            $car['id'] = $carId;

//            try {
//                $currentTime = time();
//
//                $start = $car['published']['start'] ?? '';
//                if ($start) {
//                    $dateFrom = \DateTimeImmutable::createFromFormat('Y-m-d H:i', $start);
//
//                    if ($dateFrom->getTimestamp() > $currentTime) {
//                        continue;
//                    }
//                }
//
//                $end = $car['published']['end'] ?? '';
//                if ($end) {
//                    $dateTo = \DateTimeImmutable::createFromFormat('Y-m-d H:i', $end);
//                    if ($dateTo->getTimestamp() < $currentTime) {
//                        continue;
//                    }
//                }
//            } catch (\ Exception $e) {
//            }

            $this->cars[$carId] = $car;
        }

        foreach ($regions as $regionId => $region) {
            $region['id'] = $regionId;
            $this->regions[$regionId] = $region;
        }

        $this->periods = $periods;
        $this->extra = $extra;
    }

    /**
     * @param int $regionId
     * @return array
     */
    public function getRegionById(int $regionId): array
    {
        $region = $this->regions[$regionId] ?? null;

        if (!$region) {
            throw new \RuntimeException('Invalid RegionId');
        }

        return $region;
    }

    /**
     * @return array
     */
    public function getRegions(): array
    {
        return $this->regions;
    }

    /**
     * @param int $carId
     * @return array
     */
    public function getCarById(int $carId): array
    {
        $car = $this->cars[$carId] ?? null;

        if (!$car) {
            throw new \RuntimeException('Invalid CarId');
        }

        return $car;
    }

    /**
     * @param \Monkeycar\Request $request
     * @return array
     */
    public function getCarFromRequest(Request $request): array
    {
        $carId = $request->getCarId();

        $car = $this->cars[$carId] ?? null;

        if (!$car) {
            throw new \RuntimeException('Invalid CarId');
        }

        if (!$this->isCarAvailable($car, $request)) {
            throw new \RuntimeException('Car is not available');
        }

        return $car;
    }

    /**
     * @param \Monkeycar\Request $request
     * @return array
     */
    public function getCarsByRequest(Request $request): array
    {
        $cars = [];

        foreach ($this->cars as $key => $car) {
            if ($this->isCarAvailable($car, $request)) {
                $cars[$key] = $car;
            }
        }

        return $cars;
    }

    /**
     * @return array
     */
    public function getPeriods(): array
    {
        return $this->periods;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getExtraByKey(string $name)
    {
        return $this->extra[$name] ?? null;
    }

    /**
     * @param array $car
     * @param \Monkeycar\Request $request
     * @return bool
     */
    private function isCarAvailable(array $car, Request $request): bool
    {
        $from = $request->getStartDate()->getTimestamp();
        $to = $request->getEndDate()->getTimestamp();

        try {
            $start = $car['available']['start'] ?? '';
            if ($start) {
                $availableFrom = \DateTimeImmutable::createFromFormat('Y-m-d H:i', $start)->getTimestamp();

                if ($availableFrom > $from) {
                    return false;
                }
            }

            $end = $car['available']['end'] ?? '';
            if ($end) {
                $availableTo = \DateTimeImmutable::createFromFormat('Y-m-d H:i', $end)->getTimestamp();

                if ($availableTo < $to) {
                    return false;
                }
            }
        } catch (\Exception $e) {
            error_log(print_r($e->getMessage(), true));
        }

        return true;
    }
}
