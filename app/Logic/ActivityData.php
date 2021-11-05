<?php

declare(strict_types=1);

/**
 * Содержит методы для получения/сохранения данных в бд,
 * которые относятся к логированию активности пользователей.
 */

namespace App\Logic;

USE DateTimeInterface;


class ActivityData
{
    private $url = null;

    private $lastVisitAt = null;

    private $visits = null;

    /**
     * @return int|null
     */
    public function getVisits(): ?int
    {
        return $this->visits;
    }

    public function setVisits(int $visits): ActivityData
    {
        if (is_null($this->visits)) {
            $this->visits = $visits;
        }

        return $this;
    }

    /**
     * @return null|string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): ActivityData
    {
        if (is_null($this->url)) {
            $this->url = $url;
        }

        return $this;
    }

    /**
     * @return null|DateTimeInterface
     */
    public function getLastVisitAt(): ?DateTimeInterface
    {
        return $this->lastVisitAt;
    }

    public function setLastVisitAt(DateTimeInterface $lastVisitAt): ActivityData
    {
        if (is_null($this->lastVisitAt)) {
            $this->lastVisitAt = $lastVisitAt;
        }

        return $this;
    }
}


