<template>
    <div>
        <b-card>
            <b-card-body>
                <router-link :to="{name: 'jobCreate'}">
                    <b-button class="ml-auto mb-3" id="new">Создать</b-button>
                </router-link>
                <datatable :key='tablekey' :data="data" :columns="columns" :ajax="true" :url="url + scope" :AjaxHeaders="{ headers: {
                    'Authorization': `Bearer ` + token
                }}" :actions="actions"></datatable>
            </b-card-body>
        </b-card>
        <v-dialog>
        </v-dialog>
    </div>
</template>

<script>

    export default {
        name: "JobIndex",
        props: ['scope'],

        data: function () {
            var self = this;
            return {
                data: [],

                // Columns that should be displayed on The Table
                columns: [
                    {name: "id", th: "id", show: false},
                    {th: "Заголовок", render: function (row, cell, index) {
                            return `<a href="/admin/jobs/${row.id}/edit">${row.title}</a>`;
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
                actions: [],

                token: "",
                tablekey: 0,
                url: '/api/v1/jobs/show/'
            }
        },

        created() {
            this.token = localStorage.getItem('access_token')
            this.addActions()
        },

        watch: {
            "$route.params.scope"(val) {
                this.addActions()
                this.load();
            },
        },
        methods: {
            addActions() {

                this.actions = [];

                this.actions.unshift({
                    text: '<i class="fa fa-edit" aria-hidden="true"></i>', color: "info", action: (row, index) => {
                        this.$router.push({name: 'jobEdit', params: { id: row.id }})
                    }
                },{
                    text: '<i class="fa fa-trash" aria-hidden="true"></i>', color: "danger", action: (row, index) => {


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
                },)



                if((this.scope == 'published') || (this.scope == 'unapproved') || (this.scope == 'admin') || (this.scope == 'archived') || (this.scope == 'outdated')) {
                    this.actions.unshift(
                        {
                            text: '<i class="fa fa-ban" aria-hidden="true"></i>', color: "info", action: (row, index) => {
                                this.ban(row.id, index);
                            }
                        }
                    )
                }

                if((this.scope == 'banned') || (this.scope == 'published') || (this.scope == 'unapproved') || (this.scope == 'outdated')) {
                    this.actions.unshift(
                        {
                            text: '<i class="fa fa-archive" aria-hidden="true"></i>', color: "info", action: (row, index) => {
                                this.archive(row.id, index);
                            }
                        }
                    )
                }


                if(this.scope == 'banned' || (this.scope == 'unapproved') || (this.scope == 'admin') || (this.scope == 'archived') || (this.scope == 'outdated')) {

                    this.actions.unshift( {
                        text: '<i class="fa fa-globe" aria-hidden="true"></i>', color: "approve", action: (row, index) => {
                            this.approve(row.id, index);
                        }
                    })
                }
            },
            dateFormat(val) {
              return this.$moment(val).format("DD/MM/YY hh:mm");
            },
            load() {
                this.tablekey += 1
                this.$store.commit('count')
            },
            delete(id, index) {
                    var app = this;
                    axios.delete('/api/v1/jobs/' + id, { headers: {
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
                axios.patch('/api/v1/jobs/' + id + '/ban', {}, { headers: {
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
                        app.load()
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
                axios.patch('/api/v1/jobs/' + id + '/approve',{}, { headers: {
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
                        app.load()
                    })
                    .catch(function (resp) {
                        app.$modal.show('dialog', {
                            title: 'Информация',
                            text: 'При публикации возникла ошибка, обратитесь к разработчику',
                            buttons: [
                                {
                                    title: 'Закрыть'
                                }
                            ]
                        })
                    })
            },
            archive(id, index) {
                var app = this;
                axios.patch('/api/v1/jobs/' + id + '/archive',{}, { headers: {
                        'Authorization': `Bearer ` + localStorage.getItem('access_token')
                    }})
                    .then(function (resp) {
                        app.$modal.show('dialog', {
                            title: 'Информация',
                            text: 'Успешно заархивировано',
                            buttons: [
                                {
                                    title: 'Закрыть'
                                }
                            ]
                        })
                        app.load()
                    })
                    .catch(function (resp) {
                        app.$modal.show('dialog', {
                            title: 'Информация',
                            text: 'При архивации возникла ошибка, обратитесь к разработчику',
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


