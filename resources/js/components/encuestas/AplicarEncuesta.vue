<template>
  <div v-if="mostrar">
    <div class="container" v-if="!encuesta_aplicada">
      <div
        class="row"
        style="padding-top: 15px; background: #ffffff; padding-bottom: 15px"
      >
        <div class="col-6 text-center">
          <h2 style="margin-top: 15px">{{ empresa }}</h2>
        </div>
        <div class="col-6 text-center">
          <img alt="" src="/img/cliente.png" class="logo-cliente" />
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <h4 class="font-weight-bold text-warning" style="margin-top: 25px">
            Hola, {{ funcionario }}
          </h4>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <h2 class="font-weight-bold text-primary" style="margin-top: 25px">
            {{ encuesta.nombre }}
          </h2>
          <p style="font-size: 1.5em">{{ encuesta.descripcion }}</p>
          <div class="separator mb-5"></div>
        </div>
      </div>
      <form @submit.prevent="validarAntesDeEnviar">
        <div
          class="row mb-2"
          v-for="(pregunta, index) in encuesta.preguntas"
          :key="`${index}-pregunta`"
        >
          <div class="col-12">
            <div class="card">
              <div class="card-title m-2">
                <h4 class="text-primary">{{ pregunta.pregunta }}</h4>
              </div>
              <div
                class="card-body p-2"
                v-if="pregunta.tipo_pregunta == 'simple'"
              >
                <div class="row">
                  <div class="col-6 text-center">
                    <input
                      type="radio"
                      value="si"
                      v-validate="'required'"
                      :name="`${index}-respuesta`"
                      v-model="encuesta.preguntas[index].respuesta"
                    />
                    <label for="uno">Si</label>
                  </div>
                  <div class="col-6 text-center">
                    <input
                      type="radio"
                      value="no"
                      v-validate="'required'"
                      :name="`${index}-respuesta`"
                      v-model="encuesta.preguntas[index].respuesta"
                    />
                    <label for="Dos">No</label>
                  </div>
                  <div class="col-12 text-center">
                    <small
                      class="invalid"
                      :v-if="errors.has('`${index}-respuesta`')"
                      >{{
                        errors.first(index + "-respuesta")
                          ? errors
                              .first(index + "-respuesta")
                              .replace(index + "-", "")
                          : ""
                      }}</small
                    >
                  </div>
                </div>
              </div>
              <div
                class="card-body p-2"
                v-if="pregunta.tipo_pregunta == 'simple-dos'"
              >
                <div class="row">
                  <div class="col-12 text-center">
                    <multiselect
                      :max-height="200"
                      :name="`${index}-respuesta`"
                      placeholder="Seleccione una opci??n"
                      selectLabel="Enter para seleccionar"
                      deselectLabel="Enter para remover"
                      v-validate="'required'"
                      data-vv-as="respuesta"
                      v-model="encuesta.preguntas[index].respuesta"
                      :options="encuesta.preguntas[index].opciones"
                      class="font-weight-bold"
                      label="opcion"
                      track-by="opcion"
                    >
                      <template slot="noOptions">La lista est?? vac??a</template>
                      <template slot="noResult"
                        >No existen resultados!</template
                      >
                    </multiselect>
                    <small
                      class="invalid"
                      :v-if="errors.has('`${index}-respuesta`')"
                      >{{
                        errors.first(index + "-respuesta")
                          ? errors
                              .first(index + "-respuesta")
                              .replace(index + "-", "")
                          : ""
                      }}</small
                    >
                  </div>
                </div>
              </div>
              <div
                class="card-body p-2"
                v-if="pregunta.tipo_pregunta == 'multiple'"
              >
                <div class="row">
                  <div class="col-12 d-flex justify-content-center">
                    <article
                      class="feature1 text-center"
                      v-for="(emoji, i) in encuesta.preguntas[index].opciones"
                      :key="i"
                    >
                      <input
                        type="radio"
                        id="feature"
                        :name="`${index}-respuesta`"
                        :hide-selected="true"
                        data-vv-as="respuesta"
                        v-validate="'required'"
                        v-on:click="fill(emoji, index)"
                      />
                      <div>
                        {{ emoji.opcion }}
                      </div>
                    </article>
                    <!-- <multiselect
                      :multiple="true"
                      :max-height="200"
                      :name="`${index}-respuesta`"
                      placeholder="Seleccione una opci??n"
                      selectLabel="Enter para seleccionar"
                      deselectLabel="Enter para remover"
                      v-validate="''"
                      data-vv-as="respuesta"
                      v-model="encuesta.preguntas[index].respuesta"
                      :options="encuesta.preguntas[index].opciones"
                      class="font-weight-bold"
                      label="opcion"
                      track-by="opcion"
                      :hide-selected="true"
                    >
                      <template slot="noOptions">La lista est?? vac??a</template>
                      <template slot="noResult"
                        >No existen resultados!</template
                      >
                    </multiselect> -->
                    <!-- <small
                      class="invalid"
                      :v-if="errors.has('`${index}-respuesta`')"
                      >{{
                        errors.first(index + "-respuesta")
                          ? errors
                              .first(index + "-respuesta")
                              .replace(index + "-", "")
                          : ""
                      }}</small
                    > -->
                  </div>
                </div>
              </div>
              <div
                class="card-body p-2"
                v-if="pregunta.tipo_pregunta == 'respuesta-corta'"
              >
                <div class="row">
                  <div class="col-12 text-center">
                    <input
                      type="text"
                      class="form-control custom-control"
                      :name="`${index}-respuesta`"
                      v-validate="'required|min:3'"
                      data-vv-as="respuesta"
                      placeholder="Respuesta Corta"
                      v-model="encuesta.preguntas[index].respuesta"
                    />
                    <small
                      class="invalid"
                      :v-if="errors.has('`${index}-respuesta`')"
                      >{{
                        errors.first(index + "-respuesta")
                          ? errors
                              .first(index + "-respuesta")
                              .replace(index + "-", "")
                          : ""
                      }}</small
                    >
                  </div>
                </div>
              </div>
              <div
                class="card-body p-2"
                v-if="pregunta.tipo_pregunta == 'respuesta-larga'"
              >
                <div class="row">
                  <div class="col-12 text-center">
                    <textarea
                      type="text"
                      class="form-control"
                      :name="`${index}-respuesta`"
                      v-validate="'required|min:10'"
                      data-vv-as="respuesta"
                      placeholder="Respuesta Larga"
                      v-model="encuesta.preguntas[index].respuesta"
                      rows="3"
                    ></textarea>
                    <small
                      class="invalid"
                      :v-if="errors.has('`${index}-respuesta`')"
                      >{{
                        errors.first(index + "-respuesta")
                          ? errors
                              .first(index + "-respuesta")
                              .replace(index + "-", "")
                          : ""
                      }}</small
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-12">
            <small class="invalid" :v-if="errors.has('terminos')">{{
              errors.first("terminos")
                ? "Debe Aceptar los T??rminos y Condiciones"
                : ""
            }}</small>
            <p>
              <!-- <input
                type="checkbox"
                v-validate="'required'"
                checked
                name="terminos"
                value="acepto"
                v-model="encuesta.acepto_terminos"
              />
              Yo {{ funcionario }} identificado con c??dula de ciudadan??a
              {{ funcionario_identidad }} {{ encuesta.terminos }} -->
            </p>
          </div>
        </div>

        <div class="form-group" style="margin-top: 20px">
          <button
            type="submit"
            class="btn btn-secondary raised btn-sm btn-block"
          >
            Guardar
          </button>
        </div>
      </form>
    </div>
    <div class="container" v-else>
      <div
        class="row"
        style="padding-top: 15px; background: #ffffff; padding-bottom: 15px"
      >
        <div class="col-6 text-center">
          <h2 style="margin-top: 15px">{{ empresa }}</h2>
        </div>
        <div class="col-6 text-center">
          <img alt="" src="/img/cliente.png" class="logo-cliente" />
        </div>
      </div>
      <div class="row mt-4 mb-2">
        <div class="col-12" v-if="error">
          <div class="card">
            <div class="card-title m-2">
              <h3 class="text-primary text-center">Error del Documento</h3>
            </div>
            <div class="card-body p-2 text-center">
              <img alt="" src="/img/robot.jpg" />
              <h5>
                La encuesta a la que est??s intentando acceder ya fu?? realizada,
                o est?? sin vigencia; por favor contacta al departamento de
                <strong>Recursos Humanos</strong> de tu compa????a
              </h5>
            </div>
          </div>
        </div>
        <div class="col-12" v-if="!error">
          <div class="card">
            <div class="card-title m-2">
              <h3 class="text-primary text-center">
                Gracias por Diligenciar la Encuesta
              </h3>
            </div>
            <div class="card-body p-2 text-center" v-if="novedad">
              <img alt="" src="/img/peligro.png" />
              <h5>
                Alguna de las respuestas suministradas puede significar alg??n
                <strong>riesgo</strong> para la salud tuya o tus compa??eros,
                espera en los pr??ximos minutos la comunicaci??n del departamento
                <strong>Recursos Humanos</strong> para autorizar tu ingreso a
                las instalaciones o las medidas pertinentes.
              </h5>
              <br />
              <img alt="" src="/img/prevencion-covid.png" />
              <h5>
                Recuerda Lavarte las manos con frecuencia, usar el tapabocas
                desde que sales de casa y mantener distancia social de m??s de 1
                metro.
              </h5>
            </div>
            <div class="card-body p-2 text-center" v-else>
              <img alt="" src="/img/ok.png" />
              <h5>
                Gracias por cumplir los
                <strong>Protocolos de Bioseguridad</strong> de nuestra compa????a,
                te esperamos en nuestras instalaciones para que sigas dando tu
                mejor esfuerzo para que juntos salgamos adelante.
              </h5>
              <br />
              <img alt="" src="/img/prevencion-covid.png" />
              <h5>
                Recuerda Lavarte las manos con frecuencia, usar el tapabocas
                desde que sales de casa y mantener distancia social de m??s de 1
                metro.
              </h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      funcionario: "",
      encuesta: {},
      empresa: "",
      funcionario_identidad: "",
      funcionario_id: "",
      encuesta_id: "",
      encuesta_aplicada: false,
      fecha: "",
      mostrar: false,
      error: true,
      novedad: false,
      response: null,
    };
  },
  created() {
    //
    var id = atob(this.$route.params.id);
    var dos = id.split(",");
    this.funcionario_identidad = dos[1];
    this.encuesta_id = dos[0];
    this.fecha = dos[2];
    this.obtenerDatosEmpresa();
    this.obtenerFuncionario(this.funcionario_identidad);
    this.obtenerEncuesta(this.encuesta_id);
  },
  methods: {
    fill(res, index) {
      this.encuesta.preguntas[index].respuesta = res.id;
    },
    obtenerFuncionario(identidad) {
      // axios
      //   .get(
      //     `/api/${localStorage.getItem(
      //       "tenant"
      //     )}/funcionarios/${identidad}/mostrar`
      //   )
      //   .then((datos) => {
      //     this.funcionario = datos.data.nombres + " " + datos.data.apellidos;
      //     this.funcionario_id = datos.data.id;
      this.validarEncuesta();
      // });
    },

    obtenerDatosEmpresa() {
      // axios.get(`/api/general/empresa/global`).then((datos) => {
      this.empresa = "Empresa";
      // });
    },
    obtenerEncuesta(id) {
      axios.get(`/api/encuestas/${id}/mostrar`).then((datos) => {
        this.encuesta = datos.data;
      });
    },
    validarEncuesta() {
      axios
        .get(`/api/encuestas/${this.encuesta_id}/${this.fecha}/validar`)
        .then((datos) => {
          this.encuesta_aplicada = datos.data;
          this.mostrar = true;
        });
    },
    async validarAntesDeEnviar() {
      let validado = await this.$validator.validateAll();
      if (validado) {
        this.GuardarEncuesta();
        return;
      }
      this.$swal.fire(
        "Error!",
        "Debe corregir los errores antes de enviar",
        "error"
      );
    },
    GuardarEncuesta() {
      this.encuesta["funcionario_id"] = this.funcionario_id;
      axios
        .post(`/api/encuestas/responder`, this.encuesta)
        .then((respuesta) => {
          this.$swal.fire("Correcto", respuesta.data.message, "success");
          this.encuesta_aplicada = true;
          this.error = false;
          this.novedad = respuesta.data.novedad;
          this.$router.push("/ed");
        })
        .catch((error) => {
          this.catchErrorServidor(error);
        });
    },
  },
};
</script>

<style>
/* .multiselect .multiselect__tags {
  height: auto !important;
  line-height: 14px;
}
.multiselect__tag {
  margin-right: 5px;
  margin-bottom: 0px;
} */

article {
  font-size: 5em;
  position: relative;
  width: 140px;
  height: 100px;
  margin: 5px;
  float: left;
  /* border: 2px solid #50bcf2; */
  box-sizing: border-box;
}

article div {
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  line-height: 25px;
  transition: 0.5s ease;
}

article input {
  position: absolute;
  top: 0;
  left: 0;
  width: 140px;
  height: 100px;
  opacity: 0;
  cursor: pointer;
}

input[type="radio"]:checked ~ div {
  background-color: #50bcf2;
}

@keyframes slidein {
  from {
    margin-top: 100%;
    width: 300%;
  }

  to {
    margin: 0%;
    width: 100%;
  }
}

/* .multiselect .multiselect__tags {
  height: auto !important;
  line-height: 14px;
}
.multiselect__tag {
  margin-right: 5px;
  margin-bottom: 0px;
} */
</style>
