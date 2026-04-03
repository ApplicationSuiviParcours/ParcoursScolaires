<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'photo_url' => $this->photo_url,
            'initials' => $this->initials,
            'role_names' => $this->role_names,
            'is_admin' => $this->is_admin,
            'is_enseignant' => $this->is_enseignant,
            'is_parent' => $this->is_parent,
            'is_eleve' => $this->is_eleve,
'profile_type' => $this->profile_type,
            'role' => $this->profile_type ?? $this->primary_role,
            'profile' => $this->profile, // Nested eleve/parent/enseignant data
            'last_login_at' => $this->last_login_at,
            'is_active' => $this->is_active,
        ];
    }
}