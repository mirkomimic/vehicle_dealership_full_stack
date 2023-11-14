import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { Link, createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";

import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import colors from 'vuetify/lib/util/colors'
import '@mdi/font/css/materialdesignicons.css'

const vuetify = createVuetify({
  components,
  directives,
  theme: {
    defaultTheme: 'dark',
    // themes: {
    //   light: {
    //     dark: true,
    //     colors: {
    //       primary: '#E53935',
    //       secondary: colors.red.lighten4,
    //     }
    //   },
    // },
  },
  treeShake: true
})

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) =>
    resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob("./Pages/**/*.vue")
    ),
    setup({ el, App, props, plugin }) {
      return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(vuetify)
      .use(ZiggyVue, Ziggy)
      .mount(el);
    },
    progress: {
      color: "#4B5563",
    },
    
});
