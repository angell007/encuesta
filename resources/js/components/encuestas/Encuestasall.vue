<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="my-3">
          <h1 class="font-weight-bold">Encuestas Aplicables</h1>
        </div>
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <div class="mb-2">
              <a
                class="btn pt-0 pl-0 d-inline-block d-md-none"
                data-toggle="collapse"
                href="#displayOptions"
                role="button"
                aria-expanded="true"
                aria-controls="displayOptions"
              >
                Mostrar Opciones
                <i class="simple-icon-arrow-down align-middle"></i>
              </a>
              <div class="collapse d-md-block" id="displayOptions">
                <div class="d-block d-md-inline-block">
                  <div
                    class="
                      search-sm
                      d-inline-block
                      float-md-left
                      mr-1
                      mb-1
                      align-top
                    "
                  >
                    <input placeholder="Buscar..." v-model="buscador" />
                  </div>
                </div>
                <div class="float-md-right" style="margin-right: 1rem">
                  <span class="text-muted text-small"
                    >Cantidad de Encuestas Creadas:
                    {{ encuestasDatos.length }}</span
                  >
                </div>
              </div>
            </div>
            <div class="separator mb-5"></div>
          </div>
        </div>

        <div class="row" v-if="encuestasDatos.length">
          <div class="col-md-12">
            <table
              role="grid"
              class="table table-sm table-bordered table-striped"
            >
              <thead class="bg-light">
                <tr>
                  <th>Nombre</th>
                  <!-- <th class="text-center">Tipo Aplicaci??n</th> -->
                  <th class="text-center">Frecuencia Aplicaci??n</th>
                  <!-- <th class="text-center">Restrictiva</th> -->
                  <th class="text-center">Estado</th>
                  <th class="text-center" style="width: 125px !important">
                    Acciones
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(encuesta, index) in encuestasDatos"
                  :key="index"
                  v-bind:class="[encuesta.estado]"
                >
                  <td class="">{{ encuesta.nombre }}</td>
                  <!-- <td class="text-center">{{ encuesta.tipo_aplicacion }}</td> -->
                  <td class="text-center">
                    {{ encuesta.frecuencia_aplicacion }}
                  </td>
                  <!-- <td class="text-center">{{ encuesta.restrictiva }}</td> -->
                  <td class="text-center">{{ encuesta.estado }}</td>
                  <td class="text-center">
                    <a
                      title="Llenar encuesta"
                      href
                      @click.prevent="redireccionar(encuesta.link)"
                      class="table-icon"
                    >
                      <i class="simple-icon-pencil"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="alert alert-secondary" v-else>
          <p class="font-weight-bold text-center">
            No existen encuestas actualmente, para empezar a agregarlas vaya a
            la opci??n "Nueva Encuesta" en la parte superior derecha
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      encuestasDatos: [],
      encuestasDatosBuscador: [],
      buscador: "",
    };
  },
  mounted() {
    this.cargarEncuestas();
  },
  methods: {
    redireccionar(id) {
      this.$router.push({
        name: "ae",
        params: { id: id },
      });
    },
    cargarEncuestas() {
      axios.get(`/api/encuestas/datos/public`).then((datos) => {
        this.encuestasDatos = this.encuestasDatosBuscador = datos.data;
      });
    },
  },
  watch: {
    buscador() {
      let dp = null;
      if (this.buscador !== null || this.buscador.length > 0) {
        dp = this.encuestasDatosBuscador.filter((encuesta) => {
          return (
            encuesta.nombre.toLowerCase().indexOf(this.buscador.toLowerCase()) >
            -1
          );
        });
      } else {
        this.encuestasDatos = this.encuestasDatosBuscador;
      }
      this.encuestasDatos = dp;
    },
  },
};
</script>
<style scoped>
.table tr td {
  text-transform: uppercase;
}
.Inactiva {
  background-color: #dc3545 !important;
  color: #ffffff !important;
}
.Inactiva a {
  color: #ffffff !important;
}
</style>
