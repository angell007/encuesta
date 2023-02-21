<?php

namespace App\Http\Libs\Nomina\Calculos;

use App\Clases\PorcentajeInstance;
use App\Clases\stdObject;
use App\Models\ContableLicenciaIncapacidad;
use App\Models\EmpresaConfiguracion;
use App\Models\Novedad;
use Illuminate\Support\Collection;
use Carbon\Carbon;

/**
 * Clase para el cálculo de novedades en un determinado periodo
 */
class CalculoNovedades implements Coleccion
{
    private $dias = 0;
    private $salarioPromedio;
    private $novedadesRegistradas = [];
    private $totalesNovedad = [];
    private $valorTotal;
    private $inicioPeriodo;
    private $finPeriodo;
    private const PERIODO_CONTABLE = 30; // Dias


    /**
     * Constructor
     *
     * @param int $salarioPromedio
     * @param string $inicioPeriodo
     * @param string $finPeriodo
     */
    public function __construct($salarioPromedio, $inicioPeriodo, $finPeriodo)
    {
        $this->salarioPromedio = $salarioPromedio;
        $this->inicioPeriodo = new Carbon($inicioPeriodo);
        $this->finPeriodo = new Carbon($finPeriodo);
    }

    /**
     * Obtener total de días de novedades en el periodo, ya sean vacaciones, licencias, etc.
     * Teniendo en cuenta esto para restarlo a los días trabajados
     *
     * @return int
     */
    public function getDias()
    {

        return $this->dias;
    }

    /**
     * Retorna el salario promedio de un funcionario, esto viene de la BD
     *
     * @return int
     */
    public function getSalarioPromedio()
    {
        return $this->salarioPromedio;
    }

    /**
     * Registra una novedad en el container (Array) por clave - valor
     *
     * @param String $llave
     * @param int $valor
     * @return void
     */
    public function registrarNovedad($llave, $valor)
    {
        $this->novedadesRegistradas[$llave] = $valor;
    }

    /**
     * Retorna el container con las novedades registradas
     *
     * @return Array
     */
    public function getNovedades()
    {
        return $this->novedadesRegistradas;
    }


    /**
     * Getter totales novedad
     *
     * @return Array
     */
    public function getTotalesNovedad()
    {
        return $this->totalesNovedad;
    }

    /**
     * Getter valor total todas las novedades
     *
     * @return int
     */
    public function getValorTotal()
    {
        return $this->valorTotal;
    }

    /**
     * Si exsiten vacaciones, entonces registrarlas con el método indicado
     *
     * @param Collection $vacaciones
     * @return void
     */
    public function existenVacaciones(Collection $vacaciones)
    {
        if ($vacaciones->isNotEmpty()) {
            $this->registroMasivoNovedades($vacaciones);
        }
    }

    /**
     * Registrar masivamente novedades, si ya existen en el container, simplemente se aumentan los días correspondientes de esa novedad, válido únicamente para vacaciones
     *
     * @param Collection $novedades
     * @return void
     */
    private function registroMasivoNovedades(Collection $novedades)
    {

        //Se utiliza en caso de que el concepto de la novedad ya esté en el array de novedadesRegistradas, únicamente para las vacaciones actualmente
        $diferenciaTemporal = 0;
        $novedades->each(function ($novedad) use (&$diferenciaTemporal) {


            $fechaInicio = new Carbon($novedad->fecha_inicio);
            $fechaFin = new Carbon($novedad->fecha_fin);
            $diferencia = $fechaFin->diffInDays($fechaInicio) + 1;

            if (collect($this->novedadesRegistradas)->has($novedad->novedad->concepto)) {
                $diferenciaTemporal = $this->novedadesRegistradas[$novedad->novedad->concepto];
                $diferencia += $diferenciaTemporal;
            }


            $this->registrarNovedad($novedad->novedad->concepto, $diferencia);
            $this->dias += $diferencia - $diferenciaTemporal;
        });
    }



    /**
     * Comprobar que las fechas de los periodos coincidan con las de las novedades
     *
     * @param String $fechaInicio
     * @param String $fechaFin
     * @return Boolean
     */
    private function comprobarCondiciones($fechaInicio, $fechaFin)
    {
        //Que la fecha del inicio de periodo de pago sea mayor/igual a la fecha de inicio de la novedad, o si es menor, que estén ambas en el mismo mes, por último que la fecha de inicio de periodo de pago sea menor/igual a la fecha final de la novedad (por si acaso....)
        $condicionUno = $this->inicioPeriodo->greaterThanOrEqualTo($fechaInicio) || ($this->inicioPeriodo->lessThan($fechaInicio) && $this->inicioPeriodo->isSameMonth($fechaInicio)) && $this->inicioPeriodo->lessThanOrEqualTo($fechaFin);

        //Que la fecha del fin de periodo de pago sea mayor/igual a la fecha de inicio de la novedad (por si acaso..), y que la fecha del fin de periodo de pago sea menor/igual a la fecha final de la novedad, o si es mayor, que estén ambas en el mismo mes.
        $condicionDos = $this->finPeriodo->greaterThanOrEqualTo($fechaInicio) &&
            $this->finPeriodo->lessThanOrEqualTo($fechaFin) || ($this->finPeriodo->greaterThan($fechaFin) && $this->finPeriodo->isSameMonth($fechaFin));

        if ($condicionUno && $condicionDos) {
            return true;
        }
        return false;
    }

    /**
     * Comprobar si existen las novedades y realizar operaciones (leer internamente el método)
     *
     * @param Collection $novedades
     * @return void
     */
    public function existenNovedades(Collection $novedades)
    {
        if ($novedades->isNotEmpty()) {
            //Se usa en caso de que el concepto de la novedad ya esté en el array de novedadesRegistradas
            $diferenciaTemporal = 0;
            $novedades->each(function ($novedad) use (&$diferenciaTemporal) {

                $fechaInicio = new Carbon($novedad->fecha_inicio);
                $fechaFin = new Carbon($novedad->fecha_fin);

                if ($this->comprobarCondiciones($fechaInicio, $fechaFin)) {
                    $dias = $this->inicioPeriodo->diffInDays($this->finPeriodo) + 1;
                    //Febrero
                    $dias = (($dias > 15 && $dias < 30) || $dias > 30) ? 30 : $dias;

                    //Si la novedad está en el mismo mes, descartar automáticamente demás opciones y asignar los dias iguales a la diferencia

                    if ($fechaInicio->isSameMonth($fechaFin)) {
                        $diferencia = $fechaFin->diffInDays($fechaInicio) + 1;
                        $dias = $diferencia;
                    } else if ($this->inicioPeriodo->lessThan($fechaInicio) && $this->inicioPeriodo->isSameMonth($fechaInicio)) {
                        $diferencia = $fechaInicio->diffInDays($this->inicioPeriodo);
                        $dias -= $diferencia;
                    } else if ($this->finPeriodo->greaterThan($fechaFin) && $this->finPeriodo->isSameMonth($fechaFin)) {
                        $diferencia = $fechaFin->diffInDays($this->inicioPeriodo) + 1;
                        $dias = $diferencia;
                    }

                    //Si ya existe el concepto de la novedad en el array novedadesRegistradas, entonces solo se suma a la que existe los días de la entrante, ej: suspensión => 2 días, suspensión => 1 día igual a suspensión => 3 días
                    if (collect($this->novedadesRegistradas)->has($novedad->novedad->concepto)) {
                        $diferenciaTemporal = $this->novedadesRegistradas[$novedad->novedad->concepto];
                        $dias += $diferenciaTemporal;
                    }

                    $this->registrarNovedad($novedad->novedad->concepto, $dias);
                    $this->dias += $dias - $diferenciaTemporal;
                }
            });
        }
    }

    /**
     * Calcular el valor total de cada novedad
     *
     * @return int
     */
    public function totalizarNovedad()
    {

        $configuracion = EmpresaConfiguracion::with('porcentaje:id,valor')->exclude(['created_at', 'updated_at'])->first();

        foreach ($this->getNovedades() as $novedad => $dias) {

            $auxtNovedad =   ContableLicenciaIncapacidad::firstWhere('concepto', $novedad);

            $objeParams = new stdObject();
            $objeParams->salario = $this->salarioPromedio;
            $objeParams->dias = $dias;
            $objeParams->periodo = self::PERIODO_CONTABLE;
            $objeParams->porcentaje = $configuracion->porcentaje->id;
            $objeParams->novedad = $auxtNovedad;
            $porcentajeInstance =  new PorcentajeInstance($objeParams);

            $instance =  $porcentajeInstance->getSalario();

            if ($auxtNovedad->suma) {
                $this->totalesNovedad[$novedad]  = -$instance->calculateIngresoDeIncapacidad();
            } else {
                $this->totalesNovedad[$novedad]  = $instance->calculateIngresoDeIncapacidad();
            }
        }

        return $this;
    }

    /**
     * Calcular el valor total de todas las novedades
     *
     * @return int
     */
    public function calcularValorTotal()
    {

        $this->valorTotal =  collect($this->getTotalesNovedad())->values()->sum();
    }

    /** 
     * Aplicar el contract de la interfaz, crear la colección 
     *  
     * @return Illuminate\Support\Collection
     * 
     * */
    public function crearColeccion()
    {
        return new Collection([
            'total_dias' => $this->getDias(),
            'novedades' => $this->getNovedades(),
            'novedades_totales' => $this->getTotalesNovedad(),
            'valor_total' => $this->getValorTotal()
        ]);
    }
}
