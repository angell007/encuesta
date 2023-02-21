export default {
  funcionario: {
    datosBasicos: {
      id: '',
      identidad: '',
      nombres: '',
      apellidos: '',
      liquidado: 0,
      fecha_nacimiento: '',
      lugar_nacimiento: '',
      tipo_sangre: 'A+',
      telefono: '',
      celular: '',
      email: '',
      direccion_residencia: '',
      estado_civil: 'Soltero(a)',
      grado_instruccion: 'Profesional',
      titulo_estudio: '',
      personId: '0',
      persistedFaceId: '0',
      bonos: '',
      numero_hijos: 0,
      sexo: 'Masculino',
    },
    informacionEmpresa: {
      tipo_contrato_id: '',
      centro_costo_id: '',
      dependencia_id: '',
      cargo_id: '',
      tipo_turno: 'Fijo',
      turno_fijo_id: '',
      jefe_id: '',
      fecha_ingreso: '',
      fecha_retiro: '',
      salario: '',
    },
    prestaciones: {
      eps_id: '',
      cesantias_id: '',
      pensiones_id: '',
      caja_compensacion_id: '',
    },
    dotacion: {
      talla_camisa: '',
      talla_pantalon: '',
      talla_botas: '',
    },
  },
  multiSelect: {
    prestaciones: {
      eps_id: '',
      cesantias_id: '',
      pensiones_id: '',
      caja_compensacion_id: '',
    },
    informacionEmpresa: {
      jefe_id: '',
      tipo_contrato_id: '',
      centro_costo_id: '',
      dependencia_id: '',
      cargo_id: '',
    },
  },
  datos: {
    estados: [
      { clave: 'Soltero(a)', valor: 'Soltero(a)' },
      { clave: 'Casado(a)', valor: 'Casado(a)' },
      { clave: 'Divorciado(a)', valor: 'Divorciado(a)' },
      { clave: 'Viudo(a)', valor: 'Viudo(a)' },
      { clave: 'Unión Libre(a)', valor: 'Unión Libre(a)' },
    ],
    instruccion: [
      { clave: 'Primaria', valor: 'Primaria' },
      { clave: 'Secundaria', valor: 'Secundaria' },
      { clave: 'Técnica', valor: 'Técnica' },
      { clave: 'Tecnológica', valor: 'Tecnológica' },
      { clave: 'Profesional', valor: 'Profesional' },
      { clave: 'Especialización', valor: 'Especialización' },
      { clave: 'Maestría', valor: 'Maestría' },
    ],

    tipoSangre: [
      { clave: 'A+', valor: 'A+' },
      { clave: 'A-', valor: 'A-' },
      { clave: 'B+', valor: 'B+' },
      { clave: 'B-', valor: 'B-' },
      { clave: 'O+', valor: 'O+' },
      { clave: 'O-', valor: 'O-' },
      { clave: 'AB+', valor: 'AB+' },
      { clave: 'AB-', valor: 'AB-' },
    ],

    tipoTurno: [
      { clave: 'Fijo', valor: 'Fijo' },
      { clave: 'Rotativo', valor: 'Rotativo' },
    ],

    tallaCamisa: [
      { clave: 'XS', valor: 'XS' },
      { clave: 'S', valor: 'S' },
      { clave: 'M', valor: 'M' },
      { clave: 'L', valor: 'L' },
      { clave: 'XL', valor: 'XL' },
      { clave: 'XXL', valor: 'XXL' },
    ],

    tallaPantalon: [
      { clave: '28', valor: '28' },
      { clave: '30', valor: '30' },
      { clave: '32', valor: '32' },
      { clave: '34', valor: '34' },
      { clave: '36', valor: '36' },
      { clave: '38', valor: '38' },
      { clave: '38', valor: '38' },
      { clave: '40', valor: '40' },
    ],

    tallaCalzado: [
      { clave: '35', valor: '35' },
      { clave: '36', valor: '36' },
      { clave: '37', valor: '37' },
      { clave: '38', valor: '38' },
      { clave: '39', valor: '39' },
      { clave: '40', valor: '40' },
      { clave: '41', valor: '41' },
      { clave: '42', valor: '42' },
      { clave: '43', valor: '43' },
      { clave: '44', valor: '44' },
      { clave: '45', valor: '45' },
    ],
  },
}