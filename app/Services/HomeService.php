<?php

namespace App\Services;

use App\Repositories\TaskRepository;

class HomeService
{
    public function __construct(
        protected TaskRepository $taskRepo
    ) {
    }
    public function getTaskToday()
    {
        return $this->taskRepo->getTaskSubTaskToday();
    }
}
