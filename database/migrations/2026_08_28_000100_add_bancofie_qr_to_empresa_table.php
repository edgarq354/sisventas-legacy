<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pago QR - Banco FIE.
     */
    public function up(): void
    {
        Schema::table('empresa', function (Blueprint $table) {
            if (!Schema::hasColumn('empresa', 'pago_qr_bancofie')) {
                $table->tinyInteger('pago_qr_bancofie')->default(0)->after('comentario_recibo');
            }
            if (!Schema::hasColumn('empresa', 'bancofie_usuario')) {
                $table->string('bancofie_usuario', 191)->nullable()->after('pago_qr_bancofie');
            }
            if (!Schema::hasColumn('empresa', 'bancofie_password')) {
                $table->text('bancofie_password')->nullable()->after('bancofie_usuario');
            }
            if (!Schema::hasColumn('empresa', 'bancofie_token')) {
                $table->text('bancofie_token')->nullable()->after('bancofie_password');
            }
            if (!Schema::hasColumn('empresa', 'bancofie_token_expira')) {
                $table->dateTime('bancofie_token_expira')->nullable()->after('bancofie_token');
            }
        });
    }

    public function down(): void
    {
        Schema::table('empresa', function (Blueprint $table) {
            $table->dropColumn([
                'pago_qr_bancofie',
                'bancofie_usuario',
                'bancofie_password',
                'bancofie_token',
                'bancofie_token_expira',
            ]);
        });
    }
};
