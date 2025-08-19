// resources/js/plugins/axios.js
import axios from "axios";

export default {
  install(app) {
    // automatic baseURL depende sa domain kung saan naka-open
    axios.defaults.baseURL = window.location.origin;
    axios.defaults.withCredentials = true;

    // para magamit sa components as this.$axios
    app.config.globalProperties.$axios = axios;
  }
};