<template>
    <div>

        <b-card class="mt-3 " header="Редактирование организации">

            <b-card-body>
                <b-form @submit="onSubmit" >
                    <b-form-group
                            id="name"
                            label="Название:"
                            label-for="name-input"
                    >
                        <b-form-input
                                id="name-input"
                                v-model="form.name"
                                type="text"
                                required
                                placeholder="Название (офиц.)*"
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group
                            id="link"
                            label="Сайт/группа в соц. сети*:"
                            label-for="link-input"
                    >
                        <b-form-input
                                id="link-input"
                                v-model="form.link"
                                type="text"
                                required
                                placeholder="Сайт организации"
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group id="type" label="Тип*:" label-for="type-input">
                        <b-form-select
                                id="type-input"
                                v-model="form.type"
                                :options="types"
                                required
                                value-field="id"
                                text-field="name"
                        ></b-form-select>
                    </b-form-group>

                    <b-form-group
                            id="unique_identifier"
                            label="УНП*:"
                            label-for="unique_identifier-input"
                    >
                        <b-form-input
                                id="unique_identifier-input"
                                v-model="form.unique_identifier"
                                type="text"
                                required
                                placeholder="УНП"
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group
                            id="contactPerson"
                            label="Контактное лицо*:"
                            label-for="contactPerson-input"
                    >
                        <b-form-input
                                id="contact-input"
                                v-model="form.contact"
                                type="text"
                                required
                                placeholder="Контактное лицо"
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group
                            id="phone"
                            label="Телефон*:"
                            label-for="phone-input"
                    >
                        <b-form-input
                                id="phone-input"
                                v-model="form.phone"
                                type="text"
                                required
                                placeholder="Телефон"
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group
                            id="alt_phone"
                            label="Дополнительный тел.:"
                            label-for="alt_phone-input"
                    >
                        <b-form-input
                                id="alt_phone-input"
                                v-model="form.alt_phone"
                                type="text"
                                placeholder="Дополнительный тел."
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group
                            id="email"
                            label="Email*:"
                            label-for="email-input"
                    >
                        <b-form-input
                                id="email-input"
                                v-model="form.email"
                                type="text"
                                required
                                placeholder="Email"
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group
                            id="alt_email"
                            label="Дополнительный email*:"
                            label-for="email-input"
                    >
                        <b-form-input
                                id="alt_email-input"
                                v-model="form.alt_email"
                                type="text"
                                placeholder="Дополнительный email"
                        ></b-form-input>
                    </b-form-group>


                    <b-button type="submit" variant="primary">Сохранить</b-button>

                </b-form>
            </b-card-body>


        </b-card>
        <v-dialog>
        </v-dialog>
    </div>
</template>

<script>
    var qs = require('qs');

    export default {
        name: "OrganisationEdit",

        props: ['id'],
        data() {
            return {
                form: {
                    id: '',
                    name: '',
                    link: '',
                    type: '',
                    unique_identifier: '',
                    contactPerson: '',
                    phone: '',
                    alt_phone: '',
                    email: '',
                    alt_email: ''
                },
                types: [],
                cities: [],
                show: true
            }
        },
        mounted() {
            var app = this;

            axios.get('/api/v1/organisations/' + this.id + '/edit', { headers: {
                    'Authorization': `Bearer ` + localStorage.getItem('access_token')
                }})
                .then(function (resp) {
                    console.log(resp);
                    app.form = resp.data.data;
                    app.types = resp.data.types
                    app.cities = resp.data.cities
                    console.log(app.types)
                })
                .catch(function (resp) {

                    alert("Could not load organisations");
                });
        },
        methods: {
            save() {
                var app = this;
                axios.patch('/api/v1/organisations/' + app.id, qs.stringify(app.form) , { headers: {
                        'Authorization': `Bearer ` + localStorage.getItem('access_token')
                    }})
                    .then(function (resp) {
                        app.data = resp.data.data;
                        app.$modal.show('dialog', {
                            title: 'Информация',
                            text: 'Успешно сохранено',
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
                            text: 'При сохранении возникла ошибка, обратитесь к разработчику',
                            buttons: [
                                {
                                    title: 'Закрыть'
                                }
                            ]
                        })
                    });
            },
            onSubmit(evt , id) {
                evt.preventDefault()

                this.$modal.show('dialog', {
                    title: 'Подтверждение',
                    text: 'Действительно хотите сохранить данные?',
                    buttons: [
                        {
                            title: 'Да',
                            handler: () => {
                                this.save();
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
            },
        }
    }
</script>

<style lang="scss" scoped>
    .card {
        max-width: 700px;
        margin: auto;
    }
</style>


