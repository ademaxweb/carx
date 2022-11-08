import './bootstrap';
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { far } from '@fortawesome/free-regular-svg-icons'
import { fab } from '@fortawesome/free-brands-svg-icons'
import {createApp} from "vue/dist/vue.esm-bundler";
import router from "./router";
import Index from "./Index.vue";

library.add(fas, far, fab)

const app = createApp(Index)
app.component('font-awesome-icon', FontAwesomeIcon)
app.use(router)
app.mount("#app")
