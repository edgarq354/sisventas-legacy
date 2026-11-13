<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cobro con QR de Banco FIE en Nota de Venta.
     */
    public function up(): void
    {
        Schema::table('empresa', function (Blueprint $table) {
            if (!Schema::hasColumn('empresa', 'bancofie_id_servicio')) {
                $table->integer('bancofie_id_servicio')->nullable()->after('bancofie_token_expira');
            }
            if (!Schema::hasColumn('empresa', 'bancofie_callback')) {
                $table->string('bancofie_callback', 191)->nullable()->after('bancofie_id_servicio');
            }
        });

        Schema::table('nota_venta', function (Blueprint $table) {
            if (!Schema::hasColumn('nota_venta', 'id_transaccion_qr')) {
                $table->unsignedBigInteger('id_transaccion_qr')->nullable()->after('id_empresa');
                $table->index('id_transaccion_qr', 'idx_nota_venta_id_transaccion_qr');
            }
        });

        if (!Schema::hasTable('transaccion_qr_bancofie')) {
            Schema::create('transaccion_qr_bancofie', function (Blueprint $table) {
                $table->unsignedBigInteger('id_transaccion')->primary();
                $table->string('id_qr', 60)->nullable();
                $table->integer('id_empresa')->nullable()->index('idx_tqb_empresa');
                $table->integer('id_nota_venta')->nullable()->index('idx_tqb_nota_venta');
                $table->integer('id_usuario_registro')->nullable();
                $table->string('origen', 20)->default('NOTA_VENTA');
                $table->string('alias', 150)->nullable();
                $table->string('detalle_glosa', 255)->nullable();
                $table->string('moneda', 5)->default('BOB');
                $table->decimal('monto', 10, 2)->nullable();
                $table->integer('id_servicio')->nullable();
                $table->string('banco_destino', 100)->nullable();
                $table->string('cuenta_destino', 30)->nullable();
                $table->date('fecha_vencimiento')->nullable();
                $table->string('estado_pago', 20)->default('PENDIENTE');
                $table->string('cliente_ref', 30)->nullable();
                $table->dateTime('fecha_alta')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->dateTime('fecha_pago')->nullable();
                $table->dateTime('fecha_verificacion')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('transaccion_qr_bancofie');

        Schema::table('nota_venta', function (Blueprint $table) {
            if (Schema::hasColumn('nota_venta', 'id_transaccion_qr')) {
                $table->dropIndex('idx_nota_venta_id_transaccion_qr');
                $table->dropColumn('id_transaccion_qr');
            }
        });

        Schema::table('empresa', function (Blueprint $table) {
            $table->dropColumn(['bancofie_id_servicio', 'bancofie_callback']);
        });
    }
};
