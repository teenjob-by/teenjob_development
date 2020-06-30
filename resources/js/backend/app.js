// File: ./resources/assets/js/app.js

require('./bootstrap');
import Vue from 'vue'
import VueRouter from 'vue-router'
import Dashboard from './components/Dashboard'
import SideMenu from './components/Partials/SideMenu'
import OrganisationIndex from './components/Organisation/OrganisationIndex'
import OrganisationEdit from './components/Organisation/OrganisationEdit'
import OrganisationCreate from './components/Organisation/OrganisationCreate'

import JobIndex from './components/Job/JobIndex'
import JobEdit from './components/Job/JobEdit'
import JobCreate from './components/Job/JobCreate'

import VolunteeringIndex from './components/Volunteering/VolunteeringIndex'
import VolunteeringEdit from './components/Volunteering/VolunteeringEdit'
import VolunteeringCreate from './components/Volunteering/VolunteeringCreate'

import EventIndex from './components/Event/EventIndex'
import EventEdit from './components/Event/EventEdit'
import EventCreate from './components/Event/EventCreate'

import InternshipIndex from './components/Internship/InternshipIndex'
import InternshipEdit from './components/Internship/InternshipEdit'
import InternshipCreate from './components/Internship/InternshipCreate'

import Layout from './components/Layout'
import Vuex from 'vuex'
import BootstrapVue from 'bootstrap-vue';
import VModal from 'vue-js-modal'
Vue.use(require('vue-moment'));
Vue.use(require("./plugins/vue-datatable"));

Vue.component("side-menu", SideMenu);
Vue.use(VueRouter)
Vue.use(SideMenu)
Vue.use(BootstrapVue)
Vue.use(Vuex)
Vue.use(VModal, { dialog: true })

import LoadScript from 'vue-plugin-load-script';

Vue.use(LoadScript);

import Select2 from 'v-select2-component';

Vue.component('vue-select', Select2);

const store = new Vuex.Store({
    state: {
        menu: {
            jobsOnModerationCount: 0,
            organisationsOnModerationCount: 0,
            eventsOnModerationCount: 0,
            internshipsOnModerationCount: 0,
            volunteeringsOnModerationCount: 0,
        }
    },
    mutations: {
        count (menu) {
            var app = this;

            axios.get('/api/v1/counters', { headers: {
                    'Authorization': `Bearer ` + localStorage.getItem('access_token')
                }})
                .then(function (resp) {

                    app.state.menu.jobsOnModerationCount = resp.data.data.jobCount
                    console.log(resp.data.data)
                    app.state.menu.organisationsOnModerationCount = resp.data.data.organisationCount
                    app.state.menu.internshipsOnModerationCount = resp.data.data.internshipCount
                    app.state.menu.volunteeringsOnModerationCount = resp.data.data.volunteeringCount
                    app.state.menu.eventsOnModerationCount = resp.data.data.eventCount
                })
                .catch(function (resp) {
                    console.log('Counters not loaded')
                });
        }
    }
})


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
            path: '/admin/organisations/show/:scope',
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
            path: '/admin/jobs/show/:scope',
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

        {
            path: '/admin/volunteerings/show/:scope',
            name: 'volunteeringIndex',
            component: VolunteeringIndex,
            props: true
        },
        {
            path: '/admin/volunteerings/:id/edit',
            name: 'volunteeringEdit',
            component: VolunteeringEdit,
            props: true
        },
        {
            path: '/admin/volunteerings/create',
            name: 'volunteeringCreate',
            component: VolunteeringCreate,
            props: true
        },

        {
            path: '/admin/internships/show/:scope',
            name: 'internshipIndex',
            component: InternshipIndex,
            props: true
        },
        {
            path: '/admin/internships/:id/edit',
            name: 'internshipEdit',
            component: InternshipEdit,
            props: true
        },
        {
            path: '/admin/internships/create',
            name: 'internshipCreate',
            component: InternshipCreate,
            props: true
        },

        {
            path: '/admin/events/show/:scope',
            name: 'eventIndex',
            component: EventIndex,
            props: true
        },
        {
            path: '/admin/events/:id/edit',
            name: 'eventEdit',
            component: EventEdit,
            props: true
        },
        {
            path: '/admin/events/create',
            name: 'eventCreate',
            component: EventCreate,
            props: true
        },
    ],
});

const app = new Vue({
    el: '#admin',
    router,
    store: store,
    components: { Layout },
});