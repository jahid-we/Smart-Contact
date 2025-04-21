import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import { router } from '@inertiajs/vue3';
import NProgress from 'nprogress';
import '../css/nprogress-custom.css'; // your custom override

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mount(el)
  },
})

router.on('start', () => {
    console.log('Inertia navigation started') // Debugging
    NProgress.start()
})

router.on('finish', (event) => {
    console.log('Inertia navigation finished') // Debugging
    NProgress.done()
})
