<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ResetDatabase extends Seeder
{
    public static function resetDatabase()
    {
        $sql = "
            DO $$ DECLARE
                table_record RECORD;
            BEGIN
                FOR table_record IN
                    SELECT table_name FROM information_schema.tables WHERE table_schema = 'public' AND table_type = 'BASE TABLE'
                    AND table_name NOT IN ('matiere','semestre','matiere_semestre')
                LOOP
                    EXECUTE format('TRUNCATE TABLE %I RESTART IDENTITY CASCADE', table_record.table_name);
                END LOOP;
            END $$;
        ";
        DB::statement($sql);
          $user = User::create([
            'nom' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'is_admin' => true
        ]);
        
    }
}
