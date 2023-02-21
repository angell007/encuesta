<?php

namespace App\Http\Libs\Nomina\Facades;

use App\Models\Funcionario;
use App\Models\NominaHorasExtras;
use App\Http\Libs\Nomina\Calculos\CalculoExtra;
use App\Models\ReporteExtras;
use App\Http\Libs\Nomina\PeriodoPago;

class NominaExtras extends PeriodoPago
{
    protected static $funcionario;

    /**
     * Settea la propiedad funcionario filtrando al funcionario que se pase por el parámetro $id,
     * retorna una nueva instancia de la clase 
     *
     * @param integer $id
     * @return NominaExtras
     */
    public static function extrasFuncionarioWithId($id)
    {
        self::$funcionario = Funcionario::with('cargo')->find($id);

        return new self;
    }

    /**
     * Obtiene los prefijos de la tabla nomina_horas_extras, filtra los reportes de horas extras que tenga
     * el funcionario entre el parámetro fecha de inicio y el de fecha de fin , obtiene su salario base 
     * y realiza el cálculo correspondiente con esos tres valores (Ver la clase Cálculo extras)
     * 
     * @param integer $fechaInicio
     * @param integer $fechaFin
     * @return Illuminate\Support\Facades\Collection
     */
    public function fromTo($fechaInicio, $fechaFin)
    {
        $prefijos = NominaHorasExtras::get(['prefijo'])->keyBy('prefijo')->keys();
        $reporteExtras =  ReporteExtras::where('funcionario_id', self::$funcionario->id)->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        $salarioPartial = Funcionario::with('contractultimate')->where('id', self::$funcionario->id)->firstOrFail();
        $salario = $salarioPartial->contractultimate->salario;

        $calculoExtras = new CalculoExtra($prefijos, $reporteExtras, $salario);
        $calculoExtras->calcularCantidadHoras();
        $calculoExtras->setHorasReportadas($calculoExtras->getCantidadHoras());
        $calculoExtras->setPorcentajes(
            NominaHorasExtras::enviarPorcentajes($calculoExtras->getPrefijos())
        );
        $calculoExtras->calcularTotalHoras();
        $calculoExtras->calcularValorTotalHoras();

        return $calculoExtras->crearColeccion();
    }
}
