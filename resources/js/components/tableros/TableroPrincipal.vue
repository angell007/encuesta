<template>
  <div>
    <div class="container" v-if="renderizarTablero">
      <EncuestasPrincipal></EncuestasPrincipal>
      <!-- <div> -->
      <!-- <div class="row">
          <div class="col-12">
            <h3>
              {{ Titulo }}
              <br />
              <span class="frase" ref="elementPassword">{{ Frase.frase }}</span>
              <em class="autor">- {{ Frase.autor }}</em>
            </h3>
            <div class="separator mb-5"></div>
          </div>
        </div>
        <div class="row" ref="elementPassword">
          <div class="col-md-9">
            <div class="row icon-cards">
              <div class="col-12">
                <div class="row">
                  <div class="col-md-3 col-xs-12 mb-2">
                    <div class="card">
                      <div class="card-body text-center">
                        <i class="iconsmind-Timer-2"></i>
                        <p class="card-text mb-0">LLegadas Tarde</p>
                        <p class="lead card-item-tablero text-center mb-0">
                          {{ Indicadores.Llegadas }}
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 col-xs-12 mb-2">
                    <div class="card">
                      <div class="card-body text-center">
                        <i class="iconsmind-Bag-Coins"></i>
                        <p class="card-text mb-0">Novedades</p>
                        <p class="lead card-item-tablero text-center mb-0">
                          {{ Indicadores.Novedades }}
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 col-xs-12 mb-2">
                    <div class="card">
                      <div class="card-body text-center">
                        <i class="iconsmind-Door"></i>
                        <p class="card-text mb-0">Renuncias</p>
                        <p class="lead card-item-tablero text-center mb-0">
                          {{ Indicadores.Renuncias }}
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 col-xs-12 mb-2">
                    <div class="card">
                      <div class="card-body text-center">
                        <i class="iconsmind-Conference"></i>
                        <p class="card-text mb-0">Nuevo personal</p>
                        <p class="lead card-item-tablero text-center mb-0">
                          {{ Indicadores.Nuevos }}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-12">
                <div class="card">
                  <div class="card-title pl-3 pt-3 mb-0">
                    <h4 class>
                      Top 5 llegadas tarde en el mes
                    </h4>
                  </div>
                  <div
                    class="
                      card-body
                      d-flex
                      justify-content-around
                      align-items-center
                      p-2
                    "
                  >
                    <template v-if="topFuncionariosByRetardos.length">
                      <div
                        class="text-center"
                        v-for="(
                          funcionario, index
                        ) in topFuncionariosByRetardos"
                        :key="index"
                      >
                        <img
                          v-if="funcionario.image != null"
                          class="img-funcionario"
                          :src="`${funcionario.image}`"
                          alt
                        />
                        <img
                          v-else
                          :src="`/img/robot.jpg`"
                          class="img-funcionario"
                          alt
                        />
                        <p class="mb-0">
                          {{ parsearNombreFuncionario(funcionario) }}
                        </p>
                        <p>
                          <small>
                            {{ funcionario.llegadas }} Retraso
                            <span v-if="funcionario.llegadas > 1">s</span>
                          </small>
                        </p>
                      </div>
                    </template>
                    <p class v-else>
                      <img
                        src="/img/llegadas.png"
                        class="img-fluid"
                        alt="sin llegadas tarde"
                      />
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="mt-4">
              <grafica-retardos :datos="graficaRetardos">
                <h4 class>Llegadas tarde en este mes</h4>
              </grafica-retardos>
            </div>
            <div class="mt-4">
              <grafica-costos :datos="graficaCostos">
                <h5 class>Costos nómina</h5>
              </grafica-costos>
            </div>
          </div>

          <div class="col-md-3">
            <festivos :Festivos="Festivos"></festivos>
            <birthdays :funcionarios="birthdayFuncionarios"></birthdays>

            <contratos-por-vencer
              class="mt-4"
              :funcionarios="contratosFuncionarios"
            ></contratos-por-vencer>

            <contratos-con-preaviso-no-renovados
              class="mt-4"
              :funcionarios="ContratosConPreavisoNoRenovadosData"
            ></contratos-con-preaviso-no-renovados>
          </div>
        </div> -->
    </div>
    <!-- </div> -->
    <overlay v-else></overlay>

    <!-- <modal id="elementPassword" :esLg="true" ref="elementPassword">
      <template slot="titulo">Cambiar contraseña</template>
      <template slot="contenido">
        <recuperar-contrasenia></recuperar-contrasenia>
      </template>
    </modal> -->
  </div>
</template>

<script>
import EncuestaVer from "../encuestas/EncuestaVer.vue";
import EncuestasPrincipal from "../encuestas/EncuestasPrincipal.vue";
// import RecuperarContrasenia from "./RecuperarContrasenia";
// import GraficaRetardos from "./GraficaRetardos";
// import GraficaCostos from "./GraficaCostos";
// import Birthdays from "./Birthdays";
// import ContratosPorVencer from "./ContratosPorVencer";
// import ContratosConPreavisoNoRenovados from "./ContratosConPreavisoNoRenovados";
// import Festivos from "./Festivos";
// import Overlay from "../utiles/Overlay";

// import Modal from "../utiles/Modal";

export default {
  // components: {
  // GraficaRetardos,
  // GraficaCostos,
  // Birthdays,
  // ContratosPorVencer,
  // ContratosConPreavisoNoRenovados,
  // Overlay,
  // RecuperarContrasenia,
  // Festivos,
  // Modal,
  // },
  data() {
    return {
      //     Titulo: "",
      renderizarTablero: true,
      //     topFuncionariosByRetardos: [],
      //     graficaRetardos: [],
      //     graficaCostos: [],
      //     birthdayFuncionarios: [],
      //     contratosFuncionarios: [],
      //     ContratosConPreavisoNoRenovadosData: [],
      //     Indicadores: {
      //       Llegadas: 0,
      //       Novedades: 0,
      //       Renuncias: 0,
      //       Nuevos: 0,
      //     },
      //     Festivos: [],
      //     Frase: "",
      //     brand: true,
    };
  },
  created() {
    // this.brand = JSON.parse(localStorage.getItem("usuario"))["brand"] == true;
    // this.getAllDatos();
  },
  components: { EncuestaVer, EncuestasPrincipal },
};
</script>

<!-- <style scoped>
.icon-cards i {
  font-size: 46px;
  line-height: 66px;
  color: #4bb1f0;
}
.card-item-tablero {
  font-family: "Montserrat", sans-serif;
  font-size: 1.3rem;
}
.img-funcionario {
  width: 42px;
  border-radius: 50%;
  border: 1px solid #ccc;
}
.svg-icon {
  width: 38px;
  display: inline-block;
  padding-bottom: 10px;
  padding-left: 4px;
}
.frase {
  font-weight: 700;
  font-size: 17px;
  color: #2f4eb9;
}
.autor {
  font-size: 16px;
  font-weight: 100;
} 
</style>
-->