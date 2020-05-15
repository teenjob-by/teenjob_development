<template>
    <div>

        <b-navbar toggleable="lg" type="light">
            <b-navbar-brand href="#">
                <img src="/images/footer-logo-desktop.svg">
            </b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>




                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">

                    <b-nav-item-dropdown right>
                        <!-- Using 'button-content' slot -->
                        <template v-slot:button-content>
                            <em>{{ userName }}</em>
                        </template>
                        <b-dropdown-item href="/organisation">Кабинет</b-dropdown-item>
                        <b-dropdown-item href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выйти</b-dropdown-item>
                        <b-form id="logout-form" action="/logout" method="POST" style="display: none;">
                            <input type="hidden" name="_token" :value="csrf">
                        </b-form>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>

        <section class="content">
            <nav class="side-menu">
                <p class="side-menu-header">Организации</p>
                <ul>
                    <li  class="side-menu-link">
                        <router-link :to="{ name: 'organisationIndex' }">
                            Все
                        </router-link>
                    </li>
                </ul>
                <p class="side-menu-header">Работа</p>
                <ul>
                    <li  class="side-menu-link">
                        <router-link :to="{ name: 'jobIndex', params: {scope: 'all'}  }">
                            Все
                        </router-link>
                    </li>
                    <li  class="side-menu-link">
                        <router-link :to="{ name: 'jobIndex', params: {scope: 'unapproved'} }">
                            Новые
                        </router-link>
                    </li>
                    <li  class="side-menu-link">
                        <router-link :to="{ name: 'jobIndex', params: { scope: 'archived'} }">
                            В архиве
                        </router-link>
                    </li>
                </ul>

                <p class="side-menu-header">Волонтерство</p>
                <ul>
                    <li  class="side-menu-link">
                        <router-link :to="{ name: 'volunteeringIndex', params: {scope: 'all'}  }">
                            Все
                        </router-link>
                    </li>
                    <li  class="side-menu-link">
                        <router-link :to="{ name: 'volunteeringIndex', params: {scope: 'unapproved'} }">
                            Новые
                        </router-link>
                    </li>
                    <li  class="side-menu-link">
                        <router-link :to="{ name: 'volunteeringIndex', params: { scope: 'archived'} }">
                            В архиве
                        </router-link>
                    </li>
                </ul>

                <p class="side-menu-header">Стажировки</p>
                <ul>
                    <li  class="side-menu-link">
                        <router-link :to="{ name: 'internshipIndex', params: {scope: 'all'}  }">
                            Все
                        </router-link>
                    </li>
                    <li  class="side-menu-link">
                        <router-link :to="{ name: 'internshipIndex', params: {scope: 'unapproved'} }">
                            Новые
                        </router-link>
                    </li>
                    <li  class="side-menu-link">
                        <router-link :to="{ name: 'internshipIndex', params: { scope: 'archived'} }">
                            В архиве
                        </router-link>
                    </li>
                </ul>

                <p class="side-menu-header">Мероприятия</p>
                <ul>
                    <li  class="side-menu-link">
                        <router-link :to="{ name: 'eventIndex', params: {scope: 'all'}  }">
                            Все
                        </router-link>
                    </li>
                    <li  class="side-menu-link">
                        <router-link :to="{ name: 'eventIndex', params: {scope: 'unapproved'} }">
                            Новые
                        </router-link>
                    </li>
                    <li  class="side-menu-link">
                        <router-link :to="{ name: 'eventIndex', params: { scope: 'archived'} }">
                            В архиве
                        </router-link>
                    </li>
                </ul>
            </nav>

            <div>
                <router-view></router-view>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        name: "Layout",
        props: ['userName', 'userId', 'userToken'],
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        created() {
            localStorage.setItem('access_token', this.$props['userToken']);
            console.log(this);
        },
        methods: {
            submit : function(){
                this.$refs.form.submit();
            }
        }
    }
</script>

<style lang="scss">
    $white: #ffffff;
    $lightgray: #F5F5F5;
    $violet: #274684;
    $black: #000000;
    $orange: #ffbe4d;
    $blue: #0074d9;
    $darkgray: #2C2C2C;
    $gray: #2F2F2F;
    $red: #FF0000;
    .navbar {
        box-shadow: -2px -9px 20px 2px $violet;
    }

    .content {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        & > div {
            width: 100%;
        }
    }
    .side-menu {
        height: 100%;
        min-width: 200px;
        padding: 20px;
        box-shadow: -1px 1px 9px 0px gainsboro;
        p {
            font-weight: bold;
            font-size: 18px;

        }
        ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            padding-left: 20px;
            li {
                a {
                    font-weight: bold;
                    font-size: 16px;
                    color: black;
                }
            }
        }
    }

    .table th, .table td {
        word-break: break-word;
        white-space: normal;
        max-width: 300px;
    }

    .btn {
        margin: 5px;
    }
</style>


