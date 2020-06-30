<template>
    <div>

        <b-card class="mt-3 " header="Редактирование волонтерства">

            <b-card-body>
                <b-form @submit="onSubmit" class="volunteering_form">
                    <div class="volunteering_form-group">
                        <div class="centered-title">
                            <div class="inner-icon">
                                <input id="title-input" required type="text" class="volunteering_form-group-input title-input" name="title" placeholder="Название" autofocus v-model="form.title">


                                <span class="message-invalid" role="alert">
                                    <strong></strong>
                                </span>

                            </div>
                        </div>
                    </div>

                    <div class="volunteering_form-group">
                        <div class="left-aligned">
                            <label for="city-input" class="volunteering_form-group-label">Город :</label>
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
                                >
                                </b-form-select>


                                <span class="message-invalid" role="alert">
                                    <strong></strong>
                                </span>

                            </div>
                        </div>
                    </div>

                    <div class="volunteering_form-group">
                        <div class="left-aligned">
                            <label for="age-input" class="volunteering_form-group-label">Возраст*:</label>
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


                    <div class="volunteering_form-group">
                        <div class="left-aligned">
                            <label for="speciality-input" class="volunteering_form-group-label">Вид деятельности:</label>
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
                 

                    <div class="volunteering_form-group">
                        <div class="inner-icon stretch raw-text">

                            <div class="inner-icon stretch raw-text">
                                <textarea id="description" name="description" ref="editor" type="text" class="volunteering_form-group-input textarea raw-text"  placeholder="Введите описание">{{ this.form.description }}</textarea>
                            </div>

                        </div>
                    </div>

                    <div class="volunteering_form-group">
                        <div class="left-aligned">
                        </div>
                        <div class="right-aligned">
                            <h3 class="volunteering_form-title">
                                <strong>Контакты</strong>
                            </h3>
                        </div>
                    </div>

                    <div class="volunteering_form-group">
                        <div class="left-aligned">
                            <label for="contactPerson-input" class="volunteering_form-group-label">Контактное лицо*:</label>
                        </div>
                        <div class="right-aligned">
                            <input id="contactPerson-input" type="text" name="contactPerson" placeholder="Контактное лицо" class="volunteering_form-group-input " v-model="form.contact" autocomplete="contactPerson" autofocus>


                            <span class="message-invalid" role="alert">
                                <strong></strong>
                            </span>

                        </div>
                    </div>


                    <div class="volunteering_form-group">
                        <div class="left-aligned">
                            <label for="phone-input" class="volunteering_form-group-label">Телефон*:</label>
                        </div>
                        <div class="right-aligned">
                            <input id="phone-input" type="text" name="phone" placeholder="Телефон" class="volunteering_form-group-input " v-model="form.phone" autocomplete="phone" autofocus>


                            <span class="message-invalid" role="alert">
                                <strong></strong>
                            </span>

                        </div>
                    </div>



                    <div class="volunteering_form-group">
                        <div class="left-aligned">
                            <label for="email-input" class="volunteering_form-group-label">Email*:</label>
                        </div>
                        <div class="right-aligned">
                            <input id="email-input" type="text" name="email" placeholder="Email*:" class="volunteering_form-group-input " v-model="form.email" autocomplete="email" autofocus>


                            <span class="message-invalid" role="alert">
                                <strong></strong>
                            </span>

                        </div>
                    </div>

                    <div class="volunteering_form-group">
                        <div class="left-aligned">
                            <label for="alt_phone-input" class="volunteering_form-group-label">Дополнительный тел.:</label>
                        </div>
                        <div class="right-aligned">
                            <input id="alt_phone-input" type="text" name="alt_phone"  class="volunteering_form-group-input " v-model="form.alt_phone"  autocomplete="alt_phone" autofocus>


                            <span class="message-invalid" role="alert">
                                <strong></strong>
                            </span>

                        </div>
                    </div>


                    <div class="volunteering_form-group">
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
        name: "VolunteeringEdit",

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

            axios.get('/api/v1/volunteerings/' + this.id + '/edit', { headers: {
                    'Authorization': `Bearer ` + localStorage.getItem('access_token')
                }})
                .then(function (resp) {
                    console.log(resp);
                    app.form = resp.data.data;
                    app.specialities = resp.data.specialities
                    app.ages = resp.data.ages                   
                    app.cities = resp.data.cities



                    const options = {
                        placeholder: 'Введите описание',
                        tabsize: 2,
                        height: 300,
                        maxWidth: 543,
                        toolbar: [
                            ['style', ['style']],
                            ['font', ['bold', 'underline', 'clear']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link', 'picture', 'video']],
                            ['view', ['fullscreen', 'codeview', 'help']]
                        ]
                    };

                    options.callbacks = {
                        onChange: function(contents, $editable) {
                            app.form.description = contents;
                        }
                    };

                    $('#description').summernote(options);

                    $('#description').summernote('code', app.form.description);
                })
                .catch(function (resp) {

                    alert("Could not load volunteerings");
                });
        },
        methods: {
            save() {
                var app = this;
                axios.patch('/api/v1/volunteerings/' + app.id, qs.stringify(app.form) , { headers: {
                        'Authorization': `Bearer ` + localStorage.getItem('access_token')
                    }})
                    .then(function (resp) {
                        app.data = resp.data.data;
                        app.$modal.show('dialog', {
                            title: 'Информация',
                            text: 'Успешно сохранено',
                            buttons: [
                                {
                                    title: 'Закрыть',
                                    handler: () => {
                                        app.$router.push({ name: 'volunteeringIndex', params: { scope: 'unapproved' } })
                                    },
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
                this.save();
            },
        }
    }
</script>

<style lang="scss" scoped>

    $white: #ffffff;
    $lightgray: #F5F5F5;
    $violet: #274684;
    $black: #000000;
    $orange: #F87633;
    $blue: #0074d9;
    $darkgray: #2C2C2C;
    $gray: #2F2F2F;
    $red: #FF0000;
    $yellow: #ffbe4d;

    .card {
        max-width: 700px;
        margin: auto;
    }

    .volunteering_form {

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

    .button {

        width: 100%;
        max-width: 362px;
        height: auto;
        min-height: 48px;
        border-radius: 4px;
        border: none;
        justify-content: center;
        align-items: center;
        display: flex;
        cursor: pointer;
        margin-left: auto;
        margin-right: auto;
        padding-right: 34px;
        padding-left: 34px;
        padding-top: 10px;
        padding-bottom: 10px;
        margin-bottom: 10px;
        transition-duration: 0.2s;
        transition-property: background-color;
        box-sizing: border-box;
        width: 100%;


        &:focus {
            outline: none;
        }


        &:disabled {
            background: #c0c0c0;
            cursor: unset;

            &:hover {

            }
        }

        &.loading {
            cursor: unset;
            background: #c0c0c0;
            transform: unset;
            opacity: 0.7;

            padding-top: 0;
            padding-bottom: 0;


            span {
                display: none;
            }

            .loading-icon {
                background: url(/images/loading-button.svg) center center no-repeat;
                display: block;
                margin: auto;
                width: 40px;
                height: 40px;
            }
        }

        .loading-icon {
            display: none;
        }


        span {
            display: block;
            margin: auto;
            font-size: 16px;
            font-family: "Montserrat", sans-serif;
        }


        &-primary {
            @extend .button;

            color: $white;
            background: $orange;
            &:hover {
                //background-color: #eca72f;
            }
        }

        &-secondary {
            @extend .button;
            color: $white;
            background: $violet;
        }

        &-account {
            @extend .button;
            color: $white;
            background: $orange;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        }

        &-info {
            @extend .button;
            color: $white;
            background: #3DA1DA;
            width: 260px;
            height: 48px;
            span {
                font-size: 14px;
            }

            margin-left: 0;

            margin-bottom: 70px;
            margin-top: 32px;

        }

    }

</style>


