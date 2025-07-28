<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Crypt;


trait HasEncryptedId
{
    public function getEncryptedIdAttribute()
    {
        return Crypt::encryptString($this->getKey());
    }

    public function resolveRouteBinding($value, $field = null)
    {
        if (request()->routeIs('terrace.courses.show')) {
            return $this->where('slug', $value)->firstOrFail();
        }

        try {
            $decryptedId = Crypt::decryptString($value);
            return $this->findOrFail($decryptedId);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404);
        }
    }
}
