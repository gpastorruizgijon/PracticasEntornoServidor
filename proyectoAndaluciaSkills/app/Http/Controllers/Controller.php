<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    protected function currentUser(): User
    {
        /** @var User $user */
        $user = Auth::user();
        return $user;
    }

    protected function isAdmin(): bool
    {
        return $this->currentUser()->isAdmin();
    }

    protected function isConductor(): bool
    {
        return $this->currentUser()->isConductor();
    }

    protected function isUser(): bool
    {
        return $this->currentUser()->isUser();
    }
}
