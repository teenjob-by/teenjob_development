<template>
    <div>

        <b-card class="mt-3 " header="Редактирование стажировки">

            <b-card-body>
                <b-form @submit="onSubmit" >
                    <b-form-group
                            id="title"
                            label="Название:"
                            label-for="title-input"
                    >
                        <b-form-input
                                id="title-input"
                                v-model="form.title"
                                type="text"
                                required
                                placeholder="Название (офиц.)*"
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group id="city" label="Город*:" label-for="city-input">
                        <b-form-select
                                id="city-input"
                                v-model="form.city_id"
                                :options="cities"
                                required
                                value-field="id"
                                text-field="name"
                        ></b-form-select>
                    </b-form-group>

                    <b-form-group id="age" label="Возраст*:" label-for="age-input">
                        <b-form-select
                                id="age-input"
                                v-model="form.age"
                                :options="ages"
                                required
                                value-field="id"
                                text-field="name"
                        ></b-form-select>
                    </b-form-group>


                    <b-form-group id="speciality" label="Область*:" label-for="speciality-input">
                        <b-form-select
                                id="speciality-input"
                                v-model="form.speciality"
                                :options="specialities"
                                required
                                value-field="id"
                                text-field="name"
                        ></b-form-select>
                    </b-form-group>

                    <b-form-group id="description" label="Описание*:" label-for="description-input">
                        <trumbowyg v-model="form.description" class="form-control" id="description" required></trumbowyg>
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

    import Trumbowyg from 'vue-trumbowyg';
    // Import editor css
    import 'trumbowyg/dist/ui/trumbowyg.css';

    export default {
        name: "InternshipEdit",

        components: {
            Trumbowyg
        },

        props: ['id'],
        data() {
            return {
                form: {
                    id: '',
                    title: '',
                    link: '',
                    type: '',
                    age: '',
                    workTimeType: '',
                    salaryType: '',
                    salary: '',
                    phone: '',
                    alt_phone: '',
                    contact: '',
                    email: '',
                    alt_email: '',
                    speciality: ''
                },
                specialities: [],
                cities: [],
                workTimeTypes: [],
                salaryTypes: [],
                ages: [],
                show: true
            }
        },
        mounted() {
            var app = this;

            axios.get('/api/v1/internships/' + this.id + '/edit', { headers: {
                    'Authorization': `Bearer ` + localStorage.getItem('access_token')
                }})
                .then(function (resp) {
                    console.log(resp);
                    app.form = resp.data.data;
                    app.specialities = resp.data.specialities
                    app.ages = resp.data.ages
                    app.cities = resp.data.cities
                    console.log(app.types)
                })
                .catch(function (resp) {

                    alert("Could not load Internships");
                });
        },
        methods: {
            save() {
                var app = this;
                axios.patch('/api/v1/internships/' + app.id, qs.stringify(app.form) , { headers: {
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


