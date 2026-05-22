<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'surname',
        'date_of_birth',
        'gender_id',
        'role_id',
        'permission_photos',
        'email',
        'phone_number',
        'password',
        'street_number',
        'zipcode',
        'city',
        'active',
        'shirt_number',
        'profile_photo_path'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function parent_per_children(){
        return $this->hasMany(ParentPerChild::class, 'child_id', 'id');
    }

    public function child_per_parents(){
        return $this->hasMany(ParentPerChild::class, 'parent_id', 'id');
    }

    public function carpools() {
        return $this->hasMany(Carpool::class);
    }

    public function carpool_people() {
        return $this->hasMany(CarpoolPerson::class);
    }

    public function person_per_tasks() {
        return $this->hasMany(PersonPerTask::class);
    }

    public function precenses() {
        return $this->hasMany(Presence::class);
    }

    public function training_per_matches() {
        return $this->hasMany(TrainingMatch::class);
    }

    public function gender() {
        return $this->belongsTo(Gender::class)->withDefault();
    }

    public function registrations() {
        return $this->hasMany(Registration::class);
    }

    public function clothing_per_players() {
        return $this->hasMany(ClothingPerPlayer::class);
    }

    public function role() {
        return $this->belongsTo(Role::class)->withDefault();
    }
    public function scopeSearchUser($query, $search = "%")
    {
        return $query
            ->where('email', 'like', "%{$search}%")
            ->orWhere('firstname', 'like', "%{$search}%")
            ->orWhere('surname', 'like', "%{$search}%");
    }
    public function scopeSearchParent($query, $search = "%")
    {
        return $query->whereHas('child_per_parents', function ($query) use ($search) {
            $query->whereHas('parent', function ($query) use ($search) {
                $query->where('firstname', 'like', '%' . $search . '%');
            });
        });
    }


}
