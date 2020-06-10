<template>
    <div>

        <b-card class="mt-3 " header="Создание мероприятия">

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


                    <b-form-group id="type" label="Участие*:" label-for="type-input">
                        <b-form-select
                                id="type-input"
                                v-model="form.type_id"
                                :options="types"
                                required
                                value-field="id"
                                text-field="name"
                        ></b-form-select>
                    </b-form-group>

                    <b-form-group
                            id="address"
                            label="Адрес:"
                            label-for="address-input"
                    >
                        <b-form-input
                                id="address-input"
                                v-model="form.address"
                                type="text"
                                required
                                placeholder="Название (офиц.)*"
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group
                            id="date_start"
                            label="Дата начала:"
                            label-for="date_start-input"
                    >
                        <b-form-input
                                id="date_start-input"
                                v-model="formattedStartDate"
                                type="text"
                                required
                                placeholder="Дата"
                        ></b-form-input>

                        <b-form-input
                                id="time_start-input"
                                v-model="formattedStartTime"
                                type="text"
                                required
                                :value="timeFormat(form.time_start)"
                                placeholder="Время"
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group
                            id="date_finish"
                            label="Дата завершения:"
                            label-for="date_finish-input"
                    >
                        <b-form-input
                                id="date_finish-input"
                                v-model="formattedFinishDate"
                                type="text"
                                required
                                placeholder="Дата"
                        ></b-form-input>

                        <b-form-input
                                id="time_finish-input"
                                v-model="formattedFinishTime"
                                type="text"
                                required
                                placeholder="Время"
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group id="description" label="Описание*:" label-for="description-input">
                        <trumbowyg v-model="form.description" class="form-control" id="description" required></trumbowyg>
                    </b-form-group>
                    <div class="event_form-group">
                        <p for="event-image">Загрузить изображение</p>

                        <div class="file-upload">
                            <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Добавить изображение</button>

                            <div class="image-upload-wrap">
                                <input class="file-upload-input" type='file' name="image" v-on:change="readURL" accept="image/*" />
                                <div class="drag-text">
                                    <h3>Drag and drop a file or select add Image</h3>
                                </div>
                            </div>
                            <div class="file-upload-content">
                                <img class="file-upload-image" :src="form.image" alt="your image" />
                                <div class="image-title-wrap">
                                    <button type="button" v-on:click="removeUpload" class="remove-image">Remove <span class="image-title">{{ filename }}</span></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <b-form-group class="event_form-group event_form-map-group">
                        <p class="map-title">Карта</p>
                        <div class="map" id="map">
                        </div>
                        <input type="hidden" :value="form.location" name="location" id="event-location">
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
                    age: '',
                    city_id: '',
                    type_id: '',
                    location: '',
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

            $('.image-upload-wrap').bind('dragover', function () {
                $('.image-upload-wrap').addClass('image-dropping');
            });
            $('.image-upload-wrap').bind('dragleave', function () {
                $('.image-upload-wrap').removeClass('image-dropping');
            });

            let mapScript = document.createElement('script')
            mapScript.async = true;
            mapScript.defer = true;
            mapScript.setAttribute('src', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBk-L7v6RJ1QVUtF48zHH8_eY7VWUvtluQ&callback=initMap')
            document.head.appendChild(mapScript)



                $('.image-upload-wrap').hide();

                $('.file-upload-content').show();


        },
        created() {
            let mapInitScript = document.createElement('script')
            mapInitScript.setAttribute('src', '/js/gmaps.js')
            document.head.appendChild(mapInitScript)

            var app = this;

            axios.get('/api/v1/events/' + app.id + '/edit', { headers: {
                    'Authorization': `Bearer ` + localStorage.getItem('access_token')
                }})
                .then(function (resp) {
                    app.form = resp.data.data;
                    app.ages = resp.data.ages
                    app.types = resp.data.types
                    app.cities = resp.data.cities
                })
                .catch(function (resp) {

                    alert("Could not load Events");
                });
        },

        computed: {
            formattedStartDate: {
                get: function () {
                    var value = this.form.date_start;
                    var formatted = this.$moment(value).format("DD/MM/YY");
                    return formatted;
                },

                set(val) {
                    this.form.date_start = val;
                }
            },

            formattedStartTime: {
                get: function () {
                    var value = this.form.time_start;
                    var formatted = this.$moment(value).format("hh:mm");
                    return formatted;
                },

                set(val) {
                    this.form.time_start = val;
                }
            },

            filename: {
                get: function () {
                    return this.form.image.split(/[\\/]/).pop();
                }
            },

            formattedFinishDate: {
                get: function () {
                    var value = this.form.date_finish;
                    var formatted = this.$moment(value).format("DD/MM/YY");
                    return formatted;
                },

                set(val) {
                    this.form.date_finish = val;
                }
            },

            formattedFinishTime: {
                get: function () {
                    var value = this.form.time_finish;
                    var formatted = this.$moment(value).format("hh:mm");
                    return formatted;
                },

                set(val) {
                    this.form.time_finish = val;
                }
            }
        },
        methods: {
            save() {
                var app = this;
                var form_data = new FormData();

                for ( var key in this.form ) {
                    form_data.append(key, this.form[key]);
                }
                var location = $('#event-location').val();
                form_data.append('location', location);
                console.log(location);

                axios.patch('/api/v1/events/' + app.id, form_data , { headers: {
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

            dateFormat(val) {
                return this.$moment(val).format("DD/MM/YY");
            },

            timeFormat(val) {
                return this.$moment(val).format("hh:mm");
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

    // Media queries
    @mixin for-phone-only {
        @media (max-width: 599px) { @content; }
    }
    @mixin for-tablet-portrait-up {
        @media (min-width: 600px) { @content; }
    }
    @mixin for-tablet-landscape-up {
        @media (min-width: 900px) { @content; }
    }
    @mixin for-desktop-up {
        @media (min-width: 1024px) { @content; }
    }


    @mixin title ($font-size-sm, $font-size-md, $font-size-lg, $margin-bottom-sm, $margin-bottom-md, $margin-bottom-lg) {
        text-align: center;
        font-size: $font-size-sm;
        font-family: $font-family-primary;
        font-style: normal;
        font-weight: 600;
        color: $font-title-color;
        margin-bottom: $margin-bottom-sm;

        @include for-tablet-portrait-up {
            font-size: $font-size-md;
            margin-bottom: $margin-bottom-md;
        }

        @include for-desktop-up {
            font-size: $font-size-lg;
            margin-bottom: $margin-bottom-lg;
        }
    }

    @mixin text-usual ($font-size, $font-color, $align) {
        text-align: $align;
        font-size: $font-size;
        font-family: $font-family-primary;
        font-weight: normal;
        color: $font-color;
        line-height: 150%;
        font-size: $font-size;
    }

    @mixin button-text ($font-size, $font-color) {
        font-size: $font-size;
        font-family: $font-family-primary;
        font-weight: 600;
        color: $font-color;
        line-height: 150%;
        font-size: $font-size;
    }

    @mixin image-adaptive ($width, $height) {
        width: $width;
        height: $height;
        display: flex;
        margin: 0 auto;

        .card-header-image {
            margin: inherit;
        }
    }


    $white: #ffffff;
    $lightgray: #F5F5F5;
    $violet: #274684;
    $black: #000000;
    $orange: #ffbe4d;
    $blue: #0074d9;
    $darkgray: #2C2C2C;
    $gray: #2F2F2F;
    $red: #FF0000;

    $header-height: 70px;
    $footer-height: 200px;

    $whiteselect: #B0B0B0;

    // Blocks dimensions

    $min-width: 290px;
    $min-breakpoint-width: 320px;
    $max-width: 960px;
    $font-family-primary: 'Open Sans', sans-serif;
    $font-title-color: $darkgray;


    // Home page section titles
    $font-size-title-sm: 28px;
    $font-size-title-md: 28px;
    $font-size-title-lg: 42px;

    $title-margin-sm: 30px;
    $title-margin-md: 30px;
    $title-margin-lg: 60px;

    // Card titles

    $font-size-title-card-sm: 20px;
    $font-size-title-card-md: 20px;
    $font-size-title-card-lg: 20px;

    $title-margin-card-sm: 12px;
    $title-margin-card-md: 12px;
    $title-margin-card-lg: 12px;

    //Top menu

    $font-size-top-menu-sm: 14px;
    $font-size-top-menu-md: 20px;
    $font-size-top-menu-lg: 20px;


    //Top menu slogan

    $font-size-menu-slogan-sm: 40px;
    $font-size-menu-slogan-md: 40px;
    $font-size-menu-slogan-lg: 48px;

    $font-size-margin-slogan-sm: 30px;
    $font-size-margin-slogan-md: 30px;
    $font-size-margin-slogan-lg: 60px;
    .card {
        max-width: 700px;
        margin: auto;
    }

    .event {

        &_card {
            width: 200px;
            height: 400px;

            background: $white;
            border: 1px solid rgba(0, 0, 0, 0.08);
            box-sizing: border-box;
            position: relative;
            display: block;
            overflow: hidden;
            margin-bottom: 38px;
            transition: box-shadow 0.1s ease-in;

            margin-right: 5px;
            margin-left: 5px;
            margin-top: 10px;
            margin-bottom: 10px;

            @include for-desktop-up() {
                margin-right: 0px;
                margin-left: 0px;
                margin-top: 0px;
                margin-bottom: 20px;
            }


            &-overlay {
                filter: brightness(0.7);
            }

            &-wrapper {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;

                justify-content: space-evenly;

                @include for-desktop-up() {
                    justify-content: space-between;
                }

                .pagination {
                    margin-left: auto;
                    margin-right: auto;
                }


                align-items: flex-start;
                width: 100%;
            }

            &:hover{
                box-shadow: -1px 4px 12px 0px rgba(0,0,0,0.4);
            }

            &-header {
                width: 100%;
                height: 170px;
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                align-items: center;

                &-time {
                    height: 50px;
                    background: rgba(0, 0, 0, 0.6);
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    display: flex;
                    flex-direction: column;
                    align-items: flex-end;
                    justify-content: center;

                    .time-wrapper {

                        position: relative;
                        display: block;
                        margin-right: 10px;
                        @include text-usual(14px, $white, right);
                        font-weight: bold;

                        &:before {
                            content: url("/images/small-calendar.svg");
                            position: absolute;
                            top: 3px;
                            left: -25px;
                            width: 16px;
                            height: 16px;
                        }
                    }
                }

                &-image{
                    width: 200px;
                    height: 168px;
                    background: transparent url(/images/loading.svg) no-repeat center center;
                    background-size: 50% 50%;
                }
            }

            &-title {
                @include text-usual(18px, #2C2C2C, left);
                font-weight: bold;
                line-height: 130%;
                padding: 5px 15px 0px;

                max-height: 70px;
                overflow: hidden;

            }


            &-description {
                padding: 0px 15px 20px;
                margin-top: 5px;
                max-height: 90px;
                overflow: hidden;
                position: relative;

                &:after{
                    position: absolute;
                    bottom: 0px;
                    right: 0;
                    left: 0;
                    box-shadow: -5px -13px 17px 8px #fff;
                    content: "";
                    height: 0px;
                }

                p {
                    @include text-usual(14px, #2F2F2F, left);
                }

                ul {
                    list-style: none !important;
                    padding-left: 10px !important;
                    margin-bottom: 0px !important;
                    li {
                        @include text-usual(14px, #2F2F2F, left);
                    }
                }
            }

            &-location {
                @include text-usual(14px, #2F2F2F, left);

                position: relative;
                padding-left: 35px;
                margin-top: 8px;

                &:before {
                    width: 16px;
                    height: 16px;
                    position: absolute;
                    top: 2px;
                    left: 10px;
                    content: url("/images/location-point.svg");
                }
            }

            &-more {
                @include text-usual(14px, $violet, left);
                padding-left: 15px;
            }
        }



        &_description {
            &-wrapper {
                max-width: 675px;
                margin-left: auto;
                margin-right: auto;
                width: 100%;
            }

            &-title {
                @include text-usual(32px, #121212, left);
                font-weight: bold;
                margin-bottom: 24px;
                word-wrap: break-word;
            }





            &-text {
                margin-top: 24px;
                margin-bottom: 40px;
                @include text-usual(14px, #212529, left);
            }

            &-map {
                width: 100%;
                height:300px;
                background: url(/images/map-background.svg) center center no-repeat;
                margin-bottom: 40px;
            }

            &-contacts-title {
                @include text-usual(16px, #2C2C2C, left);
                font-weight: bold;
                margin-bottom: 12px;
            }

            &-footer {
                display: flex;
                flex-direction: row;
                flex-wrap: nowrap;
                justify-content: space-between;
            }

            &-date {
                @include text-usual(14px, #B0B0B0, left);
                font-style: italic;
            }

            &-abuse {
                @include text-usual(14px, #B0B0B0, left);
                padding-left: 25px;
                position: relative;
                display: block;

                &:before {
                    content: url(/images/flag-icon.png);
                    width: 16px;
                    height: 16px;
                    position: absolute;
                    top: 0;
                    left: 0;
                }
            }
        }

        &_form {

            .tip {
                @include text-usual(14px, $black, center);
            }

            .operation-result {
                @include text-usual(14px, $violet, center);
                display: none;
                margin-top: -20px;

                &.show {
                    display: block;
                }
            }

            .remove-account-link {
                @include text-usual(16px, $violet, center);
                cursor: pointer;
                margin-top: 30px;

                margin-left: auto;
                margin-right: auto;
                display: block;
                &:hover {
                    text-decoration: underline;
                }
            }

            &-title {
                @include text-usual(20px, $black, center);
                margin-top: 35px;
                margin-bottom: 25px;
            }

            width: 290px;

            @include for-tablet-portrait-up() {
                width: 100%;
            }

            margin: 0 auto;
            margin-top: 20px;

            &-date-group {
                margin-right: 25px;
                flex-direction: column;
                display: flex;
                flex-wrap: nowrap;

                @include for-desktop-up() {
                    flex-direction: row;
                    flex-wrap: nowrap;
                    justify-content: space-between;
                    min-width: 385px;
                    max-width: 385px;
                    margin-left: 30px;
                    margin-right: 25px;
                    align-items: center;
                }
            }



            &-group {
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
                width: 100%;
                position: relative;
                margin-left: auto;
                margin-right: auto;
                margin-bottom: 24px;


                .file-upload {
                    background-color: #ffffff;
                    width: 600px;
                    margin: 0 auto;
                    padding: 20px;
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
                    background: #1AA059;
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
                    border: 4px dashed #1FB264;
                    position: relative;
                }

                .image-dropping,
                .image-upload-wrap:hover {
                    background-color: #1FB264;
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
                    color: #15824B;
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
                        @include text-usual(18px, $black, center);
                        margin-bottom: 20px;
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
                        @include for-desktop-up() {
                            min-width: 100px;
                            margin: 0;
                        }
                    }

                    .select2 {
                        @include for-desktop-up() {
                            min-width: 200px;
                            margin-right: 0;
                        }
                    }

                    @include for-desktop-up() {
                        flex-direction: row;
                        flex-wrap: nowrap;
                        justify-content: space-between;
                        min-width: 385px;
                        max-width: 385px;
                        margin-left: 30px;
                        margin-right: 25px;
                    }

                }

                &.description {
                    @include for-desktop-up() {
                        flex-direction: column;
                        align-items: start;
                        padding-right: 25px;
                        .trumbowyg-box {
                            max-width: 100%;
                            margin-left: 0;
                            margin-right: 0;
                        }
                    }
                }

                .message-invalid {
                    @include text-usual(12px, $red, left);
                    position: absolute;
                    bottom: -20px;
                    left: 0px;

                    @include for-tablet-portrait-up() {
                        bottom: -20px;
                        left: 160px;
                    }
                }

                &:last-child {
                    margin-bottom: 0px;
                }

                @include for-tablet-portrait-up() {
                    flex-direction: row;
                    justify-content: flex-end;
                    width: 570px;
                    align-items: center;
                }

                &-label {
                    @include  text-usual(14px, $black, left);
                    padding-top: 7px;
                    padding-bottom: 7px;


                    @include for-tablet-portrait-up() {
                        @include  text-usual(16px, $black, right);
                        padding-top: 0px;
                        padding-bottom: 0px;
                        line-height: 120%;
                    }
                }

                &-input {
                    height: 42px;
                    width: 100%;
                    max-width: 385px;
                    background: #FFFFFF;
                    border: 1px solid #E8ECEE;
                    box-sizing: border-box;
                    border-radius: 0px;


                    &.datePicker {
                        margin-left: 0;
                        width: 160px;
                        min-width: 160px;
                    }

                    &.timePicker {
                        margin-right: 0;
                        width: 125px;
                        min-width: 125px;
                    }

                    @include text-usual(16px, $black, left);
                    padding: 3px 20px;

                    @include for-tablet-portrait-up() {
                        margin-left: 15px;
                        margin-right: 25px;
                        min-width: 385px;
                    }

                    &:focus {
                        outline: none;
                    }

                    &::placeholder {
                        @include text-usual(16px, #cccccc, left);
                    }

                    &.textarea {
                        height: 200px;
                    }
                }

                &-select ~ span{
                    height: 42px;
                    width: 100%;
                    max-width: 385px;
                    background: #FFFFFF;
                    border: 1px solid #E8ECEE;
                    box-sizing: border-box;
                    border-radius: 0px;
                    display: flex;
                    align-items: center;

                    @include text-usual(18px, $black, left);
                    padding: 3px 20px;

                    @include for-tablet-portrait-up() {
                        margin-left: 30px;
                        margin-right: 25px;
                        min-width: 385px;
                    }

                    &:focus {
                        outline: none;
                    }
                }

                .show-password {
                    position: absolute;
                    width: 20px;
                    height: 20px;
                    cursor: pointer;

                    right: 10px;
                    top: 45px;

                    @include for-tablet-portrait-up() {
                        right: 35px;
                        top: 12px;
                    }

                    background: url(/images/show-password-icon.svg);
                }
            }
        }
    }

</style>


