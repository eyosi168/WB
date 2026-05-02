<?php

namespace App\Policies;

use App\Models\Bureau;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BureauPolicy
{
   

public function viewAny(User $user): bool
{
    
    return $user->hasRole('super_admin');
}

public function view(User $user, $model): bool
{
    return $user->hasRole('super_admin');
}

public function create(User $user): bool
{
    return $user->hasRole('super_admin');
}


    public function update(User $user, Bureau $bureau): bool
    {
        return false;
    }

    
    public function delete(User $user, Bureau $bureau): bool
    {
        return false;
    }

  
    public function restore(User $user, Bureau $bureau): bool
    {
        return false;
    }

   
    public function forceDelete(User $user, Bureau $bureau): bool
    {
        return false;
    }
}
