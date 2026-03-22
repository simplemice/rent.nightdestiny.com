<?php

namespace Monkeycar;

class RequestExtra
{
    /**
     * @var bool
     */
    private $includeInsurance;

    /**
     * @var bool
     */
    private $includeBabyChair;

    /**
     * @var bool
     */
    private $includeSim;

    public function __construct(
        bool $includeInsurance,
        bool $includeBabyChair,
        bool $includeSim
    ) {
        $this->includeInsurance = $includeInsurance;
        $this->includeBabyChair = $includeBabyChair;
        $this->includeSim = $includeSim;
    }

    /**
     * @return bool
     */
    public function isIncludeInsurance(): bool
    {
        return $this->includeInsurance;
    }

    /**
     * @return bool
     */
    public function isIncludeBabyChair(): bool
    {
        return $this->includeBabyChair;
    }

    /**
     * @return bool
     */
    public function isIncludeSim(): bool
    {
        return $this->includeSim;
    }
}
