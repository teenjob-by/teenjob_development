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
                    <li class="side-menu-link">
                        <router-link :to="{ name: 'organisationIndex', params: {scope: 'published'} }">
                            Активные
                        </router-link>
                    </li>
                    <li class="side-menu-link">
                        <router-link :to="{ name: 'organisationIndex', params: {scope: 'unapproved'} }">
                            На модерацию
                        </router-link>
                    </li>
                    <li class="side-menu-link">
                        <router-link :to="{ name: 'organisationIndex', params: {scope: 'banned'} }">
                            Заблокированные
                        </router-link>
                    </li>
                    <li class="side-menu-link">
                        <router-link :to="{ name: 'organisationIndex', params: {scope: 'admin'} }">
                            Администраторы
                        </router-link>
                    </li>
                </ul>
                <p class="side-menu-header">Работа</p>
                <ul>
                    <li  class="side-menu-link">
                        <router-link :to="{ name: 'jobIndex', params: {scope: 'published'}  }">
                            Опубликованные
                        </router-link>
                    </li>
                    <li  class="side-menu-link">
                        <router-link :to="{ name: 'jobIndex', params: {scope: 'unapproved'} }">
                            На модерацию
                        </router-link>
                    </li>
                    <li  class="side-menu-link">
                        <router-link :to="{ name: 'jobIndex', params: { scope: 'banned'} }">
                            Заблокированные
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
                        <router-link :to="{ name: 'volunteeringIndex', params: {scope: 'published'}  }">
                            Опубликованные
                        </router-link>
                    </li>
                    <li  class="side-menu-link">
                        <router-link :to="{ name: 'volunteeringIndex', params: {scope: 'unapproved'} }">
                            На модерацию
                        </router-link>
                    </li>
                    <li  class="side-menu-link">
                        <router-link :to="{ name: 'volunteeringIndex', params: { scope: 'banned'} }">
                            Заблокированные
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
                        <router-link :to="{ name: 'internshipIndex', params: {scope: 'published'}  }">
                            Опубликованные
                        </router-link>
                    </li>
                    <li  class="side-menu-link">
                        <router-link :to="{ name: 'internshipIndex', params: {scope: 'unapproved'} }">
                            На модерацию
                        </router-link>
                    </li>
                    <li  class="side-menu-link">
                        <router-link :to="{ name: 'internshipIndex', params: { scope: 'banned'} }">
                            Заблокированные
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
                        <router-link :to="{ name: 'eventIndex', params: {scope: 'published'}  }">
                            Опубликованные
                        </router-link>
                    </li>
                    <li  class="side-menu-link">
                        <router-link :to="{ name: 'eventIndex', params: {scope: 'unapproved'} }">
                            На модерацию
                        </router-link>
                    </li>
                    <li  class="side-menu-link">
                        <router-link :to="{ name: 'eventIndex', params: { scope: 'banned'} }">
                            Заблокированные
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

    .card {
        position: relative;
        z-index: 1;
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

        box-shadow: -1px 1px 9px 0px gainsboro;
        p {
            font-weight: bold;
            font-size: 18px;

        }
        ul {
            margin: 0;
            list-style: none;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            padding-left: 0px;
            li {
                a {
                    background-color: #f8f9fa;
                    display: block;
                    padding: 0.75rem 1.75rem;
                    margin-bottom: -1px;
                    border: 1px solid rgba(0, 0, 0, 0.125);
                    width: 100%;
                    color: #495057;
                    text-align: inherit;
                    text-decoration: none;
                    transition: all 0.15s ease-in;

                    &:hover {
                        background-color: #dae0e5;
                        transition: all 0.15s ease-in;
                    }

                    &.active {

                    }
                }
            }
        }

        .side-menu-header {
            background-color: #e9ecef;
            display: block;
            padding: 0.75rem 1.25rem;
            margin-bottom: -1px;
            border: 1px solid rgba(0, 0, 0, 0.125);
            width: 100%;
            color: #495057;
            text-align: inherit;
        }
    }

    .table th, .table td {
        word-break: break-word;
        white-space: normal;
        max-width: 250px;
    }

    .action-col {
        width: 230px;
    }

    .btn {
        margin: 5px;
    }

    .router-link-active {
        color: #fff !important;
        background-color: #274684 !important;
        border-color: #274684 !important;
        box-shadow: inset 3px 4px 5px -2px black;
        padding-left: 40px !important;
        transition: all 0.15s ease-in;
    }
</style>


