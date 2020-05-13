<template>
    <div>
        <b-card>
            <b-card-body>
                <router-link :to="{name: 'jobCreate'}">
                    <b-button class="ml-auto mb-3" id="new">Создать</b-button>
                </router-link>
                <datatable :data="data" :columns="columns" :actions="actions"></datatable>
            </b-card-body>
        </b-card>
        <v-dialog>
        </v-dialog>
    </div>
</template>

<script>

    export default {
        name: "JobIndex",

        data: function () {
            return {
                data: [],

                // Columns that should be displayed on The Table
                columns: [
                    {name: "id", th: "id", show: false},
                    {name: "title", th: "Название"},
                    {th: "Город",
                        render: function (row, cell, index) {
                            return `${row.city.name}`;
                        }},
                    {th: "Организация", render: function (row, cell, index) {
                            return `<a href="${row.organisation.id}">${row.organisation.name}</a>`;
                        }}
                ],
                actions: [
                    {
                        text: "Удалить", color: "danger", action: (row, index) => {


                            this.$modal.show('dialog', {
                                title: 'Подтверждение',
                                text: 'Действительно хотите удалить организацию?',
                                buttons: [
                                    {
                                        title: 'Да',
                                        handler: () => {
                                            this.delete(row.id, index);
                                            this.$modal.hide('dialog');
                                        },
                                        default: true,
                                    },
                                    {
                                        title: 'Нет',
                                    },
                                    {
                                        title: 'Отмена'
                                    }
                                ]
                            })
                        }
                    },
                    {
                        text: "Заблокировать", color: "danger", action: (row, index) => {
                            this.$modal.show('dialog', {
                                title: 'Подтверждение',
                                text: 'Действительно хотите заблокировать организацию?',
                                buttons: [
                                    {
                                        title: 'Да',
                                        handler: () => {
                                            this.ban(row.id, index);
                                            this.$modal.hide('dialog');
                                        },
                                        default: true,
                                    },
                                    {
                                        title: 'Нет',
                                    },
                                    {
                                        title: 'Отмена'
                                    }
                                ]
                            })
                        }
                    },
                    {
                        text: "Разблокировать", color: "danger", action: (row, index) => {
                            this.$modal.show('dialog', {
                                title: 'Подтверждение',
                                text: 'Действительно хотите разблокировать организацию?',
                                buttons: [
                                    {
                                        title: 'Да',
                                        handler: () => {
                                            this.approve(row.id, index);
                                            this.$modal.hide('dialog');
                                        },
                                        default: true,
                                    },
                                    {
                                        title: 'Нет',
                                    },
                                    {
                                        title: 'Отмена'
                                    }
                                ]
                            })
                        }
                    },
                    {
                        text: "Править", color: "danger", action: (row, index) => {
                            this.$router.push({name: 'organisationEdit', params: { id: row.id }})
                        }
                    }
                ]
            }
        },
        mounted() {
            var app = this;

            axios.get('/api/v1/jobs', { headers: {
                    'Authorization': `Bearer ` + localStorage.getItem('access_token')
                }})
                .then(function (resp) {
                    app.data = resp.data.data;
                    console.log(app.data);
                })
                .catch(function (resp) {

                    alert("Could not load organisations");
                });
        },
        methods: {
            load() {
                var app = this;

                axios.get('/api/v1/organisations', { headers: {
                        'Authorization': `Bearer ` + localStorage.getItem('access_token')
                    }})
                    .then(function (resp) {
                        app.data = resp.data.data;
                        console.log(app.data);
                    })
                    .catch(function (resp) {

                        alert("Could not load organisations");
                    });
            },
            delete(id, index) {
                    var app = this;
                    axios.delete('/api/v1/organisations/' + id, { headers: {
                            'Authorization': `Bearer ` + localStorage.getItem('access_token')
                        }})
                        .then(function (resp) {
                            app.data.splice(index, 1);

                            app.$modal.show('dialog', {
                                title: 'Информация',
                                text: 'Удаление успешно завершено',
                                buttons: [
                                    {
                                        title: 'Закрыть'
                                    }
                                ]
                            })
                        })
                        .catch(function (resp) {
                            app.$modal.show('dialog', {
                                title: 'Информация',
                                text: 'При удалении возникла ошибка, обратитесь к разработчику',
                                buttons: [
                                    {
                                        title: 'Закрыть'
                                    }
                                ]
                            })
                        })
            },
            ban(id, index) {
                var app = this;
                axios.patch('/api/v1/organisations/' + id + '/ban', {}, { headers: {
                        'Authorization': `Bearer ` + localStorage.getItem('access_token')
                    }})
                    .then(function (resp) {

                        app.$modal.show('dialog', {
                            title: 'Информация',
                            text: 'Успешно заблокировано',
                            buttons: [
                                {
                                    title: 'Закрыть'
                                }
                            ]
                        })
                        load()
                    })
                    .catch(function (resp) {
                        app.$modal.show('dialog', {
                            title: 'Информация',
                            text: 'При блокировке возникла ошибка, обратитесь к разработчику',
                            buttons: [
                                {
                                    title: 'Закрыть'
                                }
                            ]
                        })
                    })
            },
            approve(id, index) {
                var app = this;
                axios.patch('/api/v1/organisations/' + id + '/approve', { headers: {
                        'Authorization': `Bearer ` + localStorage.getItem('access_token')
                    }})
                    .then(function (resp) {
                        app.$modal.show('dialog', {
                            title: 'Информация',
                            text: 'Успешно заблокировано',
                            buttons: [
                                {
                                    title: 'Закрыть'
                                }
                            ]
                        })
                        load()
                    })
                    .catch(function (resp) {
                        app.$modal.show('dialog', {
                            title: 'Информация',
                            text: 'При блокировке возникла ошибка, обратитесь к разработчику',
                            buttons: [
                                {
                                    title: 'Закрыть'
                                }
                            ]
                        })
                    })
            },
            edit(id, index) {

            },
        }
    }
</script>

<style lang="scss" scoped>

</style>


