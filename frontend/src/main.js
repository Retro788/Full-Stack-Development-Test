import { createApp } from 'vue'
import './index.css'
import CKEditor from '@ckeditor/ckeditor5-vue'
import App from './App.vue'
import store from './store';
import router from './router';
import axiosClient from './axios';
// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
  components,
  directives,
})

const app = createApp(App);

app
  .use(store)
  .use(router)
  .use(CKEditor)
  .use(vuetify)
  .mount('#app')
;