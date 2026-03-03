<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
 
class Wallet extends Model
{
    protected $fillable = [
        'user_id',
        'virtual_account',
        'balance',
        'encrypted_at'
    ];
 
    protected $casts = [
        'encrypted_at' => 'datetime',
    ];
 
    /**
     * Set virtual account dengan enkripsi AES-256
     */
    public function setVirtualAccountAttribute($value)
    {
        $this->attributes['virtual_account'] = Crypt::encryptString($value);
        $this->attributes['encrypted_at'] = now();
    }
 
    /**
     * Get virtual account dengan dekripsi
     */
    public function getVirtualAccountAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return null;
        }
    }
 
    /**
     * Set balance dengan enkripsi AES-256
     */
    public function setBalanceAttribute($value)
    {
        $this->attributes['balance'] = Crypt::encryptString($value);
    }
 
    /**
     * Get balance dengan dekripsi
     */
    public function getBalanceAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return 0;
        }
    }
 
    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
 
    /**
     * Get raw encrypted virtual account (untuk debugging)
     */
    public function getRawVirtualAccount()
    {
        return $this->attributes['virtual_account'] ?? null;
    }
 
    /**
     * Get raw encrypted balance (untuk debugging)
     */
    public function getRawBalance()
    {
        return $this->attributes['balance'] ?? null;
    }
}