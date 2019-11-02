@extends('layouts.site')

@section('content')
    <div class="container-fluid events">

        <div class="container">
            <div class="row mx-0">

                <div class="col-sm-8 card-wrapper" id="dynWrapper">


                </div>
            </div>
        </div>

    </div>


@endsection

@section('pagescript')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            /*  When user click add user button */
            $('#create-new-user').click(function () {
                $('#btn-save').val("create-user");
                $('#userForm').trigger("reset");
                $('#userCrudModal').html("Add New User");
                $('#ajax-crud-modal').modal('show');
            });




            $.get('eventsDyn/', function (data) {

                var received = JSON.parse(data);

                function myFunction(item, index) {
                    $('#dynWrapper').append( '<a class="card event-card event-card-admin" href="/events/' + item.id + '>\
                        <div class="event-header">\
                        <div class="event-time">\
                        <p>, <span></span></p>\
                        </div>\
                        <img src="' + item.image +'" class="event-card-img">\
                        </div>\
                        <p class="event-location"></p>\
                        <h3 class="event-title">' + item.title +'</h3>\
                        <div class="event-description">\
                        <p class="desc-wrapper">  </p>\
                        </div>\
                    </a>');
                    console.log( $('#dynWrapper'));

                }

                received.data.forEach(myFunction);
            })



            $('body').on('click', '#edit-user', function () {
                var user_id = $(this).data('id');
                $.get('ajax-crud/' + user_id +'/edit', function (data) {
                    $('#userCrudModal').html("Edit User");
                    $('#btn-save').val("edit-user");
                    $('#ajax-crud-modal').modal('show');
                    $('#user_id').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                })
            });
            //delete user login
            $('body').on('click', '.delete-user', function () {
                var user_id = $(this).data("id");
                confirm("Are You sure want to delete !");

                $.ajax({
                    type: "DELETE",
                    url: "{{ url('ajax-crud')}}"+'/'+user_id,
                    success: function (data) {
                        $("#user_id_" + user_id).remove();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            });
        });

        if ($("#userForm").length > 0) {
            $("#userForm").validate({

                submitHandler: function(form) {

                    var actionType = $('#btn-save').val();
                    $('#btn-save').html('Sending..');

                    $.ajax({
                        data: $('#userForm').serialize(),
                        url: "https://www.tutsmake.com/laravel-example/ajax-crud/store",
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            var user = '<tr id="user_id_' + data.id + '"><td>' + data.id + '</td><td>' + data.name + '</td><td>' + data.email + '</td>';
                            user += '<td><a href="javascript:void(0)" id="edit-user" data-id="' + data.id + '" class="btn btn-info">Edit</a></td>';
                            user += '<td><a href="javascript:void(0)" id="delete-user" data-id="' + data.id + '" class="btn btn-danger delete-user">Delete</a></td></tr>';


                            if (actionType == "create-user") {
                                $('#users-crud').prepend(user);
                            } else {
                                $("#user_id_" + data.id).replaceWith(user);
                            }

                            $('#userForm').trigger("reset");
                            $('#ajax-crud-modal').modal('hide');
                            $('#btn-save').html('Save Changes');

                        },
                        error: function (data) {
                            console.log('Error:', data);
                            $('#btn-save').html('Save Changes');
                        }
                    });
                }
            })
        }
    </script>
@endsection
