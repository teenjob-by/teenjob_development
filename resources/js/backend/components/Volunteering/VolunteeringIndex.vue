<template>
    <div>
        <b-card>
            <b-card-body>
                <router-link :to="{name: 'volunteeringCreate'}">
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
        name: "VolunteeringIndex",
        props: ['scope'],

        data: function () {
            var self = this;
            return {
                data: [],

                // Columns that should be displayed on The Table
                columns: [
                    {name: "id", th: "id", show: false},
                    {th: "Заголовок", render: function (row, cell, index) {
                            return `<a href="/admin/volunteerings/${row.id}/edit">${row.title}</a>`;
                        }},
                    {th: "Создано", render: function (row, cell, index) {
                            console.log(this)
                            return self.dateFormat(`${row.created_at}`);
                        }},
                    {th: "Город",
                        render: function (row, cell, index) {
                            return `${row.city.name}`;
                        }},
                    {th: "Организация", render: function (row, cell, index) {
                            return `<a href="/admin/organisations/${row.organisation.id}/edit">${row.organisation.name}</a>`;
                        }}
                ],
                actions: [
                    {
                        text: "Удалить", color: "danger", action: (row, index) => {


                            this.$modal.show('dialog', {
                                title: 'Подтверждение',
                                text: 'Действительно хотите удалить запись?',
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
                                text: 'Действительно хотите заблокировать запись?',
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
                        text: "Опубликовать", color: "danger", action: (row, index) => {
                            this.$modal.show('dialog', {
                                title: 'Подтверждение',
                                text: 'Действительно хотите опубликовать запись?',
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
                            this.$router.push({name: 'volunteeringEdit', params: { id: row.id }})
                        }
                    }
                ]
            }
        },



        mounted() {
            var app = this;

            axios.get('/api/v1/volunteerings/show/' + app.scope, { headers: {
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
        watch: {
            "$route.params.scope"(val) {
                this.load();
            },
        },
        methods: {
            dateFormat(val) {
              return this.$moment(val).format("DD/MM/YY hh:mm");
            },
            load() {
                var app = this;

                axios.get('/api/v1/volunteerings/show/' + app.scope, { headers: {
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
                    axios.delete('/api/v1/volunteerings/' + id, { headers: {
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
                axios.patch('/api/v1/volunteerings/' + id + '/ban', {}, { headers: {
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
                axios.patch('/api/v1/volunteerings/' + id + '/approve',{}, { headers: {
                        'Authorization': `Bearer ` + localStorage.getItem('access_token')
                    }})
                    .then(function (resp) {
                        app.$modal.show('dialog', {
                            title: 'Информация',
                            text: 'Успешно опубликовано',
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


