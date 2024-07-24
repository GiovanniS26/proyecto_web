<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('lead_statuses')->insert([
            ['name' => 'Nuevo', 'description' => 'El lead acaba de ser ingresado al sistema y no ha sido contactado todavía.'],
            ['name' => 'Contactado', 'description' => 'El lead ha sido contactado, pero no ha respondido aún o está pendiente de seguimiento.'],
            ['name' => 'Interesado', 'description' => 'El lead ha mostrado interés en el producto o servicio y está dispuesto a recibir más información.'],
            ['name' => 'Calificado', 'description' => 'El lead ha sido evaluado y calificado como un cliente potencial con posibilidades de conversión altas.'],
            ['name' => 'No Calificado', 'description' => 'El lead ha sido evaluado y no cumple con los criterios necesarios para ser considerado un cliente potencial.'],
            ['name' => 'En Proceso', 'description' => 'El lead está en un proceso activo de negociación o demostración.'],
            ['name' => 'Propuesta Enviada', 'description' => 'Se ha enviado una propuesta formal al lead.'],
            ['name' => 'Negociación', 'description' => 'Se está negociando con el lead sobre los términos de la propuesta.'],
            ['name' => 'Cerrado (Ganado)', 'description' => 'El lead ha aceptado la propuesta y se ha convertido en cliente.'],
            ['name' => 'Cerrado (Perdido)', 'description' => 'El lead no ha aceptado la propuesta y no se ha convertido en cliente.'],
            ['name' => 'No Interesado', 'description' => 'El lead ha indicado que no está interesado en el producto o servicio.'],
            ['name' => 'Recontactar Más Tarde', 'description' => 'El lead ha pedido ser contactado en una fecha futura.'],
            ['name' => 'Referido', 'description' => 'El lead ha sido referido a otra persona o departamento.'],
            ['name' => 'Sin Respuesta', 'description' => 'No se ha podido contactar al lead después de varios intentos.'],
            ['name' => 'Duplicado', 'description' => 'El lead ya existe en el sistema y ha sido marcado como un duplicado.'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
