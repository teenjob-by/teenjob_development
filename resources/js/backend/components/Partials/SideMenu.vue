<template>
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
                    На модерацию <div v-if=this.$store.state.menu.organisationsOnModerationCount class="counter"><span>{{ this.$store.state.menu.organisationsOnModerationCount }}</span></div>
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
                    На модерацию <div v-if=this.$store.state.menu.jobsOnModerationCount class="counter"><span>{{ this.$store.state.menu.jobsOnModerationCount }}</span></div>
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

            <li class="side-menu-link">
                <router-link :to="{ name: 'jobIndex', params: { scope: 'outdated'} }">
                    Прошедшие
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
                    На модерацию <div v-if=this.$store.state.menu.volunteeringsOnModerationCount class="counter"><span>{{ this.$store.state.menu.volunteeringsOnModerationCount }}</span></div>
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

            <li class="side-menu-link">
                <router-link :to="{ name: 'volunteeringIndex', params: { scope: 'outdated'} }">
                    Прошедшие
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
                    На модерацию <div v-if=this.$store.state.menu.internshipsOnModerationCount class="counter"><span>{{ this.$store.state.menu.internshipsOnModerationCount }}</span></div>
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
            <li class="side-menu-link">
                <router-link :to="{ name: 'internshipIndex', params: { scope: 'outdated'} }">
                    Прошедшие
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
                    На модерацию <div v-if=this.$store.state.menu.eventsOnModerationCount class="counter"><span>{{ this.$store.state.menu.eventsOnModerationCount }}</span></div>
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
            <li class="side-menu-link">
                <router-link :to="{ name: 'eventIndex', params: { scope: 'outdated'} }">
                    Прошедшие
                </router-link>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        name: "SideMenu",
        data() {
            return {
                jobsOnModerationCount: 0,
                organisationsOnModerationCount: 0,
                eventsOnModerationCount: 0,
                internshipsOnModerationCount: 0,
                volunteeringsOnModerationCount: 0,
            }
        },
        mounted() {
            this.$store.commit('count')
        }
    }
</script>

<style lang="scss" scoped>
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
                    position: relative;

                    &:hover {
                        background-color: #dae0e5;
                        transition: all 0.15s ease-in;
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
        .router-link-active {
            color: #fff !important;
            background-color: #274684 !important;
            border-color: #274684 !important;
            box-shadow: inset 3px 4px 5px -2px black;
            padding-left: 40px !important;
            transition: all 0.15s ease-in;
        }

        .counter {
            display: inline-flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 20px;
            height: 20px;
            position: absolute;
            top: 15px;
            right: 5px;
            border-radius: 50%;
            background: lightcoral;
            font-weight: bold;

        }
    }
</style>