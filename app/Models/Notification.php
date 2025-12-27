<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $primaryKey = 'idNotification';
    public $timestamps = false;

    protected $fillable = [
        'contenu', 'dateNotif', 'lue', 'idUtilisateur'
    ];

    // 🔗 Relations
    public function utilisateur() {
        return $this->belongsTo(Utilisateur::class, 'idUtilisateur');
    }
}
