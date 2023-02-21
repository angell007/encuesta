/** Common JS */
require('./bootstrap')

/* ES6 */

import Vue from 'vue'
import VueRouter from 'vue-router'
import VueFormWizard from 'vue-form-wizard'
import VeeValidate, { Validator } from 'vee-validate'
import VuePaginate from 'vue-paginate'
import VueTheMask from 'vue-the-mask'
import money from 'v-money'
import VTooltip from 'v-tooltip'

import myempresa from "./mixins/myempresa";

import es from 'vee-validate/dist/locale/es'
import VueSweetalert2 from 'vue-sweetalert2'
import Notifications from 'vue-notification'
import Multiselect from 'vue-multiselect'
import JsonExcel from 'vue-json-excel'
import routes from './routes'

import AsyncComputed from 'vue-async-computed'


Vue.component('multiselect', Multiselect)
Vue.component('downloadExcel', JsonExcel)
Vue.use(VueRouter)
Vue.use(VueFormWizard)
Vue.use(VueSweetalert2)
Vue.use(Notifications)
Vue.use(VuePaginate)
Vue.use(VueTheMask)
Vue.use(money, { precision: 0, decimal: ',', thousands: '.' })
Vue.use(AsyncComputed);
Vue.use(VTooltip);
Vue.mixin(myempresa);

// Vue.component('documento-component', require('./components/funcionarios/complementarios/Documentos').default);
Vue.component('target-component', require('./components/Target').default);


Vue.config.productionTip = false
Validator.localize({ es: es })

Vue.use(VeeValidate, { locale: 'es', fieldsBagName: 'vvFields' })

/** filter global para el formato de valores moneda como salarios, bonos, extras etc */
Vue.filter('moneda', function (valor) {

  if (valor == '') return '$ 0'
  const formatter = new Intl.NumberFormat('es-CO', {
    style: 'currency',
    currency: 'COP',
    minimumFractionDigits: 0,
  })
  return formatter.format(parseInt(valor))

})

/** filter global para el formato de valores moneda como salarios, bonos, extras etc */
Vue.filter('custom-moneda', function (valor) {
  if (valor.toString().length < 5) {
    if (valor == '') {
      return '$ 0'
    } else {
      return valor.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
    }
  } else {
    const formatter = new Intl.NumberFormat('es-CO', {
      style: 'currency',
      currency: 'COP',
      minimumFractionDigits: 0,
    })
    return formatter.format(parseInt(valor))
  }
})

/** filter global para mostrar fechas en formato de lectura "humana" */
Vue.filter('lectura', function (valor) {
  if (!valor) return ''
  return moment(valor).format('LL')
})

/** filter global primera mayúscula (capitalizeFirst) */
Vue.filter('capital', function (valor) {
  if (!valor) return ''
  return valor.charAt(0).toUpperCase() + valor.slice(1)
})

/** buses de datos para la comunicación entre componentes hermanos */
window.eventEmitter = new Vue()
window.modalEmitter = new Vue()
window.funcionarioEmitter = new Vue()
window.nominaEmitter = new Vue()

const router = new VueRouter(routes)

// Middleware global de rutas, comprobar que el usuario esté loqueado de lo contrario redirigir al login

router.beforeEach((to, from, next) => {
  if (to.name.toLowerCase() !== 'login' && to.name.toLowerCase() !== 'asistencia' && to.name.toLowerCase() !== 'ae' && to.name.toLowerCase() !== 'ed') {
    if (window.localStorage.getItem('token') !== null) {
      next()
    } else {
      next('/login')
    }
  } else if (

    window.localStorage.getItem('token') !== null &&
    to.name.toLowerCase() === 'login'
  ) {
    next('/tablero')
  } else {
    next()
  }
})

import Sidebar from './components/sidebar/Sidebar'
import Navbar from './components/Navbar'

new Vue({
  el: '#app-vue',
  components: { Sidebar, Navbar },
  router,
  data: {
    usuarioAutenticado: false,
    ruta: false
  },
  beforeCreate() {
    var ruta = this.$route.query.up;
    if (typeof ruta !== 'undefined') {
      var decode = atob(ruta)
      decode = JSON.parse(decode);

      axios
        .post("/api/auth/login", decode)
        .then(datos => {

          localStorage.setItem("token", datos.data.token);
          localStorage.setItem("usuario", JSON.stringify(datos.data.User));
          localStorage.setItem("empresa", JSON.stringify(datos.data.Empresa));
          localStorage.setItem("tenant", datos.data.ruta);
          eventEmitter.$emit("autenticado");
          this.$router.push("/tablero");

        })
        .catch(error => {
          if (error.response.status == 401) {
            this.$notify({
              group: "notificaciones",
              title: "Error",
              text: (error.response.data.status) ? (error.response.data.status) : "Credenciales inválidas, intente nuevamente",
              type: "error"
            });
          }
        });
    }
  },
  created() {
    this.ruta = this.$route.name.toLowerCase();
    if (!localStorage.getItem('token')) {
      eventEmitter.$on('autenticado', () => {
        this.usuarioAutenticado = true
      })
    } else {
      this.usuarioAutenticado = localStorage.getItem('token') !== null
    }
  },

  updated() {
    this.usuarioAutenticado = localStorage.getItem('token') !== null
  },
  methods: {
    redireccionar() {
      setTimeout(() => {
        this.usuarioAutenticado = false
        this.$router.push('/login')
      }, 500)
    },
  },
  watch: {
    $route: {
      handler(to, from) {
        const body = document.getElementsByTagName('body')[0];
        this.ruta = to.name.toLowerCase();
        if (to.name.toLowerCase() == 'login' || to.name.toLowerCase() == 'asistencia' || to.name.toLowerCase() == 'ae' || to.name.toLowerCase() == 'ed') {
          body.classList.remove('menu-default');
          body.classList.add('background');
        } else {
          body.classList.add('menu-default');
          body.classList.remove('background');
        }
      },
      immediate: true,
    }
  },
})
