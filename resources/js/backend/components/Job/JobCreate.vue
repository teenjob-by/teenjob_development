<template>
    <div>

        <b-card class="mt-3 " header="Новая вакансия">

            <b-card-body>
                <b-form @submit="onSubmit" class="job_form">
                    <div class="job_form-group">
                        <div class="centered-title">
                            <div class="inner-icon">
                                <input id="title-input" required type="text" class="job_form-group-input title-input" name="title" placeholder="Название (офиц.)*" autofocus v-model="form.title">


                                <span class="message-invalid" role="alert">
                                    <strong></strong>
                                </span>

                            </div>
                        </div>
                    </div>

                    <div class="job_form-group">
                        <div class="left-aligned">
                            <label for="city-input" class="job_form-group-label">Город (гл. офис)*:</label>
                        </div>
                        <div class="right-aligned">
                            <div class="inner-icon">
                                <b-form-select
                                        id="city-input"
                                        v-model="form.city_id"
                                        :options="cities"
                                        required
                                        value-field="id"
                                        text-field="name"
                                ></b-form-select>


                                <span class="message-invalid" role="alert">
                                    <strong></strong>
                                </span>

                            </div>
                        </div>
                    </div>

                    <div class="job_form-group">
                        <div class="left-aligned">
                            <label for="age-input" class="job_form-group-label">Возраст*:</label>
                        </div>
                        <div class="right-aligned">
                            <div class="inner-icon">
                                <b-form-select
                                        id="age-input"
                                        v-model="form.age"
                                        :options="ages"
                                        required
                                        value-field="id"
                                        text-field="name"
                                ></b-form-select>


                                <span class="message-invalid" role="alert">
                                    <strong></strong>
                                </span>

                            </div>
                        </div>
                    </div>

                    <div class="job_form-group">
                        <div class="left-aligned">
                            <label for="salary-input" class="job_form-group-label">Зарплата*:</label>
                        </div>
                        <div class="right-aligned">

                            <div class="inner-icon">
                                <div class="inline-group">
                                    <input id="salary-input" type="text" class="job_form-group-input is-invalid" name="salary" placeholder="3"  autofocus v-model="form.salary">


                                    <span class="message-invalid" role="alert">
                                        <strong></strong>
                                    </span>



                                    <b-form-select
                                            id="salary_type-input"
                                            v-model="form.salary_type_id"
                                            :options="salaryTypes"
                                            required
                                            value-field="id"
                                            text-field="name"
                                    ></b-form-select>


                                    <span class="message-invalid" role="alert">
                                        <strong></strong>
                                    </span>


                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="job_form-group">
                        <div class="left-aligned">
                            <label for="speciality-input" class="job_form-group-label">Вид деятельности:</label>
                        </div>
                        <div class="right-aligned">
                            <div class="inner-icon">
                                <b-form-select
                                        id="speciality-input"
                                        v-model="form.speciality"
                                        :options="specialities"
                                        required
                                        value-field="id"
                                        text-field="name"
                                ></b-form-select>


                                <span class="message-invalid" role="alert">
                                    <strong></strong>
                                </span>

                            </div>
                        </div>
                    </div>

                    <div class="job_form-group">
                        <div class="left-aligned">
                            <label for="workTimeType-input" class="job_form-group-label">Занятость*:</label>
                        </div>
                        <div class="right-aligned">
                            <div class="inner-icon">
                                <b-form-select
                                        id="workTimeType-input"
                                        v-model="form.work_time_type_id"
                                        :options="workTimeTypes"
                                        required
                                        value-field="id"
                                        text-field="name"
                                ></b-form-select>


                                <span class="message-invalid" role="alert">
                                    <strong></strong>
                                </span>

                            </div>
                        </div>
                    </div>

                    <div class="job_form-group">
                        <div class="inner-icon stretch raw-text">
                            <textarea id="description" type="text" class="job_form-group-input textarea raw-text "  name="description" placeholder="" v-model="form.description"></textarea>


                            <span class="message-invalid" role="alert">
                            <strong></strong>
                        </span>

                        </div>
                    </div>

                    <div class="job_form-group">
                        <div class="left-aligned">
                        </div>
                        <div class="right-aligned">
                            <h3 class="job_form-title">
                                <strong>Контакты</strong>
                            </h3>
                        </div>
                    </div>

                    <div class="job_form-group">
                        <div class="left-aligned">
                            <label for="contactPerson-input" class="job_form-group-label">Контактное лицо*:</label>
                        </div>
                        <div class="right-aligned">
                            <input id="contactPerson-input" type="text" name="contactPerson" placeholder="" class="job_form-group-input " v-model="form.contact" required autocomplete="contactPerson" autofocus>


                            <span class="message-invalid" role="alert">
                                <strong></strong>
                            </span>

                        </div>
                    </div>


                    <div class="job_form-group">
                        <div class="left-aligned">
                            <label for="phone-input" class="job_form-group-label">Контактное лицо*:</label>
                        </div>
                        <div class="right-aligned">
                            <input id="phone-input" type="text" name="phone" placeholder="Телефон" class="job_form-group-input " v-model="form.phone" required autocomplete="phone" autofocus>


                            <span class="message-invalid" role="alert">
                                <strong></strong>
                            </span>

                        </div>
                    </div>

                    <div class="job_form-group">
                        <div class="left-aligned">
                            <label for="alt_phone-input" class="job_form-group-label">Дополнительный тел.:</label>
                        </div>
                        <div class="right-aligned">
                            <input id="alt_phone-input" type="text" name="alt_phone" placeholder="Дополнительный тел." class="job_form-group-input " v-model="form.alt_phone" required autocomplete="alt_phone" autofocus>


                            <span class="message-invalid" role="alert">
                                <strong></strong>
                            </span>

                        </div>
                    </div>

                    <div class="job_form-group">
                        <div class="left-aligned">
                            <label for="email-input" class="job_form-group-label">Email*:</label>
                        </div>
                        <div class="right-aligned">
                            <input id="email-input" type="text" name="email" placeholder="Email*:" class="job_form-group-input " v-model="form.email" required autocomplete="email" autofocus>


                            <span class="message-invalid" role="alert">
                                <strong></strong>
                            </span>

                        </div>
                    </div>


                    <div class="job_form-group">
                        <div class="centered">
                            <button id="submit" class="button-account" role="button" type="submit">
                        <span>
                            Сохранить
                        </span>
                                <div class="loading-icon"></div>
                            </button>
                        </div>
                    </div>

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
        name: "JobCreate",

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
                    work_time_type_id: '',
                    salary_type_id: '',
                    city_id: '',
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

            axios.get('/api/v1/jobs/create', { headers: {
                    'Authorization': `Bearer ` + localStorage.getItem('access_token')
                }})
                .then(function (resp) {
                    app.specialities = resp.data.specialities
                    app.ages = resp.data.ages
                    app.workTimeTypes = resp.data.workTimeTypes
                    app.salaryTypes = resp.data.salaryTypes
                    app.cities = resp.data.cities
                })
                .catch(function (resp) {

                    alert("Could not load jobs");
                });
        },
        methods: {
            save() {
                var app = this;
                axios.post('/api/v1/jobs', qs.stringify(app.form) , { headers: {
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

    .job_form {

        .tip {

            font-weight: bold;
        }

        width: 100%;
        max-width: 700px;
        margin: 0 auto;




        &-group {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            position: relative;
            width: 100%;
            align-items: center;





            margin-bottom: 24px;

            .right-aligned {
                width: auto;
                min-width: 290px;
                max-width: 510px;
            }



            .left-aligned {

                    width: 180px;

                display: flex;
                justify-content: flex-start;
            }



            .inline-group {
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
                width: 100%;
                position: relative;



                input {
                    margin-bottom: 10px;

                        min-width: 150px;
                        margin: 0;

                }

                .select2 {

                        min-width: 100px;
                        margin-right: 0;

                }


                    flex-direction: row;
                    flex-wrap: nowrap;
                    justify-content: space-between;
                    width: 290px;


            }

            &.description {
                align-items: flex-end;

                .left-aligned {
                    display: none;
                }

                .inner-icon {
                    max-width: 575px;
                }



                .right-aligned {
                    max-width: 290px;


                        max-width: 700px;


                }


                    flex-direction: column;



                    .trumbowyg-box {
                        max-width: 100%;
                        margin-left: 0;
                        margin-right: 0;
                    }


            }

            .button-secondary {
                margin-left: 0;
                margin-right: 0;
                width: 290px;
            }

            .button-account {
                margin-left: 0;
                margin-right: 0;
                width: 290px;
                margin-top: 50px
            }

            .message-invalid {

                position: absolute;
                bottom: -20px;
                left: 0px;

            }

            &:last-child {
                margin-bottom: 0px;
            }

                flex-direction: row;
                justify-content: center;
                align-items: center;


            &-label {

                padding-right: 20px;



                    padding-top: 0px;
                    padding-bottom: 0px;
                    line-height: 120%;

            }

            &-input {
                height: 42px;
                width: 100%;
                width: 290px;
                background: #FFFFFF;
                border: 1px solid #E8ECEE;
                box-sizing: border-box;
                border-radius: 0px;




                padding: 3px 20px;

                &:focus {
                    outline: none;
                }

                &::placeholder {

                }

                &.textarea {
                    height: 200px;
                }
            }



            &-select ~ span{
                height: 42px;
                width: 290px;
                background: #FFFFFF;
                border: 1px solid #E8ECEE;
                box-sizing: border-box;
                border-radius: 0px;
                display: flex;
                align-items: center;


                padding: 3px 20px;


                &:focus {
                    outline: none;
                }
            }

            .inner-icon {
                position: relative;
                max-width: 290px;
            }

            .stretch {
                width: 100%;
                max-width: 100%;
            }

            .centered {
                width: 100%;
                display: flex;
                justify-content: center;
            }

            .centered-title {
                width: 100%;
                max-width: 470px;
                display: flex;
                justify-content: center;

                .inner-icon {
                    max-width: 290px;
                    width: 100%;


                        max-width: 100%;

                }
            }

            .title-input {
                border: none;
                font-weight: bold;
                font-size: 20px;
                text-align: left;
                width: 100%;
                padding-right: 0;
                &::placeholder {
                    font-weight: bold;
                    font-size: 20px;
                    text-align: center;
                }
                padding-left: 0px;
            }

        }
    }
</style>


