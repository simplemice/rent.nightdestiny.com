<?php

namespace Monkeycar;

class Request
{
    const DATE_FORMAT = 'Y-m-d H:i';

    /**
     * @var int
     */
    private $placeFromId;

    /**
     * @var int
     */
    private $placeToId;

    /**
     * @var \DateTimeImmutable
     */
    private $startDate;

    /**
     * @var \DateTimeImmutable
     */
    private $endDate;

    /**
     * @var int
     */
    private $carId;

    /**
     * @var \Monkeycar\RequestExtra
     */
    private $extra;

    public function __construct(
        \DateTimeImmutable $startDate,
        \DateTimeImmutable $endDate,
        int $placeFromId,
        int $placeToId,
        RequestExtra $extra,
        int $carId
    ) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;

        $this->placeFromId = $placeFromId;
        $this->placeToId = $placeToId;
        $this->carId = $carId;
        $this->extra = $extra;
    }

    /**
     * @param array $request
     * @return static
     * @throws \Exception
     */
    public static function fromRequest(array $request): self
    {
        $placeFrom = (int)($request['place_from'] ?? 0);
        $placeTo = (int)($request['place_to'] ?? 0);

        try {
            $dateFrom = \DateTimeImmutable::createFromFormat(self::DATE_FORMAT, $request['date_from'] ?? null);
            $dateTo = \DateTimeImmutable::createFromFormat(self::DATE_FORMAT, $request['date_to'] ?? null);
            if (!$dateFrom || !$dateTo) {
                throw new \InvalidArgumentException('Invalid date format');
            }

            if ($dateFrom->getTimestamp() < time()) {
                throw new \InvalidArgumentException('Start date already end.');
            }

        } catch (\ Exception $e) {
            $dateFrom = (new \DateTimeImmutable())->setTime(12, 0);
            $dateTo = $dateFrom->add(new \DateInterval('P3D'));
        }

        $includeInsurance = (bool)($request['insurance'] ?? false);
        $includeBabyChair = (bool)($request['chair'] ?? false);
        $includeSim = (bool)($request['sim'] ?? false);
        $extra = new RequestExtra($includeInsurance, $includeBabyChair, $includeSim);

        $carId = (int)($request['car'] ?? 0);

        return new self($dateFrom, $dateTo, $placeFrom, $placeTo, $extra, $carId);
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        $payload = [
            'car' => $this->carId,
            'place_from' => $this->placeFromId,
            'place_to' => $this->placeToId,
            'date_from' => $this->startDate->format(self::DATE_FORMAT),
            'date_to' => $this->endDate->format(self::DATE_FORMAT),
            'insurance' => $this->extra->isIncludeInsurance(),
            'chair' => $this->extra->isIncludeBabyChair(),
            'sim' => $this->extra->isIncludeSim(),
        ];

        $payload = array_filter($payload);

        return $payload;
    }

    /**
     * @return int
     */
    public function getCarId(): int
    {
        return $this->carId;
    }

    /**
     * @return int
     */
    public function getPlaceFromId(): int
    {
        return $this->placeFromId;
    }

    /**
     * @return int
     */
    public function getPlaceToId(): int
    {
        return $this->placeToId;
    }

    /**
     * @return bool
     */
    public function isSamePlace(): bool
    {
        return $this->getPlaceFromId() === $this->getPlaceToId();
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getStartDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getEndDate(): \DateTimeImmutable
    {
        return $this->endDate;
    }

    /**
     * @return \Monkeycar\RequestExtra
     */
    public function getExtra(): \Monkeycar\RequestExtra
    {
        return $this->extra;
    }
}
