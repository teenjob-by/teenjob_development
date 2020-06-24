<template>
    <div>

        <b-card class="mt-3 " header="Создание мероприятия">

            <b-card-body>
                <b-form @submit="onSubmit" class="event_form">
                    <div class="event_form-group">
                        <div class="centered-title">
                            <div class="inner-icon">
                                <input id="title-input" required type="text" class="event_form-group-input title-input" name="title" placeholder="Название (офиц.)*" autofocus v-model="form.title">


                                <span class="message-invalid" role="alert">
                                    <strong></strong>
                                </span>

                            </div>
                        </div>
                    </div>

                    <div class="event_form-group">
                        <div class="left-aligned">
                            <label for="city-input" class="event_form-group-label">Город (гл. офис)*:</label>
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

                    <div class="event_form-group">
                        <div class="left-aligned">
                            <label for="age-input" class="event_form-group-label">Возраст*:</label>
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



                    <div class="event_form-group date-group">
                        <div class="left-aligned">
                            <label class="event_form-group-label" for="date_start">Дата начала:</label>
                        </div>
                        <div class="right-aligned">
                            <div class="inner-icon">
                                <div class="event_form-date-group">
                                    <input type="text" required class="event_form-group-input datePicker" id="date_start" name="date_start" placeholder="" v-model="form.date_start"/>
                                </div>

                                <div class="event_form-date-group time-group">
                                    <label for="date_start" class="event_form-group-label">Время</label>
                                    <input required type="text" class="event_form-group-input timePicker" id="time_start" name="time_start" placeholder="" v-model="form.time_start"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="event_form-group">
                        <div class="left-aligned">
                            <label for="address-input" class="event_form-group-label">Адрес:</label>
                        </div>
                        <div class="right-aligned">
                            <input
                                    id="address-input"
                                    v-model="form.address"
                                    type="text"
                                    required
                                    placeholder="Название (офиц.)*"
                                    class="event_form-group-input"
                            >

                            <span class="message-invalid" role="alert">
                                <strong></strong>
                            </span>

                        </div>
                    </div>

                    <div class="event_form-group">
                        <div class="left-aligned">
                            <label for="type-input" class="event_form-group-label">Участие*:</label>
                        </div>
                        <div class="right-aligned">
                            <div class="inner-icon">
                                <b-form-select
                                        id="type-input"
                                        v-model="form.type_id"
                                        :options="types"
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




                    <div class="event_form-group">
                        <div class="inner-icon stretch raw-text">

                            <trumbowyg v-model="form.description" class="form-control" id="description" required></trumbowyg>

                            <span class="message-invalid" role="alert">
                            <strong></strong>
                        </span>

                        </div>
                    </div>


                    <div class="event_form-group">

                        <div class="centered-title">
                            <div class="inner-icon">
                                <div id="image" class="file-upload">
                                    <button class="button-secondary" type="button" onclick="$('.file-upload-input').trigger( 'click' )"><span>Загрузить обложку*</span></button>

                                    <div class="image-upload-wrap">
                                        <input class="file-upload-input" type='file' name="image"  v-on:change="readURL" accept="image/jpeg, image/png" />
                                        <div class="drag-text">
                                            <h3>Перенесите изображение чтобы загрузить</h3>
                                        </div>
                                    </div>
                                    <div class="file-upload-content">
                                        <img class="file-upload-image" src="#" alt="your image" />
                                        <div class="image-title-wrap">
                                            <button type="button"  v-on:click="removeUpload" class="button-secondary"><span>Удалить&nbsp;</span> <span class="image-title"></span></button>
                                        </div>
                                    </div>
                                </div>


                                <span class="message-invalid" role="alert">
                                    <strong></strong>
                                </span>

                            </div>
                        </div>
                    </div>
                    

                    <div class="event_form-group event_form-map-group">
                        <div class="centered-full">
                            <div class="inner-icon">
                                <p class="map-title">Отметьте место проведения на карте</p>
                                <div class="map" id="map">
                                </div>
                                <input type="hidden" :value="form.location" name="location" id="event-location">
                            </div>
                        </div>
                    </div>


                    <div class="event_form-group">
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
        name: "EventCreate",

        components: {
            Trumbowyg
        },

        props: ['id'],
        data() {
            return {
                form: {
                    id: '',
                    title: '',
                    age: '14',
                    city_id: '1',
                    type_id: '1',
                    location: '',
                    description: '',
                    image: '',
                    address: '',
                    date_start: '',
                    time_start: '',
                    date_finish: '',
                    time_finish: ''
                },
                cities: [],
                types: [],
                ages: [],
                show: true
            }
        },
        mounted() {
            var app = this;

            axios.get('/api/v1/events/create', { headers: {
                    'Authorization': `Bearer ` + localStorage.getItem('access_token')
                }})
                .then(function (resp) {
                    app.specialities = resp.data.specialities
                    app.ages = resp.data.ages
                    app.types = resp.data.types
                    app.cities = resp.data.cities
                })
                .catch(function (resp) {

                    alert("Could not load Events");
                });
            $('.image-upload-wrap').bind('dragover', function () {
                $('.image-upload-wrap').addClass('image-dropping');
            });
            $('.image-upload-wrap').bind('dragleave', function () {
                $('.image-upload-wrap').removeClass('image-dropping');
            });





            app.$loadScript("/js/gmaps.js")
                .then(() => {
                    app.$loadScript("https://maps.googleapis.com/maps/api/js?key=AIzaSyBk-L7v6RJ1QVUtF48zHH8_eY7VWUvtluQ&callback=initMap")
                        .then(() => {

                        })
                        .catch(() => {
                            // Failed to fetch script
                        });
                })
                .catch(() => {
                    // Failed to fetch script
                });



        },
        created() {

        },

        beforeDestroy() {

            var app = this;
            app.$unloadScript("/js/gmaps.js")
                .then(() => {
                    app.$unloadScript("https://maps.googleapis.com/maps/api/js?key=AIzaSyBk-L7v6RJ1QVUtF48zHH8_eY7VWUvtluQ&callback=initMap")
                        .then(() => {

                        })
                        .catch(() => {
                            // Failed to fetch script
                        });
                })
                .catch(() => {
                    // Failed to fetch script
                });
        },
        methods: {
            save() {
                var app = this;
                var form_data = new FormData();
                this.form.location = $('#event-location').val();

                for ( var key in this.form ) {
                    form_data.append(key, this.form[key]);
                }



                axios.post('/api/v1/events', form_data , { headers: {
                        'Authorization': `Bearer ` + localStorage.getItem('access_token'),
                        'Content-Type': 'multipart/form-data'
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
                                        app.$router.push({ name: 'eventIndex', params: { scope: 'unapproved' } })
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

            readURL() {
                var input = $('.file-upload-input')[0];
                console.log(input);

                if (input.files && input.files[0]) {

                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('.image-upload-wrap').hide();

                        $('.file-upload-image').attr('src', e.target.result);
                        $('.file-upload-content').show();

                        $('.image-title').html(input.files[0].name);
                    };

                    reader.readAsDataURL(input.files[0]);
                    this.form.image = input.files[0];
                    console.log(input.files[0]);

                } else {
                    this.removeUpload();
                    console.log('remove');
                }
                console.log('test');
            },

            removeUpload() {
                $('.file-upload-input').replaceWith($('.file-upload-input').clone());
                $('.file-upload-content').hide();
                $('.image-upload-wrap').show();
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

    .event_form {

        .tip {

            font-weight: bold;
        }

        width: 100%;
        max-width: 700px;
        margin: 0 auto;

        &-date-group {


            display: flex;





            &.time-group {


                margin-top: 0;
                input {
                    max-width: 75px;
                    min-width: 75px;
                    padding-left: 10px;
                    padding-right: 10px;
                }

                label {
                    margin-left: 15px;
                    padding-right: 5px;
                }

            }






                flex-direction: row;
                flex-wrap: nowrap;
                justify-content: flex-start;

                max-width: 385px;

                align-items: center;


            input {
                max-width: 150px;
                min-width: 140px;

            }

            label {
                margin-left: 20px;
                padding-right: 10px;
            }
        }




        &-group {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            position: relative;
            width: 100%;
            align-items: center;

            .file-upload {
                background-color: #ffffff;
                width: 100%;
                margin: 0 auto;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .file-upload-btn {
                width: 100%;
                margin: 0;
                color: #fff;
                background: #1FB264;
                border: none;
                padding: 10px;
                border-radius: 4px;
                border-bottom: 4px solid #15824B;
                transition: all .2s ease;
                outline: none;
                text-transform: uppercase;
                font-weight: 700;
            }

            .file-upload-btn:hover {
                background: $violet;
                color: #ffffff;
                transition: all .2s ease;
                cursor: pointer;
            }

            .file-upload-btn:active {
                border: 0;
                transition: all .2s ease;
            }

            .file-upload-content {
                display: none;
                text-align: center;
            }

            .file-upload-input {
                position: absolute;
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
                outline: none;
                opacity: 0;
                cursor: pointer;
            }

            .image-upload-wrap {
                margin-top: 20px;
                border: 4px dashed $violet;
                position: relative;
                width: 100%;
            }

            .image-dropping,
            .image-upload-wrap:hover {
                background-color: lightgray;
                border: 4px dashed #ffffff;
            }

            .image-title-wrap {
                padding: 0 15px 15px 15px;
                color: #222;
            }

            .drag-text {
                text-align: center;
            }

            .drag-text h3 {
                font-weight: 100;
                text-transform: uppercase;
                font-size: 16px;
                text-align: center;
                color: $violet;
                padding: 60px 0;
            }

            .file-upload-image {
                max-height: 200px;
                max-width: 200px;
                margin: auto;
                padding: 20px;
            }

            .remove-image {
                width: 200px;
                margin: 0;
                color: #fff;
                background: #cd4535;
                border: none;
                padding: 10px;
                border-radius: 4px;
                border-bottom: 4px solid #b02818;
                transition: all .2s ease;
                outline: none;
                text-transform: uppercase;
                font-weight: 700;
            }

            .remove-image:hover {
                background: #c13b2a;
                color: #ffffff;
                transition: all .2s ease;
                cursor: pointer;
            }

            .remove-image:active {
                border: 0;
                transition: all .2s ease;
            }

            .map {
                width: 100%;
                height: 350px;
            }


            &.event_form-map-group {
                justify-content: center;
                flex-direction: column;
                .map-title {
                    font-size: 18px;
                    color: $black;
                    text-align: center;
                    margin-bottom: 20px;
                }
            }


            &.date-group {



                    flex-direction: row;




                .inner-icon {
                    display: flex;
                    flex-direction: row;


                    justify-content: flex-start;
                }
            }


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

            .centered-full {
                width: 100%;
                max-width: 100%;
                display: flex;
                justify-content: center;

                .inner-icon {
                    width: 100%;
                    max-width: 100%;

                }
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


