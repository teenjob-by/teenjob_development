// File: ./resources/assets/js/app.js

require('./bootstrap');
import Vue from 'vue'
import VueRouter from 'vue-router'
import Dashboard from './components/Dashboard'
import OrganisationIndex from './components/Organisation/OrganisationIndex'
import OrganisationEdit from './components/Organisation/OrganisationEdit'
import OrganisationCreate from './components/Organisation/OrganisationCreate'
import JobIndex from './components/Job/JobIndex'
import JobEdit from './components/Job/JobEdit'
import JobCreate from './components/Job/JobCreate'
import Jobs from './components/Jobs'
import Layout from './components/Layout'
import Vuex from 'vuex'
import BootstrapVue from 'bootstrap-vue';
import VModal from 'vue-js-modal'
Vue.use(require('vue-moment'));
Vue.use(require("./plugins/vue-datatable"));
Vue.use(VueRouter)
Vue.use(BootstrapVue)
Vue.use(Vuex)
Vue.use(VModal, { dialog: true })

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/admin/',
            name: 'dashboard',
            component: Dashboard,
            props: true
        },
        {
            path: '/admin/dashboard',
            name: 'dashboard',
            component: Dashboard,
            props: true
        },
        {
            path: '/admin/organisations',
            name: 'organisationIndex',
            component: OrganisationIndex,
            props: true
        },
        {
            path: '/admin/organisations/:id/edit',
            name: 'organisationEdit',
            component: OrganisationEdit,
            props: true
        },
        {
            path: '/admin/organisations/create',
            name: 'organisationCreate',
            component: OrganisationCreate,
            props: true
        },
        {
            path: '/admin/jobs',
            name: 'jobIndex',
            component: JobIndex,
            props: true
        },
        {
            path: '/admin/jobs/:id/edit',
            name: 'jobEdit',
            component: JobEdit,
            props: true
        },
        {
            path: '/admin/jobs/create',
            name: 'jobCreate',
            component: JobCreate,
            props: true
        },
    ],
});

const app = new Vue({
    el: '#admin',
    router,
    components: { Layout },
});