<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    use HasFactory;

    protected $table = 'paniers';
    protected $primaryKey = 'idPanier';

    protected $fillable = ['total', 'idClient'];

    // 🔗 Relations
    public function client() {
        return $this->belongsTo(Client::class, 'idClient');
    }
}
