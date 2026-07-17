<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property boolean $enabled
 * @property string $protocol
 * @property string $hostname
 * @property int $port
 * @property boolean $auth
 * @property string $username
 * @property string $password
 * @method static Builder enabled()
 */
class Proxy extends Model
{
    protected $fillable = [
        'enabled',
        'protocol',
        'hostname',
        'port',
        'auth',
        'username',
        'password',
    ];

    protected $casts = [
        'port' => 'integer',
        'enabled' => 'boolean',
        'auth' => 'boolean',
    ];

    public function maskedUrl(): string
    {
        $url = $this->toUrl();
        if ($this->auth) {
            $protocolLen = strlen($this->protocol) + 3;
            $authLen = strlen($this->username) + strlen($this->password) + 1;
            return substr_replace($url, str_repeat('*', 8), $protocolLen, $authLen);
        }
        return $url;
    }


    public function getHost(): string
    {
        return sprintf(
            '%s://%s:%d',
            $this->protocol,
            $this->hostname,
            $this->port
        );
    }

    public function getAuth(): string
    {
        return sprintf(
            '%s:%s',
            $this->username,
            $this->password,
        );
    }

    public function toUrl(): string
    {
        if (!$this->auth) {
            return sprintf(
                '%s://%s:%d',
                $this->protocol,
                $this->hostname,
                $this->port
            );
        }

        return sprintf(
            '%s://%s:%s@%s:%d',
            $this->protocol,
            $this->username,
            $this->password,
            $this->hostname,
            $this->port
        );
    }

    public function disable(): void
    {
        $this->enabled = false;
        $this->save();
    }

    public function scopeEnabled(Builder $query): Builder
    {
        return $query->where('enabled', true);
    }
}
