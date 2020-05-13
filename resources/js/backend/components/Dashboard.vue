<template>
    <div>


        <nav>
            <section>
                <a style="color: white" href="/admin/dashboard">Teenjob.by</a> &nbsp; ||  &nbsp;
                <a style="color: white" href="/">HOME</a>
                <hr>
                <ul>
                    <li>
                        <router-link :to="{ name: 'create', params: { userId } }">
                            NEW POST
                        </router-link>
                    </li>
                </ul>
            </section>
        </nav>
        <article>
            <header>
                <header class="d-inline">Welcome, {{ userName }}</header>
                <p @click="logout" class="float-right mr-3" style="cursor: pointer">Logout</p>
            </header>
            <div>
                <router-view></router-view>
            </div>
        </article>
    </div>
</template>

<script>
    export default {
        name: "Dashboard",
    }
</script>

<style scoped>

</style>


