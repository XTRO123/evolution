<?php

namespace EvolutionCMS\Models;

use EvolutionCMS\Traits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $internalKey
 * @property string $fullname
 * @property string $middle_name
 * @property string $last_name
 * @property int $role
 * @property string $email
 * @property string $phone
 * @property string $mobilephone
 * @property int $verified
 * @property int $blocked
 * @property int $blockeduntil
 * @property int $blockedafter
 * @property int $logincount
 * @property int $lastlogin
 * @property int $thislogin
 * @property int $failedlogincount
 * @property string $sessionid
 * @property int $dob
 * @property int $gender
 * @property string $country
 * @property string $street
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $fax
 * @property string $photo
 * @property string $comment
 * @property int $createdon
 * @property int $editedon
 *
 * Virtual
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @TODO : @property-read \Carbon\Carbon blockeduntil
 * @TODO : @property-read \Carbon\Carbon blockedafter
 */
class UserAttribute extends Model
{
    use Traits\Models\TimeMutator;

    const CREATED_AT = 'createdon';
    const UPDATED_AT = 'editedon';

    protected $dateFormat = 'U';

    protected $casts = [
        'internalKey' => 'int',
        'role' => 'int',
        'verified' => 'int',
        'blocked' => 'int',
        'blockeduntil' => 'int',
        'blockedafter' => 'int',
        'logincount' => 'int',
        'lastlogin' => 'int',
        'thislogin' => 'int',
        'failedlogincount' => 'int',
        'dob' => 'int',
        'gender' => 'int',
    ];

    protected $hidden = [
        'role',
    ];

    protected $attributes = [
        'role' => 0,
        'verified' => 1,
    ];

    protected $fillable = [
        'internalKey',
        'fullname',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'mobilephone',
        'verified',
        'blocked',
        'blockeduntil',
        'blockedafter',
        'logincount',
        'lastlogin',
        'thislogin',
        'failedlogincount',
        'sessionid',
        'dob',
        'gender',
        'country',
        'street',
        'city',
        'state',
        'zip',
        'fax',
        'photo',
        'comment',
    ];

    public function getCreatedAtAttribute(): ?Carbon
    {
        return $this->convertTimestamp($this->createdon);
    }

    public function getUpdatedAtAttribute(): ?Carbon
    {
        return $this->convertTimestamp($this->editedon);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'internalKey', 'id');
    }
}
