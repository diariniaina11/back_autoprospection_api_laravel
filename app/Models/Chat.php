<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasUuids;

    protected $table = 'chats';

    protected $fillable = [
        'user_id',
        'prospect_id',
        'sender',
        'email',
        'message',
        'is_read',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_read'    => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * La colonne "email" contient un tableau JSON de messages.
     * Chaque élément est une string JSON encodée représentant un objet avec :
     *   - subject     : objet/sujet du message
     *   - mes         : contenu du message
     *   - sender_uuid : UUID de l'expéditeur
     *   - date        : timestamp (ms)
     *
     * Valeur brute : ["{ \"subject\":\"...\",\"mes\":\"...\",... }", ...]
     * Valeur retournée : [ ["subject" => "...", "mes" => "...", ...], ... ]
     */
    public function getEmailAttribute(?string $value): ?array
    {
        if ($value === null) {
            return null;
        }

        // Étape 1 : décode le tableau JSON principal
        $array = json_decode($value, true);

        if (!is_array($array)) {
            return null;
        }

        // Étape 2 : décode chaque élément (string JSON → tableau associatif)
        return array_map(function ($item) {
            if (is_string($item)) {
                $decoded = json_decode($item, true);
                return is_array($decoded) ? $decoded : ['raw' => $item];
            }
            // Si l'élément est déjà un tableau (Supabase peut parfois le faire)
            return $item;
        }, $array);
    }

}
